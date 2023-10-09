<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Entity\Poste;
use App\Form\CandidatureType;
use App\Form\FestivalType;
use App\Repository\FestivalRepository;
use App\Service\FestivalManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class FestivalController extends AbstractController
{

    #[Route('/festivals/attente', name: 'festivalsAttente')]
    public function index(FestivalRepository $festivalRepository): Response
    {
        $options = [
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

    #[Route('/festivals/demande', name: 'demandeFestival')]
    public function demandeFestival(Request $request,EntityManagerInterface $entityManager, FestivalManager $festivalManager, RequestStack $requestStack):Response
    {
        $festival = new Festival();

        $festival->addPoste((new Poste())->setNom("Billetterie")->setDescription("Gérer la monnaie liquide et CB + tenir un inventaire des souches de billets"));
        $festival->addPoste((new Poste())->setNom("Cuisines")->setDescription("Cuisiner selon les menus établis + servir en buffet + dresser et ranger la salle + faire la vaisselle"));
        $festival->addPoste((new Poste())->setNom("Loges")->setDescription("Accueillir les groupes + véhiculer les groupes + répondre aux sollicitations particulières"));
        $festival->addPoste((new Poste())->setNom("Parking")->setDescription("Orienter la circulation selon les plans + faire stationner correctement les véhicules pour les accès"));
        $festival->addPoste((new Poste())->setNom("Sandwicherie")->setDescription("Préparer et servir les sandwichs et cornets de frites + encaisser les consos "));
        $festival->addPoste((new Poste())->setNom("Tri")->setDescription("Conduire les charriots élévateurs + vider les contenants + répartir selon l’affectation des bennes"));

        $form = $this->createForm(FestivalType::class,$festival,[
            'method'=>'POST',
            'action'=>$this->generateUrl('demandeFestival')
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($festivalManager->verifierFestival($festival, $requestStack)){
                return $this->redirectToRoute('festivalsAttente');
            }
            $entityManager->persist($festival);
            $entityManager->flush();

            return $this->redirectToRoute('festivalsAttente');
        }
        return $this->render('festival/form.html.twig', [
            'formulaire' => $form]);
    }
}
