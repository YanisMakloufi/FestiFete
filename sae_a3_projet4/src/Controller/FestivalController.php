<?php

namespace App\Controller;

use App\Form\CandidatureType;
use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class FestivalController extends AbstractController
{

    #[Route('/festivals/attente', name: 'festivals_en_attente')]
    public function index(FestivalRepository $festivalRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $options = [
            'controller_name' => 'FestivalController',
            'festivals' => $festivalRepository->findAllNonVerifie()
        ];

        return $this->render('festival/attente.html.twig',$options);
    }


    #[Route('/festival/{id}', name: 'refuserFestival', options: ["expose" => true], methods: ["DELETE"])]
    public function refuserFestival(FestivalRepository $festivalRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $festival = $festivalRepository->find($id);

        $entityManager->remove($festival);
        $entityManager->flush();

        return new JsonResponse(null, '204');
    }

    #[Route('/festival/{id}', name: 'accepterFestival', options: ["expose" => true], methods: ["POST"])]
    public function accepterFestival(FestivalRepository $festivalRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $festival = $festivalRepository->find($id);
        $festival->validation();

        $entityManager->persist($festival);
        $entityManager->flush();

        return new JsonResponse(null, '204');
    }
}
