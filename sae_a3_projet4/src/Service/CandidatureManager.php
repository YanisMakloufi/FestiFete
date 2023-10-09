<?php

namespace App\Service;

use App\Entity\Candidature;

class CandidatureManager implements CandidatureManagerInterface{


    public function verifierCandidature(Candidature $candidature, $requestStack) : bool {

        $flashBag = $requestStack->getSession()->getFlashBag();

        $festival = $candidature->getFestival();
        $preferences = $candidature->getPreferences();
        $utilisateur = $candidature->getUtilisateur();
        $description = $candidature->getDescription();
        $disponibilites = $candidature->getDisponibilites();

        //Vérification du festival
        if(is_null($festival)){
            $flashBag->add("error", "Le festival n'existe pas");
            return false;
        }

        if(!$festival->isValidation()){
            $flashBag->add("error", "Le festival n'est pas encore validé");
            return false;
        }

        //Vérification de l'utilisateur
        if(is_null($utilisateur)){
            $flashBag->add("error", "L'utilisateur n'existe pas");
            return false;
        }

        //Vérification de la description
        if($description == ""){
            $flashBag->add("error", "Vous n'avez pas renseigné de description");
            return false;
        }

        //Vérification des préférences
        if(is_null($preferences)){
            $flashBag->add("error", "Vous n'avez pas établis de préférences de postes");
            return false;
        }

        foreach($preferences as $pref){
            if(!is_int($pref->getNbPreference())
                || $pref->getNbPreference() < 1
                || $pref->getNbPreference() > 3){
                    $flashBag->add("error", "La préférence doit etre comprise entre 1 et 3");
                    return false;
            }
        }

        //Vérification des disponibilités
        if(sizeof($disponibilites) < 1){
            $flashBag->add("error", "Vous devez renseignez au moins 1 disponibilité");
            return false;
        }

        foreach($disponibilites as $dispo){
            if($dispo->getDebut() < $festival->getCreneau()->getDebut()
                || $dispo->getFin() > $festival->getCreneau()->getFin()
                || $dispo->getDebut() > date("Y-m-d H:i")
                || $dispo->getFin() > date("Y-m-d H:i")){
                $flashBag->add("error", "Les dates de disponibilités sont incorrecte");
                return false;
            }
        }
        $flashBag->add("success", "Votre candidature a bien été envoyé");
        return true;
    }
}