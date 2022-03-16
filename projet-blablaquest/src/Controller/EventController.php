<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Comments;
use App\Form\EventType;
use App\Repository\CommentsRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/event", name="event_", requirements={"id"="\d+"})
 */
class EventController extends AbstractController
{

    /**
     * On injecte le manager dans le controleur
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="browse", requirements={"id"="\d+"}))
     */
    public function browse(EventRepository $eventRepository): Response
    {
        return $this->render('event/browse.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }


    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Event $event): Response
    {
        // On précise qu'on associe $event à notre formulaire
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
        $this->manager->flush();

        $this->addFlash('success', 'L\'évènement a bien été modifié.');

        return $this->redirectToRoute('event_browse');

        }

        return $this->render('event/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(EntityManagerInterface $manager, Event $event)
    {
        // On souhaite supprimer $event de la BDD
        // On a besoin de l'entity manager
        
        $manager->remove($event);
        $manager->flush();

        $this->addFlash('success', 'L\'évènement a bien été supprimé.');

        // On redirige vers la liste des séries
        return $this->redirectToRoute('event_browse');
    }

    /**
     * @Route("/comment", name="comment_browse")
     */
    public function browseComment(CommentsRepository $commentsRepository): Response
    {
        return $this->render('comment/browse.html.twig', [
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    
     /**
     * @Route("/comment/delete/{id}", name="comment_delete")
     */
    public function deleteComment(EntityManagerInterface $manager, Comments $comment)
    {
        // On souhaite supprimer $comment de la BDD
        // On a besoin de l'entity manager
        
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash('success', 'Le commentaire a bien été supprimé.');

        // On redirige vers la liste des séries
        return $this->redirectToRoute('event_comment_browse');
    }
}