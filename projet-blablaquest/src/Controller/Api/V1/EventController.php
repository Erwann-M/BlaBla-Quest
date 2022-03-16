<?php

namespace App\Controller\Api\V1;

use App\Entity\Event;
use App\Form\EventType;
use App\Entity\Comments;
use App\Form\CommentType;
use App\Entity\Participation;
use Doctrine\ORM\EntityManager;
use App\Repository\EventRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/api/v1/event", name="api_v1_event_", requirements={"id"="\d+", "area"="\d+"})
 */
class EventController extends AbstractController
{

    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(EventRepository $eventRepository): Response
    {

        return $this->json(
            $eventRepository->findAll(),
            200,
            [],
            ['groups' => ['event_browse']]
        );
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Event $event): Response
    {
        /**
         * json($data, $statusCode, $headers, $context)
         * @param mixed $data L'objet ou le tableau à sérialiser en JSON
         * @param int $statutsCode Le code de statut de réponse HTTP
         * @param array $headers Des entêtes HTTP supplémentaires dans la réponse
         * @param array $context Des options à envoyer à la méthode json() pour sérialiser $data
         */

        return $this->json($event, 200, [], [
            'groups' => ['event_read']
        ]);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(EntityManagerInterface $manager, Request $request)
    {

        $event = new Event();
        $form = $this->createForm(EventType::class, $event, ['csrf_protection' => false]);

        // On récupère le JSON reçu depuis le client (Insomnia ou une application)
        $json = $request->getContent();
        // On décode le JSON pour obtenir un tableau associatif
        $jsonArray = json_decode($json, true);

        // On associe le tableau associatif au formulaiire
        $form->submit($jsonArray);

        if ($form->isValid()) {

            // On associe le user connecté à la question
            $event->setUser($this->getUser());

            $manager->persist($event);
            $manager->flush();

            // Une méthode de controleur doit toujours retourner un objet Response
            return $this->json($event, 201, [], [
                'groups' => ['event_read'],
            ]);
        }
        // Le formulaire n'est pas valide, ça veut dire que le JSON envoyé n'est pas conforme
        // On récupère les erreurs dans $form

        $errorMessages = (string) $form->getErrors(true);
        // On retourne un objet Response avec les erreurs et un code HTTP
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     */
    public function edit(Event $event, EntityManagerInterface $manager, Request $request)
    {
        //access is refused unless the user is the organizer or the admin
        $this->denyAccessUnlessGranted('EVENT_EDIT', $event);

        $form = $this->createForm(EventType::class, $event, ['csrf_protection' => false]);

        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isValid()) {
            $manager->flush();

            return $this->json($event, 200, [], [
                'groups' => ['event_read'],
            ]);
        }

        $errorMessages = (string) $form->getErrors(true);

        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Event $event, EntityManagerInterface $manager)

    {

        //access is refused unless the user is the organizer or the admin
        $this->denyAccessUnlessGranted('EVENT_EDIT', $event);

        $manager->remove($event);
        $manager->flush();

        return $this->json(null, 204);
    }


    /**
     * @Route("/area/{area}", name="browse_area", methods={"GET"})
     */
    public function browseArea(EventRepository $eventRepository, Request $request): Response
    {
        $area = $request->get('area');

        // ['status' => 0], ['dateTime' => 'ASC']
        return $this->json(
            $eventRepository->findBy(['area' => $area, 'status' => 0], ['dateTime' => 'ASC']),
            200,
            [],
            ['groups' => ['event_browseByArea']]
        );
    }

    /**
     * @Route("/{id}/comment", name="browse_comment", methods={"GET"})
     */
    public function browseComment(Event $event): Response
    {
        return $this->json($event, 200, [], [
            'groups' => ['event_browse']
        ]);
    }

    /**
     * @Route("/{id}/comment", name="add_comment", methods={"POST"})
     */
    public function addComment(EntityManagerInterface $manager, Request $request, Event $event)
    {

        $comments = new Comments();
        $form = $this->createForm(CommentType::class, $comments, ['csrf_protection' => false]);

        // On récupère le JSON reçu depuis le client (Insomnia ou une application)
        $json = $request->getContent();
        // On décode le JSON pour obtenir un tableau associatif
        $jsonArray = json_decode($json, true);

        // On associe le tableau associatif au formulaiire
        $form->submit($jsonArray);

        if ($form->isValid()) {

            // On associe le user connecté à la question
            $comments->setUser($this->getUser());
            $comments->setEvent($event);

            $manager->persist($comments);
            $manager->flush();

            // Une méthode de controleur doit toujours retourner un objet Response
            return $this->json($comments, 201, [], [
                'groups' => ['event_read'],
            ]);
        }
        // Le formulaire n'est pas valide, ça veut dire que le JSON envoyé n'est pas conforme
        // On récupère les erreurs dans $form

        $errorMessages = (string) $form->getErrors(true);
        // On retourne un objet Response avec les erreurs et un code HTTP
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/comment/{id}", name="edit_comment", methods={"PUT", "PATCH"})
     */
    public function editComment(Comments $comments, EntityManagerInterface $manager, Request $request)
    {
        $this->denyAccessUnlessGranted('COMMENT_EDIT', $comments, 'Accès interdit. Vous n\'êtes pas l\'auteur du commentaire');

        $form = $this->createForm(CommentType::class, $comments, ['csrf_protection' => false]);

        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isValid()) {
            $manager->flush();

            return $this->json($comments, 200, [], [
                'groups' => ['event_read'],
            ]);
        }

        $errorMessages = (string) $form->getErrors(true);

        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/comment/{id}", name="delete_comment", methods={"DELETE"})
     */
    public function deleteComment(Comments $comments, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('COMMENT_DELETE', $comments, 'Accès interdit. Vous n\'êtes pas l\'auteur du commentaire');

        $manager->remove($comments);
        $manager->flush();

        return $this->json(null, 204);
    }

    /**
     * @Route("/{id}/participation", name="browse_participation", methods={"GET"})
     */
    public function browseParticipation(Event $event): Response
    {
        return $this->json($event, 200, [], [
            'groups' => ['participation_browse'],
        ]);
    }
}
