<?php

namespace App\Service;

use App\Entity\Festival;

class FestivalManager implements FestivalManagerInterface{

    public function verifierFestival(Festival $festival, $requestStack) : bool {

        $flashBag = $requestStack->getSession()->getFlashBag();

        $postes = $festival->getPostes();
        $creneau = $festival->getCreneau();

        //Vérification du festival
        if($festival->getNom() == ""){
            $flashBag->add("error", "Aucun nom n'a été renseigné");
            return false;
        }

        if($festival->getDescription() == ""){
            $flashBag->add("error", "Aucune description n'a été renseigné");
            return false;
        }

        if($festival->getLieu() == ""){
            $flashBag->add("error", "Aucun lieu n'a été renseigné");
            return false;
        }

        if(sizeof($postes) < 1) {
            $flashBag->add("error", "Vous devez renseigné au moins 1 poste");
            return false;
        }

        if($creneau->getDebut() < date("Y-m-d H:i")
            || $creneau->getFin() < date("Y-m-d H:i")){
                $flashBag->add("error", "Les dates d'ouverture et de fermeture sont incorrecte");
                return false;
        }

        $flashBag->add("success", "Votre festival a bien été demandé");
        return true;
    }
}