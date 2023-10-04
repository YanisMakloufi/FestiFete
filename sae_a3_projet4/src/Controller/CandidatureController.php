<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\Preference;
use App\Form\CandidatureType;
use App\Repository\FestivalRepository;
use App\Repository\PosteRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CandidatureController extends AbstractController
{
    #[Route('/candidature/{idFestival}', name: 'candidature')]
    public function index($idFestival, EntityManagerInterface $entityManager, Request $request, PosteRepository $posteRepository, FestivalRepository $festivalRepository, UtilisateurRepository $utilisateurRepository): Response
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

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // À ce stade, le formulaire et ses données sont valides
            // L'objet "Exemple" a été mis à jour avec les données, il ne reste plus qu'à le sauvegarder
            $candidature->setUtilisateur($utilisateur);
            $candidature->setFestival($festival);

            $entityManager->persist($candidature);
            $entityManager->flush();

            //On redirige vers la page suivante
            return $this->redirectToRoute('candidature', ['idFestival' => $idFestival]);
        }

        return $this->render('candidature/form.html.twig', [
            'controller_name' => 'CandidatureController',
            'formulaire' => $form,
            'festival' => $festival,
            'postes' => $postes]);
    }
}
