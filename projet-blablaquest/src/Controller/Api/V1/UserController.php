<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/api/v1/user", name="api_v1_user_", requirements={"id"="\d+"})
 */
class UserController extends AbstractController
{
    private $passwordHasher;

    // Making the parameter for passwords hashing in the construct
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/registration", name="registration", methods={"POST"})
     */
    public function register(Request $request, EntityManagerInterface $manager)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user, ['csrf_protection' => false]);

        $json = $request->getContent();

        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isSubmitted() && $form->isValid()) {

            //$imageUploader->uploadUserPicture($form);

            // Hash password (who is the user nickname)
            $password = $form->get('password')->getData();
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            
           

            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
            $manager->flush();

            return $this->json($user, 200, [], [
                'groups' => ['user_read']
            ]);
            // return $this->redirectToRoute('login');
        }

        $errorMessages = (string) $form->getErrors(true);

        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/registration/{id}", name="edit", methods={"PUT", "PATCH"})
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(RegistrationType::class, $user, ['csrf_protection' => false]);

        $json = $request->getContent();

        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isSubmitted() && $form->isValid()) {


            //$imageUploader->uploadUserPicture($form);


            // Hash password (who is the user nickname)
            $password = $form->get('password')->getData();
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $user->setRoles(['ROLE_USER']);

            

            $manager->persist($user);
            $manager->flush();

            return $this->json($user, 200, [], [
                'groups' => ['user_read']
            ]);
            // return $this->redirectToRoute('login');
        }

        $errorMessages = (string) $form->getErrors(true);

        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="", methods={"GET"})
     */
    public function read(User $user): Response
    {
        return $this->json($user, 200, [], [
            'groups' => ['user_read']
        ]);
    }

    /**
     * @Route("/{id}/event", name="_by_event", methods={"GET"})
     */
    public function browseEvents(User $user): Response
    {
        return $this->json($user, 200, [], [
            'groups' => ['user_browse_events']
        ]);
    }
}
