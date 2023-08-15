<?php include("inc/header.inc.php");
require_once("php/db_compte.php");
use Compte\CompteRepository as CompteRepository;
use Compte\Compte;
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$compteRepository = new CompteRepository();
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}?>
	<h2>Suppression</h2>

<?php
if(isset($_POST['supprimer'])){
   if($_SESSION['isAdmin']==true){
    echo "Vous ne pouvez pas supprimer le compte administrateur";
   }else {

       $mail = new PHPMailer(true);
       try {
           $mail->CharSet = 'UTF-8';
           $mail->setFrom('support.FaceTube@gmail.com');
           $mail->addAddress($compteConnecter['courriel']);
           $mail->addReplyTo('no-reply@hotmail.com');
           $mail->isHTML(false);
           $mail->Subject = 'Re: Supression du compte';
           $mail->Body = "Votre compte à bien été supprimer.";
           $mail->send();
           echo "Courrier envoyé";
       } catch (Exception $e) {
           echo 'Erreur survenue lors de l\'envoi de l\'email<br>' . $mail->ErrorInfo;
       }

       $compteRepository->removeMemberFromDB($compteConnecter['login'], $message);
       session_unset();
       header('Location: index.php');

   }
}

if(isset($_POST['annuler'])){
    header('location: accueil.php?login='.$_GET['login']);
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