<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/participation", name="participation_", requirements={"id"="\d+"})
 */
class ParticipationController extends AbstractController
{

    /**
     * On injecte le manager dans le controleur
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("", name="browse")
     */
    public function browse(ParticipationRepository $participationRepository): Response
    {
        return $this->render('participation/browse.html.twig', [
            'participations' => $participationRepository->findAll(),
        ]);
    }


    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Participation $participation): Response
    {
        // On précise qu'on associe $participation à notre formulaire
        $form = $this->createForm(ParticipationType::class, $participation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
        $this->manager->flush();

        $this->addFlash('success', 'La participation a bien été modifié.');

        return $this->redirectToRoute('participation_browse');

        }

        return $this->render('participation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(EntityManagerInterface $manager, Participation $participation)
    {
        // On souhaite supprimer $participation de la BDD
        // On a besoin de l'entity manager
        
        $manager->remove($participation);
        $manager->flush();

        $this->addFlash('success', 'La participation a bien été supprimé.');

        // On redirige vers la liste des séries
        return $this->redirectToRoute('participation_browse');
    }
}