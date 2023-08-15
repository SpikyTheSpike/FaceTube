<?php include("inc/header.inc.php");
require_once("php/db_video.php");
use Video\VideoRepository as VideoRepository;
use Video\Video;
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}
$videoRepository = new VideoRepository();?>
    <h2>Suppression</h2>

<?php
if(isset($_POST['supprimer'])){
    $videoRepository->removeMemberFromDB($_GET['id_video'],$message);
    header('Location: chaines.php');
}

if(isset($_POST['annuler'])){
    header('location: chaines.php');
}

?>
    <article class="profil">
        <span class="supp">Êtes-vous sûr de vouloir supprimer</span>
        <form class="formulaire" method="post">
            <input class="bouton" type="submit" name="supprimer" value="Supprimer">
            <input class="bouton" type="submit" name="annuler" value="Annuler">
        </form>
    </article>
<?php include("inc/fin.inc.php"); ?>