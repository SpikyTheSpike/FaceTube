<?php include("inc/header.inc.php"); ?>
<?php
require 'inc/myFctChaine.inc.php';
require 'inc/myFctVideo.inc.php';
require 'php/db_evaluation.php';
require 'php/db_commentaire.php';

use Video\VideoRepository as VideoRepository;
use Chaine\ChaineRepository as ChaineRepository;
use Compte\CompteRepository as CompteRepository;
use Commentaire\CommentaireRepository as CommentaireRepository;
use Evaluation\EvaluationRepository as EvaluationRepository;

use Compte\Compte;
use Chaine\Chaine;
use Video\Video;
use Evaluation\Evaluation;
use Commentaire\Commentaire;

if(empty($_SESSION['connecter'])){
    header('location: index.php');
}


$message = '';
$noError = true;
$chaineRepository = new ChaineRepository();
$videoRepository = new VideoRepository();
$compteRepository = new CompteRepository();
$commentaireRepository = new CommentaireRepository();
$evaluationRepository = new EvaluationRepository();
?>
		<h2>Mes chaînes</h2>

        <?php

                $idCompte=$compteRepository->getIdByLogin($compteConnecter['login'] ,$message);
                $listChaine= $chaineRepository->getAllChaineById($idCompte->id_compte,$message);
            foreach($listChaine as $chaine){

                    ?>
                <section class="chaine">
                    <h3><?php echo  $chaine->nom; ?></h3>

                    <?php
                    $listVideo= $videoRepository->getAllVideoByChaine($chaine->id_chaine,$message);


                    foreach ($listVideo as $video){

                        ?>

                        <article class="apercuvideo">
                            <div class="modificationVideo" >
                            <a class="modif" href="editerVideo.php?id_video=<?php echo $video['id_video']?>">...</a>
                            <a class="modif" href="supprimerVideo.php?id_video=<?php echo $video['id_video']?>">x</a>
                            </div>
                            <header>
                                <a class="titre" href="video.php?id_video=<?php echo $video['id_video'] ?>"><img class="minia" src="<?php echo './uploads/'.$video['miniature'] ?>" width="100px" height="100px" alt="video">
                                    <h4><?php echo  $video["intitule"]; ?></h4></a>
                            </header>
                            <footer>
                                <?php
                                $numberCommentaire=$commentaireRepository->getCommentaireByVideo($video["id_video"],$message);
                                $numberVue=$videoRepository->getNumberVueByVideo($video["id_video"],$message);
                                $evaluationRespository = new EvaluationRepository();
                                $totalEvaluation = $evaluationRespository->getTotalEvaluationByVideo($video["id_video"], $message);


                                ?>

                                <span class="video"><img class="video" src="image/chrono.png" alt="temps"><?php echo  " ".substr($video["duree"],0,5); ?></span>
                                <span class="video"><img class="video" src="image/yeux.png" alt="vue"> <?php echo " ".$numberVue[0] ?></span>
                                <span class="video"><img class="video" src="image/poucelever.png" alt="aime"><?php echo " ".intval($totalEvaluation[0])?></span>
                                <span class="video"><img class="video" src="image/com.png" alt="comm"> <?php echo " ".$numberCommentaire[0] ?></span>

                            </footer>

                        </article>

                        <?php

                    }

                    ?>

                    <div class="modification" >
                        <a class="modif" href="ajouterVideo.php?id_chaine=<?php echo $chaine->id_chaine?>" >+</a>
                        <a class="modif" href="editerChaine.php?id_chaine=<?php echo $chaine->id_chaine?>">...</a>
                        <a class="modif" href="supprimerChaine.php?id_chaine=<?php echo $chaine->id_chaine?>">x</a>
                    </div>
                    </section>
                    <?php

            }
        ?>






		<section class="creer">
		<h3>Creer une chaîne</h3>

			<form class="formulaire" method="post">


				<label for="nom">Nom : <input id="nom" name="nom" type="text" value="<?php if (!$noError && isset($_POST["nom"])) echo htmlentities($_POST["nom"]); ?>" required  placeholder="Nom"></label>
				<label for="etat">État : <select id="etat" name="etat">
				<option value="P" selected>Public</option>
				<option value="Pr">Privé</option>
				</select></label>
                    <?php
                    if(isset($_POST['etat'])) {
                        $etat = $_POST['etat'];
                        if ($etat == "P") {
                            $result = 1;
                        } else {
                            $result = 0;
                        }
                    }
                    ?>
				<input class="bouton" type="submit" name="creer" value="Créer">
			</form>
		</section>

<?php

if (isset($_POST['creer'])) {
    $chaine = new Chaine();
    $chaine->nom = htmlentities($_POST['nom']);
    $chaine->est_publique = $result;
    $chaine->evaluation = null;
    $chaine->date_derniere_video = date('j/m/y');
    $chaine->est_bloquee = 0;
    $chaine->id_compte = $compteConnecter['id_compte'];


    $noError=isValidChaine($chaine->nom, $chaine->id_compte,$message);
    if ($noError) {
        $noError = $chaineRepository->storeChaine($chaine, $message);

    }else{?>
         <span class="errorLogin"> <?php echo  $message;?> </span>
   <?php }

}

?>
		<?php include("inc/fin.inc.php"); ?>