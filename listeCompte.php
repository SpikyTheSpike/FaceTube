<?php include("inc/header.inc.php");
require_once("php/db_compte.php");
use Compte\CompteRepository as CompteRepository;
use Compte\Compte;
$compteRepository = new CompteRepository();
$message="";
$listeCompte=$compteRepository->getAllCompteAdmin($message);

?>
<h2>Liste des comptes</h2>

    <div class="demander">
        <form method="POST" >
            <label for="cherche"></label><input id="cherche" name="cherche" type="text" placeholder="Login / Email">
        </form>
    </div>
<article class="moderation">
<?php
if(empty($_POST['cherche'])){
foreach ($listeCompte as $compte){
    ?>

    <div class="ami">
                    <span class="ami"><img class="profilAmi" src="<?php echo './uploads/' . $compte->photo ?>"
                                           alt="video"> </span>
        <a class="chaineUtilisateur" href="chaineAmi.php?id_compte=<?php echo $compte->id_compte?>" <span class="ami"><?php echo $compte->login ?> </span></a>



    </div>

<?php
}
}else{
    $listeCompteRechercher=$compteRepository->getAllCompteAdminRecherche(htmlentities($_POST['cherche']),$message);
    foreach ($listeCompteRechercher as $compte){
        ?>

        <div class="ami">
                    <span class="ami"><img class="profilAmi" src="<?php echo './uploads/' . $compte->photo ?>"
                                           alt="video"> </span>
            <a class="chaineUtilisateur" href="chaineAmi.php?id_compte=<?php echo $compte->id_compte?>" <span class="ami"><?php echo $compte->login ?> </span></a>



        </div>

        <?php
    }
}
?>
</article>




<?php include("inc/fin.inc.php"); ?>
