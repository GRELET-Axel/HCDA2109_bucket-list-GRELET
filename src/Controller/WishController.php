<?php

namespace App\Controller;

use App\Entity\Wish;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{

    #[Route('/list', name: 'list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $wishList = $entityManager->getRepository(Wish::class)->findAll();

        // var_dump($wishList);
        
        return $this->render('wish/list.html.twig', [
            'controller_name' => 'WishController',
            'wish_list' => $wishList
        ]);
    }

    #[Route('/{id}', name: 'detail')]
    public function detail(EntityManagerInterface $entityManager,$id): Response
    {
        $wish = $entityManager->getRepository(Wish::class)->find($id);

        return $this->render('wish/detail.html.twig', [
            'controller_name' => 'WishController',
            'wish' => $wish
        ]);
    }

}
