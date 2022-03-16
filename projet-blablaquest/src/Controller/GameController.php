<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/game", name="game_", requirements={"id"="\d+"})
 */
class GameController extends AbstractController
{

    /**
     * On injecter le manager dans le controleur
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("", name="browse")
     */
    public function browse(GameRepository $gameRepository): Response
    {
        return $this->render('game/browse.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        // On crée un nouvel objet Game
        $game = new Game();

        // On précise qu'on associe $game à notre formulaire
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->persist($game);
            $this->manager->flush();

            $this->addFlash('success', 'Le jeu a bien été ajouté.');

            return $this->redirectToRoute('game_browse');
        }

        return $this->render('game/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Game $game): Response
    {
        // On précise qu'on associe $game à notre formulaire
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            $this->addFlash('success', 'Le jeu a bien été modifié.');

            return $this->redirectToRoute('game_browse');
        }

        return $this->render('game/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(EntityManagerInterface $manager, Game $game)
    {
        // On souhaite supprimer $game de la BDD
        // On a besoin de l'entity manager

        $manager->remove($game);
        $manager->flush();

        $this->addFlash('success', 'Le jeu a bien été supprimé.');

        // On redirige vers la liste des séries
        return $this->redirectToRoute('game_browse');
    }
}
