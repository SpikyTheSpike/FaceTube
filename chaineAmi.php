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


$listChaine= $chaineRepository->getAllChaineByIdAmi($_GET['id_compte'],$message);
foreach($listChaine as $chaine){

    ?>
    <section class="chaine">
        <h3><?php echo  $chaine->nom; ?></h3>

        <?php
        $listVideo= $videoRepository->getAllVideoByChaine($chaine->id_chaine,$message);


        foreach ($listVideo as $video){

            ?>

            <article class="apercuvideo">

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


    </section>
    <?php

}
?>








<?php include("inc/fin.inc.php"); ?>