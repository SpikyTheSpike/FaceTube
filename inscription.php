<?php include("inc/header.inc.php"); ?>
<?php
require_once 'inc/myFct.inc.php';
use Compte\CompteRepository as CompteRepository;
use Compte\Compte;

$message = '';
$noError = true;
$compteRepository = new CompteRepository();


    if (isset($_POST['valider'])) {
        $tmpname=$_FILES['photo']['tmp_name'];
        $name=$_FILES['photo']['name'];
        $size=$_FILES['photo']['size'];
        $error=$_FILES['photo']['error'];
        $type=$_FILES['photo']['type'];

        $name = str_replace(' ', '', $name);
        if(empty($name)){
            $name="default-avatar.jpg";
        }
        $nomDossier='./uploads';

            move_uploaded_file($tmpname, './uploads/'.$name);






        $compte = new Compte();
        $compte->nom = htmlentities($_POST['nom']);
        $compte->login = htmlentities($_POST['login']);
        $compte->prenom = htmlentities($_POST['prenom']);
        $compte->courriel = htmlentities($_POST['email']);
        $compte->mot_de_passe = htmlentities($_POST['motPasse']);
        $mot_de_passeConf = htmlentities($_POST['RemotPasse']);
        $compte->photo = $name;


        $noError = isValidMdp($compte->mot_de_passe, $mot_de_passeConf, $message);
        $noError2 = isValidLogin($compte->login, $message);
        $noError3 = isValidEmail( $compte->courriel,$message);
        if ($noError && $noError2 && $noError3) {
            $noError = $compteRepository->storeMember($compte, $message);
        }
    }
        ?>






    <h2>Créer un compte</h2>
        <?php
        echo $message;

?>
		<form class="formulaire"  method="post" enctype="multipart/form-data">
			<label for="login">Login : <input id="login" name="login" type="text" value="<?php if (!$noError && isset($_POST["login"])) echo htmlentities($_POST["login"]); ?>" required placeholder="Login"> </label>
			<label for="motPasse">Mot de passe : <input id="motPasse" name="motPasse" type="password" value="<?php if (!$noError && isset($_POST["motPasse"])) echo htmlentities($_POST["motPasse"]); ?>" required placeholder="Mot de passe" ></label>
			<label for="RemotPasse">Confirmation mot de passe : <input id="RemotPasse" name="RemotPasse" type="password" required placeholder="Confirmation" > </label>
			<label for="email">Email : <input id="email" name="email" type="text"  value="<?php if (!$noError && isset($_POST["email"])) echo htmlentities($_POST["email"]); ?>" required placeholder="Courriel"> </label>
			<label for="photo">Photo : <input id="photo" name="photo" type="file"  accept=".png, .jpeg, .jpg"  ></label>
			<label for="nom">Nom : <input id="nom" name="nom" type="text"  value="<?php if (!$noError && isset($_POST["prenom"])) echo htmlentities($_POST["prenom"]); ?>" required placeholder="Nom"> </label>
			<label for="prenom">Prénom : <input id="prenom" name="prenom" type="text" value="<?php if (!$noError && isset($_POST["nom"])) echo htmlentities($_POST["nom"]); ?>" required placeholder="Prénom"> </label>
			<input class="bouton" type="submit" name="valider" value="Valider">
		</form>
		<?php include("inc/fin.inc.php"); ?>