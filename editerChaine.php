<?php include("inc/header.inc.php");
require 'inc/myFctChaine.inc.php';
use Chaine\ChaineRepository as ChaineRepository;
use Chaine\Chaine;
$chaineRepository = new ChaineRepository();
$message="";
$chaineActif= $chaineRepository->getChaineById($_GET['id_chaine'],$message);

if(empty($_SESSION['connecter'])){
    header('location: index.php');
}

if(isset($_POST['valider'])){
    $nom=htmlentities($_POST['nom']);
    if(isset($_POST['etat'])) {
        $etat = $_POST['etat'];
        if ($etat == "P") {
            $result = 1;
        } else {
            $result = 0;
        }
    }


        $noError = $chaineRepository->updateChaine($nom , $result, $_GET['id_chaine'],$message);
        header('location:chaines.php');
    


}
?>


		<h2>Éditer Chaîne</h2>
<?php
echo $message;
?>
		<form class="formulaire" method="POST">
		<label for="nom">Nom : <input id="nom" name="nom" type="text" value="<?php echo $chaineActif->nom?>" required placeholder="Nom"></label>
		<label for="etat">État : <select id="etat" name="etat">
				<option value="P" selected>Public</option>
				<option value="Pr">Privé</option>
				</select></label>
				<input class="bouton" type="submit" name="valider" value="Valider">
		</form>
		<?php include("inc/fin.inc.php"); ?>