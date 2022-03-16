<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Comments;
use App\Form\UserManageType;
use App\Form\RegistrationType;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * @Route("/admin/user", name="user_", requirements={"id"="\d+"})
 */
class UserController extends AbstractController
{
    private $passwordHasher;


    /**
     * On injecte le manager dans le controleur
     */
    public function __construct(EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher )
    {
        $this->manager = $manager;

        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("", name="browse")
     */
    public function browse(UserRepository $userRepository): Response
    {
        return $this->render('user/browse.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="read")
     */
    public function read(User $user, EventRepository $eventRepository, CommentsRepository $commentsRepository, $id): Response
    {
        // dd($eventRepository->findByUser($id));
        return $this->render('user/read.html.twig', [
            'user' => $user,
            'events' => $eventRepository->findByUser($id),
            'comments' => $commentsRepository->findByUser($id),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, EntityManagerInterface $manager)
    {
        $user = new User();

        $form = $this->createForm(UserManageType::class, $user, ['csrf_protection' => false]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$imageUploader->uploadUserPicture($form);
            // On remet la même logique que dans edit()
            // Ici on ne vérifie pas que $password n'est pas null, il ne devrait jamais l'être
            $password = $form->get('password')->getData();
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/add.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);

    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(EntityManagerInterface $manager, User $user)
    {
        // On souhaite supprimer $user de la BDD
        // On a besoin de l'entity manager
        
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');

        // On redirige vers la liste des séries
        return $this->redirectToRoute('user_browse');
    }

    /**
    * @Route("/{id}/edit", name="edit")
    */
    public function edit(Request $request, EntityManagerInterface $manager, User $user)
    {
        $form = $this->createForm(UserManageType::class, $user, ['csrf_protection' => false]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Si le champs password a été fourni, on le récupère pour le hasher et le place dans $user
            // On récupère la valeur dans le champs password du formulaire
            $password = $form->get('password')->getData();
            // $password vaut null si rien n'a été tapé
            if ($password != null) {
                // Si un mot de passe a été tapé, on le met à jour dans $user
                // On va d'abord hasher le mdp
                $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
            }    

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
