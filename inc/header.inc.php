<!DOCTYPE html>
<html lang="fr">
<?php
require 'myFct.inc.php';
use Compte\CompteRepository as CompteRepository;
use Compte\Compte;
$message = '';
$noError = true;
$compteRepository = new CompteRepository();
session_start();

if(isset($_SESSION['connecter'])) {
    $compteConnecter = $_SESSION['connecter'];
}
?>
<head>
    <meta charset="utf-8"/>
    <title>FaceTube</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">


 </head>
 <body>
	<header>


        <?php
        if(!empty($_POST['recherche'])){
            $mot=$_POST['recherche'];
        }
        ?>

            <?php if (isset($_SESSION['connecter'])){ ?>
                <h1><a class="titrePrincipal" href="accueil.php">FaceTube</a></h1>
            <div class="profil"><a class="profil" href="compte.php" class="couleur">
                    <span class="profil"> <?php echo  $compteConnecter['prenom'];?> </span>
                    <span class="profil"><?php echo  $compteConnecter['nom']; ?></span>
                    <img class="profil" src="<?php echo './uploads/'.$compteConnecter['photo'] ?>" alt="profil" >
                </a>
                <?php
                if(isset($_POST['deco'])){
                    session_unset();
                    header('location: index.php');
                }
                ?>
                <form method="post">
                    <button type=submit name="deco"><img class="deco" src=image/disconect.png ></button>
                </form>
                </div>
                <nav>
                    <ul class="navi">
                        <li><a href="accueil.php">Accueil</a></li>
                        <li><a href="ami.php">Liste d'ami</a></li>
                        <li><a href="chaines.php">Mes chaînes</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <?php
                        if( $_SESSION["isAdmin"]){?>
                            <li><a href="listeCompte.php">Liste de compte</a></li>
                        <li><a href="listeChaine.php">Modéré</a></li>
                        <?php
                        }
                        ?>
                        <li><form method="get" action="recherche.php">
                                <label for="recherche"></label><input id="recherche" name="recherche" type="text" placeholder="Rechercher">
                            </form></li>

                    </ul>
                </nav>
                <?php } else {


                ?>
                <h1><a class="titrePrincipal" href="index.php">FaceTube</a></h1>
                <?php
            }
        ?>

	</header>
	<main>