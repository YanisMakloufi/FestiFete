<?php

namespace App\Service;

use App\Entity\Candidature;

class CandidatureManager {

    public function __construct(
    ){}

    /**
     * Réalise toutes les opérations nécessaires avant l'enregistrement en base d'un nouvel utilisateur, après soumissions du formulaire (hachage du mot de passe, sauvegarde de la photo de profil...)
     */
    public function verifierCandidature(Candidature $candidature, ) : void {

        $festival = $candidature->getFestival();
        $preferences = $candidature->getPreferences();
        $utilisateur = $candidature->getUtilisateur();
        $description = $candidature->getDescription();
        $disponibilites = $candidature->getDisponibilites();

        //Vérification du festival
        if(is_null($festival))
            return;
        if(!$festival->isValidation())
            return;

        //Vérification de l'utilisateur
        if(is_null($utilisateur))
            return;

        //Vérification de la description
        if($description == "")
            return;

        //Vérification des préférences
        if(is_null($preferences))
            return;
        foreach($preferences as $pref){
            if(!is_int($pref->getNbPreference())
                || $pref->getNbPreference() < 1
                || $pref->getNbPreference() > 3)
                return;
        }

        //Vérification des disponibilités
        if(sizeof($disponibilites) < 1)
            return;
        foreach($disponibilites as $dispo){
            if($dispo->getDebut() < $festival->getCreneau()->getDebut()
                || $dispo->getFin() > $festival->getCreneau()->getFin())
                return;
        }
    }
}