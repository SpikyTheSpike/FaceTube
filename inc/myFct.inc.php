<?php
require "./php/db_compte.php";
use Compte\CompteRepository;

/**
* Vérifie si l'adresse email est valide (format valide, identique à la confirmation, inexistante en BD)
* @var string $email Adresse courriel du membre à ajouter
* @var string $emailConf Encodage de confirmation de l'adresse courriel
* @var string $message ensemble des messages à retourner à l'utilisateur, séparés par un saut de ligne
* @return boolean true si adresse valide, false sinon
*/
function isValidMdp($mot_de_passe, $mot_de_passeConf, &$message) {
    $compteRepository = new CompteRepository();
    if (empty($mot_de_passe) || empty($mot_de_passeConf)) {
        $message .= 'Vous devez spécifier votre mot de passe et sa confirmation.<br>';
        return false;
    }
    if ($mot_de_passe !== $mot_de_passeConf) {
        $message .= 'Votre mot de passe diffère de la confirmation.<br>';
        return false;
    }
    return true;
}


function isValidLogin($login,&$message) {
    $compteRepository = new CompteRepository();
    if ($compteRepository->existsInDBLogin($login, $message)){
        $message .= 'Ce login n\'est pas disponible.<br>';
        return false;
    }
    return true;
}

function isValidLoginUpdate($login,$id_compte,&$message) {
    $compteRepository = new CompteRepository();
    if ($compteRepository->existsInDBLoginUpdate($login,$id_compte, $message)){
        $message .= 'Ce login n\'est pas disponible.<br>';
        return false;
    }
    return true;
}

function isValidEmail($courriel,&$message) {
    $compteRepository = new CompteRepository();
    if ($compteRepository->existsInDBEmail( $courriel, $message)){
        $message .= 'Cet Email n\'est pas disponible.<br>';
        return false;
    }
    return true;
}

function isValidEmailUpdate($courriel,$id_compte ,&$message) {
    $compteRepository = new CompteRepository();
    if ($compteRepository->existsInDBEmailUpdate( $courriel, $id_compte, $message)){
        $message .= 'Cet Email n\'est pas disponible.<br>';
        return false;
    }
    return true;
}


/**
* Supprime un ensemble de membres sur base de leur identifiant
* @var [integer] $listMembersIds Tableau des identifiants des membres à supprimer
* @var string $message ensemble des messages à retourner à l'utilisateur, séparés par un saut de ligne
* @return boolean true si suppressions effectuées sans erreur, false sinon
*/
function deleteMembers($listMembersIds, &$message){
    $nbrDeleted = 0;
    $noError = true;
    $memberRepository = new MemberRepository();
    if(empty($listMembersIds) || (!is_array($listMembersIds))){
        $message .= 'Aucun courriel sélectionné pour la suppression.<br>';
        return false;
    }
    foreach($listMembersIds as $id){
        if(!$memberRepository->removeMemberFromDB($id, $message)) {
            $noError = false;
        } else {
            $nbrDeleted += 1;
        }
    }
    $message .= "$nbrDeleted courriels supprimés sur " . count($listMembersIds).'<br>';
    return $noError;
}
?>