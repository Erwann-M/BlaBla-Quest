<?php

namespace App\DataFixtures;

use Throwable;
use Faker\Factory;
use App\Entity\Game;
use App\Entity\User;
use App\Entity\Event;
use App\Entity\Category;
use App\Entity\Comments;
use App\Service\Scraping;
use App\Entity\Participation;
use App\Command\InitialScrapingCommand;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// doc: 
// https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html
// https://github.com/fzaninotto/Faker
// https://symfony.com/doc/5.4/security.html#registering-the-user-hashing-passwords
// https://symfony.com/doc/current/components/console/helpers/progressbar.html
// And a search in vendor/fakerphp/faker/src/Faker/Provider

class AppFixtures extends Fixture
{
    private $passwordHasher;

    // Making the parameter for passwords hashing in the construct
    public function __construct(UserPasswordHasherInterface $passwordHasher, $pageToScrap = 1)
    {
        $this->passwordHasher = $passwordHasher;
        $this->pageToScrap = $pageToScrap;
    }

    public function load(ObjectManager $manager): void
    {

        // ========================================
        // TODO to set fixtures:
        // ========================================

        // Set the number of games pages you want to scrap:

        $pageToScrap = 5;

        // Set the number of users wanted:

        $usersToCreate = 200;

        // ========================================
        // TODO to set fixtures: end
        // ========================================




        // Initialisation of Faker
        $faker = Factory::create('fr_FR');


        $gamesEntities = $this->createCategoriesAndGames($manager, $pageToScrap);


        //===========================================
        // FIXTURES FOR USERS
        // ==========================================

        // call the function createUsers() +  Prepare a variable with all the users created for after (events fixtures)
        // $userEntities is an array with all users created

        $usersEntities = $this->createUsers($manager);


        // User account randomly generated

        // The script for the generation of user fixtures can be a bit long, so we add a progress bar in our console:
        // creates a new progress bar (1000 units)
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $usersToCreate);
        $progressBar->setFormat('User fixtures: %percent:3s%%(%current%/%max%) [%bar%] remaining: %remaining:-6s%');
        $progressBar->start();
        $progressCount = 0;

        while ($progressCount++ < $usersToCreate) {
            $user = new User();

            // Random nickname faker:
            // Array with multiple random properties, who will be concatenated after, to make a "funy and realist" nickname
            $nicknamesArray = [

                $faker->colorName(),

                // Instanciation of the Faker Factory for US names
                Factory::create('en_US')->cityPrefix(),

                // Ternary operator used to randomly determine a gender for the title (here, Ms. or Mr.)
                $faker->title($gender = (mt_rand(0, 1) ? 'male' : 'female')),

                $faker->word(),
                // Ternary operator used to randomly determine a firstname
                $faker->firstName($gender = (mt_rand(0, 1) ? 'male' : 'female')),

                // Same with US version
                Factory::create('en_US')->firstName($gender = (mt_rand(0, 1) ? 'male' : 'female')),

                // Same with PT version
                Factory::create('pt_PT')->firstName($gender = (mt_rand(0, 1) ? 'male' : 'female')),

                // Same with JP version
                Factory::create('ja_JP')->lastNameAscii(),
                Factory::create('ja_JP')->firstNameAscii(),

                $faker->region(),
                $faker->departmentNumber(),

            ];

            try {
                // Mix 2 random words from the previous array ($nicknamesArray)
                $nickname = ($faker->randomElement($nicknamesArray)) . ($faker->randomElement($nicknamesArray));

                // If the ramdomly regenerated  nickname doesnt exist in our stock, apply next steps
                if (!array_key_exists($nickname, $usersEntities)) {
                    $user->setNickname($nickname);

                    // Injection of the user nickname in the mail
                    $user->setEmail($nickname . '@' . $faker->freeEmailDomain);

                    $user->setPicture($faker->imageUrl($width = 640, $height = 480, $nickname));

                    // Hash password (who is the user nickname)
                    $user->setPassword($this->passwordHasher->hashPassword($user, $nickname));
                    $user->setRoles(['ROLE_USER']);
                    $user->setCreatedAt(new \DateTimeImmutable());
                    $user->setArea(mt_rand(1, 95));

                    $manager->persist($user);

                    // After persist(), stack users in $usersEntities for after (events fixtures)
                    $usersEntities[] = $user;
                }
            }  catch (Throwable $e) {

                continue;

            }

            // Incremente the progress bar each iteration
            $progressBar->advance();
        }

