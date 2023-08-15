<?php include("inc/header.inc.php");
require_once("php/db_commentaire.php");
use Commentaire\CommentaireRepository as  CommentaireRepository;
use Commentaire\Commentaire;
$commentaireRepository = new CommentaireRepository();
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}
?>
    <h2>Suppression</h2>

<?php
if(isset($_POST['supprimer'])){
    $commentaireRepository->removeMemberFromDB($_GET['id_commentaire'],$message);
    header('Location: video.php?id_video='.$_GET['id_video']);
}

if(isset($_POST['annuler'])){
    header('location: video.php?id_video='.$_GET['id_video']);
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