<?php

namespace App\Controller;

use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController
{

    #[Route('/festival/attente', name: 'festivals en attente')]
    public function index(FestivalRepository $festivalRepository): Response
    {
        $options = [
            'controller_name' => 'FestivalController',
            "liste"=>$festivalRepository->findAllNonVerifie()
        ];
        return $this->render('festival/attente.html.twig',$options);
    }
}
