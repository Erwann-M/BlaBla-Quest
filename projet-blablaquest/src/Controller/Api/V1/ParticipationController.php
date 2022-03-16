<?php

namespace App\Controller\Api\V1;

use App\Entity\Event;
use App\Entity\Participation;
use App\Form\ParticipationType;
use Doctrine\ORM\EntityManager;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/v1/participation", name="participation_", requirements={"id"="\d+", "event"="\d+"})
 */
class ParticipationController extends AbstractController
{
    /**
     * @Route("/{id}", name="add", methods={"POST"})
     */
    public function add(EntityManagerInterface $manager, Event $event, Request $request, ParticipationRepository $participationRepository, int $id)
    {

        //* Before all, check if the event is still open (event status = 0)
        $eventStatus = $event->getStatus();
        
        if ($eventStatus == 1) {

            throw $this->createAccessDeniedException('L\'évenement est complet... N\'hésite pas à créer le tiens ! :)');
        }

        //* Deserialize the json

        $participation = new Participation();
        $form = $this->createForm(ParticipationType::class, $participation, ['csrf_protection' => false]);
        
        // On récupère le JSON reçu depuis le client (Insomnia ou une application)
        $json = $request->getContent();
        // On décode le JSON pour obtenir un tableau associatif
        $jsonArray = json_decode($json, true);
        
        // On associe le tableau associatif au formulaiire
        $form->submit($jsonArray);
        
        // dd($event->getUser(), $participation->getUser());
        
        //* Check if the user isnt the creator of the event
        if ($event->getUser() == $participation->getUser()) {

            throw $this->createAccessDeniedException('You cant apply to your own event my litle coquinoux ! <3 ');
        }

        //* Check if the participation already exist:

        // Find the user ID
        $userId = $participation->getUser()->getId();

        // Find users already participanting via a queryBuilder
        $participants = $participationRepository->findAllParticipant($id);

        // Set a status
        $isUnique = true;

        // Look in the array of participants if the applayant already exist.
        // If he is, throw an exception
        foreach ($participants as $participant) {

            if ($participant->getUser()->getId() == $userId) {

                $isUnique = false;
                throw $this->createAccessDeniedException('Utilisateur déjà lié à l\'évenement.');
            }
        }

        //* Else, flush the participation

        if ($form->isValid() && ($isUnique === true)) {
            
            $manager->persist($participation);
            $manager->flush();

            // Une méthode de controleur doit toujours retourner un objet Response
            return $this->json($participation, 201, [], [
                'groups' => ['participation_read'],
            ]);
        }

        // Le formulaire n'est pas valide, ça veut dire que le JSON envoyé n'est pas conforme
        // On récupère les erreurs dans $form

        $errorMessages = (string) $form->getErrors(true);
        // On retourne un objet Response avec les erreurs et un code HTTP
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Participation $participation, EntityManagerInterface $manager, Request $request)
    {
        $manager->remove($participation);
        $manager->flush();

        return $this->json(null, 204);
    }

    /**
     * @Route("/{id}/validate/{event}", name="validate", methods={"PUT", "PATCH"})
     */
    public function validate(EntityManagerInterface $manager, Request $request, Event $event, Participation $participation, ParticipationRepository $participationRepository)
    {

        //$this->denyAccessUnlessGranted('PARTICIPATION_VALIDATE', $participation, 'Accès interdit. Vous n\'êtes pas le créateur de l\'évènement');

        // Valide réponse   
        $participation->setIsValidated(true);
        $participation->setIsRefused(false);

        // Flush
        $manager->persist($participation);
        $manager->flush();

        // Now a logic to check the numbers of validated users and modif the event status if necessary :
        // Use the custom queryBuilder in ParticipationRepository to count all users who have is_validated => true
        $totalUsersValidated = $participationRepository->findByValidated($participation->getEvent());

        $totalUsersValidated = count($totalUsersValidated);

        // Set the new amount of validated users
        $event->setTotalUsersValidated($totalUsersValidated);


        // Now we want to compare the $totalUsersValidated with the entrants_numbers to set the status "CLOSE" if they are ==

        // Change the status to "close" if $totalUsersValidated == entrants_numbers
        if ($event->getEntrantsNumbers() == $totalUsersValidated) {

            $event->setStatus(1);

            // Else, the event isnt full and the status is "open"
        } else {

            $event->setStatus(0);
        }

        $manager->persist($event);
        $manager->flush();

        return $this->json(null, 200);
    }

    /**
     * @Route("/{id}/refuse/{event}", name="refuse", methods={"PUT", "PATCH"})
     */
    public function refuse(EntityManagerInterface $manager, Request $request, Event $event, Participation $participation, ParticipationRepository $participationRepository)
    {

        //TODO J'ai enlevé $Event pour valider la participation. A voir après pour remettre.

        //$this->denyAccessUnlessGranted('PARTICIPATION_REFUSE', $participation, 'Accès interdit. Vous n\'êtes pas le créateur de l\'évènement');

        // Valide réponse   
        $participation->setIsValidated(false);
        $participation->setIsRefused(true);

        // Now a logic to check the numbers of validated users and modif the event status if necessary :
        // Use the custom queryBuilder in ParticipationRepository to count all users who have is_validated => true
        $totalUsersValidated = $participationRepository->findByValidated($participation->getEvent());

        $totalUsersValidated = count($totalUsersValidated);

        // Now we want to compare the $totalUsersValidated with the entrants_numbers to set the status "CLOSE" if they are ==

        // Set the new amount of validated users
        $event->setTotalUsersValidated($totalUsersValidated);

        // Change the status to "close" if $totalUsersValidated == entrants_numbers
        if ($event->getEntrantsNumbers() == $totalUsersValidated) {

            $event->setStatus(1);

            // Else, the event isnt full and the status is "open"
        } else {

            $event->setStatus(0);
        }

        $manager->persist($event);
        $manager->flush();

        // Flush
        $manager->persist($participation);
        $manager->flush();

        return $this->json(null, 200);
    }
}
