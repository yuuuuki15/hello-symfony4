<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Form\UpdateProfileFormType;
use Symfony\Component\HttpFoundation\Request;

class MypageController extends AbstractController
{
    #[Route('/mypage', name: 'app_mypage')]
    public function index(Security $security, Request $request): Response
    {
        $user = $security->getUser();

        $form = $this->createForm(UpdateProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Your profile has been updated.');

            return $this->redirectToRoute('app_top');
        }

        return $this->render('mypage/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
