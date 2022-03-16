<?php

namespace App\Service;

use Throwable;
use Goutte\Client;
use App\Entity\Game;
use App\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;
use App\DataFixtures\CategoryDataFixtures;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// DOC:
// https://github.com/FriendsOfPHP/Goutte
// https://symfony.com/doc/current/components/css_selector.html
// https://symfony.com/doc/current/components/dom_crawler.html

class Scraping extends AbstractController
{


    // private $scraping;
    private $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    // First scrap for initial generation of DB
    public static function initialScraping(EntityManagerInterface $manager, int $pageToScrap)
    {

        //===========================================
        //              CATEGORIES
        // ==========================================

        // call the function createCategories() +  After persist(), stack categories in $gamesEntities for after (events fixtures and games fixtures)
        // Prepare a variable with all the categories created for after (games fixtures)
        // $categoriesEntities is an array with all categories finded in Fixtures/CategoryDataFixtures.php



        // Create a Goutte Client instance (which extends Symfony\Component\BrowserKit\HttpBrowser) with custom setings
        $client = new Client(HttpClient::create(['timeout' => 60]));

        // Go to the philibert.com all board games classed by notes, ordered by DESC
        // The method returns a Crawler object (Symfony\Component\DomCrawler\Crawler)
        $crawler = $client->request('GET', 'https://www.philibertnet.com/fr/50-jeux-de-societe/s-3/langue-francais/categorie-jeux_de_societe?orderby=sales&orderway=desc');




        //TODO Number of page you want to scrap
        //=============================================================
        // $pageToScrap = 2;
        //=============================================================




        // The script for tscraping can be long, so we add a progress bar in our console:
        // creates a new progress bar (100 units)
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, (48 * $pageToScrap));
        $progressBar->setFormat('Scraping: %percent:3s%%(%current%/%max%) [%bar%] remaining: %remaining:-6s%' . PHP_EOL);
        $progressBar->start();
        $progressCount = 0;

        // Set the var used to move to the next page (int '2' needed after the first page scraped)
        $urlIncrementation = 1;


        for ($i = 1; $i <= $pageToScrap; $i++) {


            //* Cycle on every game displayed on the page:

            // Go to the page of the first game listed by using CssSelector
            $links = $crawler->filter('p.s_title_block > a')->links();



            // Set some variables (int) for logs in the terminal:

            if (isset($NewGameScraped)) {
                $gameScraped = $NewGameScraped;
            } else {
                $gameScraped = 0;
            }

            $failure = 1;


            // Loop pour each games finded in the page:
            foreach ($links as $link) {

                sleep(1);

                $crawler = $client->click($link);

                // ===========================================================
                //                      Exclusion list
                // ===========================================================

                //* Check if the selected game isnt an extension by looking for ne word "extension" in his description.
                // * In this case, we dont want to flush him in DB

                // Select the description

                $description = $crawler->filter('#short_description_content')->text();

                // Try to find the word "extension" in the text, and stop the work to move to the next game
                // Exlude some books editors
                if (
                    str_contains($description, 'extension') === true
                    || str_contains($description, 'Editions de Tournon') === true
                    || str_contains($description, 'Warhammer') === true
                ) {
                    continue;
                }

                // TODO exclure les `Editeur` d'édition de magazine (ex: Editions de Tournon, Games workshop, )

                // ===========================================================
                //                         End Exclude
                // ===========================================================



                // ===========================================================
                //                     Scrap what we need:
                // ===========================================================



                // ===========================================================
                //                          Add games
                // ===========================================================

                // Set a try/catch to avoids end of script in error case
                try {


                    $game = new Game();
                    //* If the game isnt in the exclusion list, go ahead:

                    // Select the game title:
                    $name = $crawler->filter('h1')->text();
                    $game->setName($name);

                    $game->setDescription($description);


                    // Select the image of the game and get his uri:
                    // for some games, we need to explode the name tout find the alt, cause the ///'alt'
                    // doesnt contain the integrality of the string (haystack = botte de foin)

                    // Select the image of the game and get his uri:
                    $picture = $crawler->selectImage($name)->image()->getUri();
                    $game->setPicture($picture);

                    // Select the minimum age needed to play the game:
                    // Find the span where the age is
                    $ageInString = $crawler->filter('li.age')->text();

                    // Use a regex to find the age ----- preg_split — Split string by a regular expression -----
                    $ageArray = array_filter(preg_split("/\D+/", $ageInString));
                    $age = $ageArray[1];

                    $game->setAgeMin($age);



                    // Select the playtime:
                    // Find the span where the playtime is
                    if (null === ($crawler->filter('li.duree_partie')->text())) {
                        $playtime = 'Jusqu\'à l\'infini est au delà !';
                        $game->setPlaytime($playtime);
                    } else {
                        $playtime = $crawler->filter('li.duree_partie')->text();
                        $game->setPlaytime($playtime);
                    };


                    // Select the playersMin and playersMax:
                    // Find the span where min/max are
                    $playersNbInString = $crawler->filter('li.nb_joueurs')->text();

                    // Use a regex to find the player number ----- preg_split — Split string by a regular expression -----
                    $playersNb = array_filter(preg_split("/\D+/", $playersNbInString));

                    // Check if a minimum of players exist (games for 2 players are made for exactly 2 players)

                    if (array_key_exists(1, $playersNb)) {
                        $playersMax = $playersNb[1];
                    }

                    $playersMin = $playersNb[0];

                    $game->setPlayersMin($playersMin);
                    $game->setPlayersMax($playersMax);


                    // * Select categories:

                    $categoriesDatas = CategoryDataFixtures::getData();

                    // dd($categoriesDatas);

                    $categoriesArray = [];


                    foreach ($categoriesDatas as $category) {
                        $count = $crawler->filter("td > span:contains('$category')")->count();

                        if ($count > 0) {
                            $categoriesArray[] = $crawler->filter("td > span:contains('$category')")->text();
                        }
                    }

                    foreach ($categoriesArray as $category) {
                        $categoryUpdate = new Category;
                        $categoryUpdate->setName($category);

                        $game->addCategory($categoryUpdate);

                        $manager->persist($categoryUpdate);
                    }
                } catch (Throwable $e) {

                    $failure++;

                    continue;
                }

                $manager->persist($game);
                $manager->flush($game);

                // Stock all game entities for using it after (events fixtures)
                $games[] = $game;


                // For logs in the console:
                $gameScraped++;
                $NewGameScraped = $gameScraped;
                $progressBar->advance();
            }
            sleep(20);

            $urlIncrementation++;


            // Go to the next page
            $crawler = $client->request('GET', 'https://www.philibertnet.com/fr/50-jeux-de-societe/s-3/langue-francais/categorie-jeux_de_societe?orderby=sales&orderway=desc&p=' . $urlIncrementation);

        }



        // Stop the progress bar
        $progressBar->finish();
        // Clean it to display something else
        $progressBar->clear();

        print($gameScraped . ' jeux ont été ajoutés à la DB !' . PHP_EOL);
        print($failure . ' jeux n\'ont pas réussi à être ajoutés à la DB.' . PHP_EOL);

        return $games;
    }

    public function dailyScraping()
    {
        echo 'dailol';
        print 'dailol';
    }

    /**
     * Set the value of crawler
     *
     * @return  self
     */
    public function setCrawler($crawler)
    {
        $this->crawler = $crawler;

        return $this;
    }
}
