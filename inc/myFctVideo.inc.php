<?php
require "./php/db_video.php";
use Video\VideoRepository;

/**
 * Vérifie si l'adresse email est valide (format valide, identique à la confirmation, inexistante en BD)
 * @var string $nom nom de la chaine à ajouter
 * @var string $id_comtpe compte de l'utilisateur
 * @var string $message ensemble des messages à retourner à l'utilisateur, séparés par un saut de ligne
 * @return boolean true si adresse valide, false sinon
 */
function isValidVideo($nom,$id_chaine ,&$message) {
    $videoRepository = new VideoRepository();
    if (empty($nom) ) {
        $message .= 'Vous devez spécifier un nom.<br>';
        return false;
    }

    if($videoRepository->existsInDB($nom, $id_chaine,$message)){
        $message .= 'Ce nom de vidéo n\'est pas disponible.<br>';
        return false;
    }
    return true;
}





?>