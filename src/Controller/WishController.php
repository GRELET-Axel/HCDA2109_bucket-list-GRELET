<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishFormType;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    #[Route('/create/list', name: 'create')]
    public function create(Request $request,EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $wish = new Wish();

            $form = $this->createForm(WishFormType::class, $wish, [
                'action' => $this->generateUrl('wish_create'),
                'method' => 'POST'
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $dataForm = $form->getData();
                $errors = $validator->validate($dataForm);

                if (count($errors) > 0) {
        
                    // $errorsString = (string) $errors;
                    return $this->renderForm('wish/create.html.twig', [
                        'form' => $form,
                        // 'message' => $errors
                    ]);
                }else{

                    $wish->setTitle($dataForm->getTitle());
                    $wish->setDescription($dataForm->getDescription());
                    $wish->setAuthor($dataForm->getAuthor());
                    $wish->setIsPublished(false);
                    $wish->setDateCreated(new DateTime());

                    $em->persist($wish);
                    $em->flush();

                    $id = $wish->getId();
                    $this->addFlash('success','Idea successfully added!');
                    return $this->redirectToRoute('wish_detail', ['id' => $id]);
                }
            }
    
            return $this->renderForm('wish/create.html.twig', [
                'form' => $form,
            ]);
    }

}
