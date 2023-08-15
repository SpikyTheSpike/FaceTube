<?php include("inc/header.inc.php"); ?>

<?php
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

?>


<?php
if(isset($compteConnecter['courriel'])){
    $value=$compteConnecter['courriel'];
}else{
    $value="";
}
$email = !empty($_POST['email']) ? htmlentities($_POST['email']) : 'Pas d\'email spécifié';
$intitule = !empty($_POST['intitule']) ? htmlentities($_POST['intitule']) : 'Pas d\intitulé spécifié';
$message = !empty($_POST['message']) ? htmlentities($_POST['message']) : '';

?>

<?php if (isset($_POST['envoye'])){

    $mail = new PHPMailer(true);  $mailUtilisateur = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($email);
        $mail->addAddress('tomlonc@live.be');
        $mail->addReplyTo('no-reply@hotmail.com');
        $mail->isHTML(false);
        $mail->Subject = 'Re: '. $intitule;
        $mail->Body = $message;
        $mail->send();

        $mailUtilisateur->CharSet = 'UTF-8';
        $mailUtilisateur->setFrom($email);
        $mailUtilisateur->addAddress($email);
        $mailUtilisateur->addReplyTo('no-reply@hotmail.com');
        $mailUtilisateur->isHTML(false);
        $mailUtilisateur->Subject = 'Copie du mail envoyé : '. $intitule;
        $mailUtilisateur->Body = $message;
        $mailUtilisateur->send();


        $message= "Courrier envoyé";
        $class="valide";
    } catch (Exception $e) {
        $message= 'Erreur survenue lors de l\'envoi de l\'email<br>' . $mail->ErrorInfo;

        $class="errorLogin";
    }




}?>
<h2>Contacter Administrateur</h2>
<span class="<?php echo $class;?>"> <?php echo  $message; ?> </span>
<form class="formulaire"  method="POST">
    <label for="email">Email : <input id="email" name="email" type="text" value="<?php echo $value;?>" placeholder="Email" required></label>
    <label for="intitule">Intitulé : <input id="intitule" name="intitule" type="text"  value="<?php echo isset($_POST['intitule']) ? $intitule : ''; ?>" placeholder="Intitulé" required></label>
    <label for="message">Message : <textarea id="message" name="message" rows="10" cols="75" placeholder="Votre message" required></textarea></label>
    <input class="bouton"  type="submit" name="envoye">
</form>
<?php include("inc/fin.inc.php"); ?>


