<?php include("inc/header.inc.php"); ?>

<?php
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once("php/db_compte.php");
use Compte\CompteRepository as CompteRepository;
use Compte\Compte;
$compteRepository = new CompteRepository();
$message="";?>




<?php
if (isset($_POST['envoye'])) {
    $email = !empty($_POST['email']) ? htmlentities($_POST['email']) : 'Pas d\'email spécifié';
    $unique=uniqid();
    $compteDemander=$compteRepository->getMemberByEmail($email,$message);
    if($compteDemander!=false) {
    $noError=$compteRepository->updateMotDePasse($compteDemander->id_compte, $unique,$message);
    var_dump($compteDemander);
    $message = "Voici vos identifiants : \n login : ".$compteDemander->login . " \n nouveau mot de passe : " . $unique;
    ?>
    <?php

        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('support.FaceTube@gmail.com');
            $mail->addAddress($email);
            $mail->addReplyTo('no-reply@hotmail.com');
            $mail->isHTML(false);
            $mail->Subject = 'Re: Récupération du mot de passe';
            $mail->Body = $message;
            $mail->send();
            $message = "Courrier envoyé";
            $class="valide";
        } catch (Exception $e) {
            echo 'Erreur survenue lors de l\'envoi de l\'email<br>' . $mail->ErrorInfo;
        }
    }else{
        $message="Ce courriel n'existe pas";
        $class="errorLogin";
    }
}
    ?>
		<h2>Mot de passe oublié</h2>
    <span class="<?php echo $class;?>"> <?php echo  $message; ?> </span>
		<form class="formulaire" method="post">
			<label for="email">Email : <input id="email" name="email" type="text" value="<?php echo isset($_POST['email']) ? $email : ''; ?>" required placeholder="Courriel"></label>
			<input class="bouton" type="submit" name="envoye" value="Envoyer">
		</form>

		<?php include("inc/fin.inc.php"); ?>