<?php include("inc/header.inc.php");


if(empty($_SESSION['connecter'])){
    header('location: index.php');
}?>

	<h2>Mon compte</h2>
		<article class="profil">

			<span class="profil"> <img class="photoProfil" src="<?php echo './uploads/'.$compteConnecter['photo'] ;?>" alt="photo" >
                <?php echo '<br>'?>
                login: <?php echo  $compteConnecter['login'] .'<br>';?>
			prenom: <?php echo  $compteConnecter['prenom'].'<br>';?>
			nom: <?php echo  $compteConnecter['nom'].'<br>';?>
			email: <?php echo  $compteConnecter['courriel'];?>
			 </span>

		<a class="compte" href="editerCompte.php">Modifier mon compte</a>
		<a class="compte" href="supprimerCompte.php">Supprimer mon compte</a>
		</article>
		<?php include("inc/fin.inc.php"); ?>