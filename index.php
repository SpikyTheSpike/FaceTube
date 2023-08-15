<?php include("inc/header.inc.php");
    require_once("php/db_compte.php");
    use Compte\CompteRepository as CompteRepository;
    use Compte\Compte;
    $compteRepository = new CompteRepository();?>
<?php

    $message = "";
    $compteRepository->initdb();
    if (isset($_POST['connexion'])){
        if($compteRepository->checkLogin(htmlentities($_POST['login']), htmlentities($_POST['motPasse']), $message)) {
            $compte = $compteRepository->getMemberByLogin($_POST['login'], $message);

            $_SESSION["connecter"]=array(
                "id_compte"=>$compte->id_compte,
                "nom"=>$compte->nom,
                "login"=>$compte->login,
                "prenom"=>$compte->prenom,
                "courriel"=>$compte->courriel,
                "photo"=>$compte->photo,
                "mot_de_passe"=>$compte->mot_de_passe
            );

            if($compte->id_compte==1){
                $_SESSION["isAdmin"]=true;
            }else{
                $_SESSION["isAdmin"]=false;
            }
            header('location: accueil.php');
        }


    }
    ?>
		<h2>Authentification</h2>


			<form class="formulaire" method="POST">
			<label for="login">Login : <input id="login" name="login" type="text"  required placeholder="Login"></label>
			<label for="motPasse">Mot de passe : <input id="motPasse" name="motPasse" type="password" required placeholder="Mot de passe" > </label>
			<input class="bouton" type="submit" name="connexion" value="Connexion">
			</form>
             <span class="errorLogin"> <?php echo  $message;?> </span>
			<a class="compte" href="oublie.php">mot de passe oublié?</a>
			<a class="compte" href="inscription.php">Créer un compte</a>
			<a class="compte" href="contact.php">Contacter un administrateur</a>
		<?php include("inc/fin.inc.php"); ?>