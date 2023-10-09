<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Preference;
use App\Form\CandidatureType;
use App\Repository\FestivalRepository;
use App\Repository\PosteRepository;
use App\Repository\UtilisateurRepository;
use App\Service\CandidatureManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CandidatureController extends AbstractController
{
    #[Route('/candidature/{idFestival}', name: 'candidature')]
    public function index($idFestival, EntityManagerInterface $entityManager, Request $request, PosteRepository $posteRepository, FestivalRepository $festivalRepository, UtilisateurRepository $utilisateurRepository, CandidatureManager $candidatureManager, RequestStack $requestStack): Response
    {

        $postes = $posteRepository->findBy(['festival' => $idFestival]);
        $festival = $festivalRepository->find($idFestival);
        $utilisateur = $utilisateurRepository->find(1);

        $candidature = new Candidature();

        foreach($postes as $poste){
            $t = new Preference();
            $t->setPoste($poste);
            $candidature->addPreference($t);
        }

        $form = $this->createForm(CandidatureType::class, $candidature, [
            'method' => 'POST',
            'action' => $this->generateURL('candidature', ['idFestival' => $idFestival])
        ]);

        $candidature->setFestival($festival);
        $candidature->setUtilisateur($utilisateur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if(!$candidatureManager->verifierCandidature($candidature, $requestStack)){
                return $this->redirectToRoute('demandeFestival');
            }
            $entityManager->persist($candidature);
            $entityManager->flush();
            //On redirige vers la page suivante
            return $this->redirectToRoute('candidature', ['idFestival' => $idFestival]);
        }

        return $this->render('candidature/form.html.twig', [
            'formulaire' => $form,
            'festival' => $festival]);
    }
}
