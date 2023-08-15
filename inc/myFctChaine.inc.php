<?php
require "./php/db_chaine.php";
use Chaine\ChaineRepository;

/**
 * Vérifie si l'adresse email est valide (format valide, identique à la confirmation, inexistante en BD)
 * @var string $nom nom de la chaine à ajouter
 * @var string $id_comtpe compte de l'utilisateur
 * @var string $message ensemble des messages à retourner à l'utilisateur, séparés par un saut de ligne
 * @return boolean true si adresse valide, false sinon
 */
function isValidChaine($nom,$id_compte ,&$message) {
    $chaineRepository = new ChaineRepository();
    if (empty($nom) ) {
        $message .= 'Vous devez spécifier un nom.<br>';
        return false;
    }

    if($chaineRepository->existsInDB($nom, $id_compte,$message)){
        $message .= 'Ce nom de chaine n\'est pas disponible.<br>';
        return false;
    }
    return true;
}

function isValidChaineUpdate($nom,$id_compte,$id_chaine ,&$message) {
    $chaineRepository = new ChaineRepository();
    if (empty($nom) ) {
        $message .= 'Vous devez spécifier un nom.<br>';
        return false;
    }

    if($chaineRepository->existsInDBUpdate($nom, $id_compte, $id_chaine,$message)){
        $message .= 'Ce nom de chaine n\'est pas disponible.<br>';
        return false;
    }
    return true;
}




?>