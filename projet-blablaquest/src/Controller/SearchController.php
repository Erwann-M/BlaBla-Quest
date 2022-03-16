<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="search_", requirements={"id"="\d+"})
 */
class SearchController extends AbstractController
{
    /**
     * 
     * Permet d'afficher le résultat d'une recherche
     * 
     * @Route("/search", name="results")
     */
    public function results(Request $request, UserRepository $userRepository): Response
    {
        // 1) On récupère le terme de la recherche
        $searchTerm = $request->get('search');

        // 2) On interroge la BDD pour récupérer la série
        // correspondante au terme de la recherche
        // $results = $tvShowRepository->findBy(['title' => $searchTerm]);
        // $results = $tvShowRepository->findAllBySearchTerm($searchTerm);
        $results = $userRepository->findAllBySearchTerm($searchTerm);

        // 3) On transmet le résultat à la vue HTML
        return $this->render('search/results.html.twig', [
            'results' => $results,
            'searchTerm' => $searchTerm
        ]);
    }
}
