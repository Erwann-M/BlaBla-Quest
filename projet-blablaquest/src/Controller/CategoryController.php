<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/category", name="category_", requirements={"id"="\d+"})
 */
class CategoryController extends AbstractController
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
    public function browse(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/browse.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        // On crée un nouvel objet Category
        $category = new Category();

        // On précise qu'on associe $category à notre formulaire
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->persist($category);
            $this->manager->flush();

            $this->addFlash('success', 'La categorie a bien été ajouté.');

            return $this->redirectToRoute('category_browse');
        }

        return $this->render('category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Category $category): Response
    {
        // On précise qu'on associe $category à notre formulaire
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            $this->addFlash('success', 'La categorie a bien été modifié.');

            return $this->redirectToRoute('category_browse');
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(EntityManagerInterface $manager, Category $category)
    {
        // On souhaite supprimer $category de la BDD
        // On a besoin de l'entity manager

        $manager->remove($category);
        $manager->flush();

        $this->addFlash('success', 'La categorie a bien été supprimé.');

        // On redirige vers la liste des séries
        return $this->redirectToRoute('category_browse');
    }
}
