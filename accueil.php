<?php include("inc/header.inc.php"); ?>
<?php

require 'inc/myFctChaine.inc.php';
require 'inc/myFctVideo.inc.php';
require 'php/db_commentaire.php';
require 'php/db_evaluation.php';

use Chaine\ChaineRepository as ChaineRepository;
use Video\VideoRepository as VideoRepository;
use Commentaire\CommentaireRepository as CommentaireRepository;
use Evaluation\EvaluationRepository as EvaluationRepository;
use Chaine\Chaine;
use Video\Video;
use Commentaire\Commentaire;
use Evaluation\Evaluation;

if(empty($_SESSION['connecter'])){
    header('location: index.php');
}

$chaineRepository = new ChaineRepository();
$videoRepository = new VideoRepository();
$commentaireRepository = new CommentaireRepository();
$evaluationRepository = new EvaluationRepository();

?>
		<h2>Accueil</h2>

<?php


$listChaine= $chaineRepository->getAllChaine($message);



foreach($listChaine as $chaine){

    ?>
    <section class="chaine">
        <h3><?php echo  $chaine->nom; ?></h3>

        <?php
        $listVideo= $videoRepository->getAllVideoByChaineLimited($chaine->id_chaine,$messsage);


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

                                $totalEvaluation = $evaluationRepository->getTotalEvaluationByVideo($video["id_video"], $message);



                        ?>
                        <span class="video"><img class="video" src="image/chrono.png" alt="temps"><?php echo  " ".substr($video["duree"],0,5); ?></span>
                        <span class="video"><img class="video" src="image/yeux.png" alt="vue"><?php echo " ".$numberVue[0] ?> </span>
                        <span class="video"><img class="video" src="image/poucelever.png" alt="aime"><?php echo " ".intval($totalEvaluation[0]) ?> </span>

                        <span class="video"><img class="video" src="image/com.png" alt="comm"><?php echo " ".$numberCommentaire[0] ?> </span>

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