        // Stop the progress bar
        $progressBar->finish();
        // Clean it to display something else
        $progressBar->clear();

        print 'Users added !' . PHP_EOL;


        //===========================================
        // FIXTURES FOR EVENTS
        // ==========================================
        for ($i = 0; $i < 600; $i++) {
            $event = new Event();

            $event->setName($faker->catchPhrase());
            $event->setDescription($faker->realText($maxNbChars = 300, $indexSize = 2));
            $event->setEntrantsNumbers(mt_rand(2, 7));
            $furturRandDate = (mt_rand(5, 20));
            $date = (new \DateTimeImmutable("+" . $furturRandDate . "days"));
            $event->setDateTime($date);
            $event->setArea(mt_rand(1, 95));
            $event->setTotalUsersValidated(1);

            // Link the event with a game and a user
            $event->setGame($faker->randomElement($gamesEntities));
            $event->setUser($faker->randomElement($usersEntities));

            $manager->persist($event);

            // After persist(), stack events in $eventsEntities for after (comments fixtures)
            $eventsEntities[] = $event;
        }

        //// add users on event
        //foreach ($eventsEntities as $event) {
        //    // Shuffle $usersEntities to pick 1 to 3 of them
        //    shuffle($usersEntities);
        //    $categoryCount = mt_rand(1, 3);
        //    for ($i = 1; $i <= $categoryCount; $i++) {
        //        $event->addUser($usersEntities[$i]);
        //    }
        //}
        //
        //print 'Events added !' . PHP_EOL;



        //===========================================
        // FIXTURES FOR COMMENTS
        // ==========================================

        foreach ($eventsEntities as $event) {
            for ($i = 0; $i < (mt_rand(2, 6)); $i++) {
                $comments = new Comments();

                $comments->setContent($faker->realText($maxNbChars = 200, $indexSize = 2));
                $comments->setEvent($event);
                $comments->setUser($faker->randomElement($usersEntities));
                $comments->setCreatedAt(new \DateTimeImmutable());
                $manager->persist($comments);
            }
        }

        print 'Comments added !' . PHP_EOL;



        //===========================================
        // FIXTURES FOR PARTICIPATION
        // ==========================================

        // Set participation + event.totalUsersValidated + event.status
        foreach ($eventsEntities as $event) {
            for ($i = 0; $i < (mt_rand(2, 6)); $i++) {
                $participation = new Participation();

                $participation->setEvent($event);
                $participation->setUser($faker->randomElement($usersEntities));
                $participation->setCreatedAt(new \DateTimeImmutable());

                $randUserStatus = (mt_rand(0, 2));

                switch ($randUserStatus) {
                    case 0:
                        $participation->setIsRefused(true);
                        break;
                    case 1:

                        if ($event->getTotalUsersValidated() < $event->getEntrantsNumbers()) {

                            $participation->setIsValidated(true);
                            $totalUsersValidated = $event->getTotalUsersValidated();
                            $event->setTotalUsersValidated($totalUsersValidated + 1);
                        }

                        if ($event->getTotalUsersValidated() == $event->getEntrantsNumbers()) {

                            $event->setStatus(1);
                        } else {
                            $event->setStatus(0);
                        }

                        $manager->persist($event);
                        break;
                }

                $manager->persist($participation);
            }
        }

        print 'Participation added !' . PHP_EOL;

        // Finaly, injection of our $manager in DB !!!!!! :D
        $manager->flush();
    }

    // Generation of users explode. datas in DataFixtures/UserDataFixtures.php
    //
    public function createUsers(ObjectManager $manager)
    {
        $users = [];

        foreach (UserDataFixtures::getData() as $userData) {
            $user = new User();
            $user->setNickname($userData['nickname']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));
            $user->setPicture($userData['picture']);
            $user->setRoles(($userData['roles']));
            $user->setArea(mt_rand(1, 95));

            $manager->persist($user);

            $users[] = $user;
        }

        return $users;
    }

    public function createCategoriesAndGames(EntityManagerInterface $manager, $pageToScrap)
    {
        return Scraping::initialScraping($manager, $pageToScrap);
    }
}
