<?php

namespace App\Controller\Api\V1;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/v1/game", name="api_v1_game_", requirements={"id"="\d+"})
 */
class GameController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(GameRepository $gameRepository): Response
    {
        /**
         * json($data, $statusCode, $headers, $context)
         * @param mixed $data The object or the array to serialize in JSON
         * @param int $statutsCode The status code of the response HTTP
         * @param array $headers HTTP'headers supp for the response
         * @param array $context options to add in json to serialize $data
         */

        // Recuperation of the last 10 games
        return $this->json(
            $gameRepository->findAll(),
            200,
            [],
            ['groups' => ['game_browse']]
        );
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Game $game): Response
    {
        return $this->json($game, 200, [], [
            'groups' => ['game_read']
        ]);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(EntityManagerInterface $manager, Request $request)
    {
        $game = new Game();

        // Recuperation of the FormType previously create 
        $form = $this->createForm(GameType::class, $game, ['csrf_protection' => false]);

        // Converting the request in an associative array
        $jsonArray = json_decode($request->getContent(), true);

        // Submit datas to the form
        $form->submit($jsonArray);

        // Send datas in the DB if it's valid
        if ($form->isValid()) {
            
            $manager->persist($game);
            $manager->flush();

            // Return the response HTTP "Created" and the datas
            return $this->json($game, 201, [], [
                'groups' => ['game_read'],
            ]);
        }

        // For each errors with the form returned by the API it stock a message in an array befaore returning it.
        $errorMessages = [];
        foreach ($form->getErrors(true) as $error) {
            $errorMessages[] = [
                'message' => $error->getMessage(),
                'property' => $error->getOrigin()->getName(),
            ];
        }

        // Return the array with all errors and the status code of the response HTTP
        return $this->json($errorMessages, 400);
    }
}
