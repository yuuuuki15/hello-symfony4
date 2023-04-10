<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MypageController extends AbstractController
{
    #[Route('/mypage', name: 'app_mypage')]
    public function index(): Response
    {
        return $this->render('mypage/index.html.twig', [
            'controller_name' => 'MypageController',
        ]);
    }
}
