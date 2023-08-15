<?php include("inc/header.inc.php");
require_once("php/db_chaine.php");
use Chaine\ChaineRepository as ChaineRepository;
use Chaine\Chaine;
$chaineRepository = new ChaineRepository();
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}
?>

	<h2>Suppression</h2>

<?php
$num=$chaineRepository->countVideoByChaine($_GET['id_chaine'],$message);

if(isset($_POST['supprimer'])){
    if($num[0]==0) {
        $chaineRepository->removeMemberFromDB($_GET['id_chaine'], $message);
        header('Location: chaines.php');
    }else{
        echo "Impossible de supprimer une chaine qui contient des vidéos";
    }
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