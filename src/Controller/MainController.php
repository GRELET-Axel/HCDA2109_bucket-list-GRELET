<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/legal-stuff', name: 'legal-stuff')]
    public function legalSuff(): Response
    {
        return $this->render('main/legalStuff.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/about-us', name: 'about-us')]
    public function aboutUs(): Response
    {
        return $this->render('main/about-us.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
