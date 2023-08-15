<?php include("inc/header.inc.php");
require_once("php/db_compte.php");
use Compte\CompteRepository as CompteRepository;
use Compte\Compte;
$compteRepository = new CompteRepository();
$message="";

if(empty($_SESSION['connecter'])){
    header('location: index.php');
}

?>
<?php
if (isset($_POST['valider']) && htmlentities($_POST['oldMotPasse'])==$compteConnecter['mot_de_passe']) {
    $tmpname=$_FILES['photo']['tmp_name'];
    $name=$_FILES['photo']['name'];
    $size=$_FILES['photo']['size'];
    $error=$_FILES['photo']['error'];
    $type=$_FILES['photo']['type'];

    $name = str_replace(' ', '', $name);


    move_uploaded_file($tmpname, './uploads/'.$name);
if(empty($name)){
$name=$compteConnecter['photo'];
}

    $compteUpdate = new Compte();
    $compteUpdate->nom = htmlentities($_POST['nom']);
    $compteUpdate->login = htmlentities($_POST['login']);
    $compteUpdate->prenom = htmlentities($_POST['prenom']);
    $compteUpdate->courriel = htmlentities($_POST['email']);
    $compteUpdate->mot_de_passe = htmlentities($_POST['motPasse']);
    $mot_de_passeConf = htmlentities($_POST['RemotPasse']);
    $compteUpdate->photo = $name;


    $noError = isValidMdp($compteUpdate->mot_de_passe, $mot_de_passeConf, $message);
    $noError2 = isValidLoginUpdate($compteUpdate->login,  $compteConnecter['id_compte'],$message);
    $noError3 = isValidEmailUpdate( $compteUpdate->courriel, $compteConnecter['id_compte'],$message);
    if ($noError && $noError2 && $noError3) {
        $noError = $compteRepository->updateMemberByLogin($compteUpdate, $compteConnecter['id_compte'], $message);

        $compte = $compteRepository->getMemberById($compteConnecter['id_compte'], $message);

        $_SESSION["connecter"]=array(
            "id_compte"=>$compte->id_compte,
            "nom"=>$compte->nom,
            "login"=>$compte->login,
            "prenom"=>$compte->prenom,
            "courriel"=>$compte->courriel,
            "photo"=>$compte->photo,
            "mot_de_passe"=>$compte->mot_de_passe
        );
        header('location: accueil.php');
    }


}
?>
    <h2>Éditer mon compte</h2>
<?php
echo $message;
?>
    <form class="formulaire" method="post" enctype="multipart/form-data">
        <label for="login">Login : <input id="login" name="login" type="text"  required placeholder="Login" value="<?php echo  $compteConnecter['login'] ?>"></label>
        <label for="nom">Nom : <input id="nom" name="nom" type="text"  required placeholder="Nom"  value="<?php echo $compteConnecter['nom']?>"> </label>
        <label for="prenom">Prénom : <input id="prenom" name="prenom" type="text"  required placeholder="Prénom"  value="<?php echo $compteConnecter['prenom'] ?>"> </label>
        <label for="email">Email : <input id="email" name="email" type="text"  required placeholder="Courriel"  value="<?php echo$compteConnecter['courriel'] ?>"> </label>
        <label for="photo">Photo : <input id="photo" name="photo" type="file"  accept=".png, .jpeg"  ></label>
        <label for="oldMotPasse">Mot de passe : <input id="oldMotPasse" name="oldMotPasse" type="password" required placeholder="Mot de passe"  > </label>
        <label for="motPasse">Nouveau mot de passe : <input id="motPasse" name="motPasse" type="password" required placeholder="Nouveau mot de passe"  > </label>
        <label for="RemotPasse">Confirmation : <input id="RemotPasse" name="RemotPasse" type="password" required placeholder="Confirmation Mot de passe" > </label>
        <input class="bouton" type="submit" name="valider" value="Valider">
    </form>

<?php include("inc/fin.inc.php"); ?>