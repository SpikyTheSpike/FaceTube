<?php include("inc/header.inc.php"); ?>
    <h2>Vidéo</h2>
<?php
require 'inc/myFctVideo.inc.php';
require 'php/db_commentaire.php';
require 'php/db_evaluation.php';

use Compte\CompteRepository as CompteRepository;
use Video\VideoRepository as VideoRepository;
use Commentaire\CommentaireRepository as CommentaireRepository;
use Evaluation\EvaluationRepository as EvaluationRepository;

use Video\Video;
use Commentaire\Commentaire;
use Evaluation\Evaluation;
use Compte\Compte;
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}

$compteRepository = new CompteRepository();
$videoRepository = new VideoRepository();
$commentaireRepository = new CommentaireRepository();
$evaluationRepository = new EvaluationRepository();



$message = '';
$message1 = '';
$noError = true;

$video=$videoRepository->getVideoById($_GET['id_video'],$message);

$tab=explode(" ",$video->html_fragment);
$pos=strpos($tab[3],"&quot;");
$pos2=strrpos($tab[3],"&quot;");

$rest = substr($tab[3], $pos+6,$pos2-10);
$idMembre=$compteRepository->getMemberByLogin($compteConnecter['login'],$message);


if(!$videoRepository->existsVueInDB($compteConnecter['id_compte'], $_GET['id_video'],$message)) {
    $vu = $videoRepository->storeVue($compteConnecter['id_compte'], $_GET['id_video'], $message1);
}

if (isset($_POST['envoye']) ) {
    $commentaire = new Commentaire();
    $commentaire->commentaire= htmlentities($_POST['commentaire']) ;
    $commentaire->date_publication= date('j/m/y');
    $commentaire->id_video= $_GET['id_video'];
    $commentaire->id_compte=$compteConnecter['id_compte'];
    if( empty(trim( $commentaire->commentaire)) ){

        $message="Votre commentaire est vide.";

    }else{
        $noError = $commentaireRepository->storeCommentaire($commentaire, $message);
        header('refresh:5');
    }

}

if (isset($_POST['valider'])) {
    $evaluation = new Evaluation();
    $evaluation->id_compte= $compteConnecter['id_compte'];
    $evaluation->id_video= $_GET['id_video'];
    $evaluation->evaluation= $_POST['evaluation'];

    if($evaluationRepository->existsEvaluationInDB($evaluation->id_compte, $evaluation->id_video,$message)){
        $evaluationRepository->updateEvaluation($evaluation->id_compte, $evaluation->id_video,$evaluation->evaluation,$messgae);
    }else{
        $evaluationRepository->storeEvaluation($evaluation,$message);
    }

}

$numberVue=$videoRepository->getNumberVueByVideo($_GET['id_video'],$message1);
$totalEvaluation = $evaluationRepository->getTotalEvaluationByVideo($_GET['id_video'], $message1);
$nombreEvaluation = $evaluationRepository->getNumberEvaluationByVideo($_GET['id_video'], $message1);

if(intval($nombreEvaluation[0]>0)) {
    $deno = intval($totalEvaluation[0]);
    $num = intval($nombreEvaluation[0]);
    $moyenne = $deno / $num;
}else{
    $moyenne= "Pas d'évaluation";
}


?>
    <section class="video">

        <iframe width="800" height="500" src="<?php echo $rest;?>" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

        <header class="video">
            <span class="titre">  <?php echo $video->intitule;?> </span>



            <span class="videoVue"><img class="videoVue" src="image/yeux.png" alt="vue" > <?php echo " ".$numberVue[0] ?> </span>
            <span class="videoVue"><img class="videoVue" src="image/chrono.png" alt="temps" > <?php echo  " ".substr($video->duree,0,5); ?></span>
            <span class="videoVue"><img class="videoVue" src="image/etoile.png" alt="aime" >  <?php echo " ".$moyenne ?></span>
            <form class="evaluation" method="post">
                <label  for="evaluation"></label><input class="evaluation" id="evaluation" name="evaluation" type="range" min="0" max="5" step="1">
                <input class="bouton" type="submit" name="valider" value="Valider">
            </form>
            <span class="desc"> <?php echo $video->description;?></span>
        </header>


        <footer class="video">

            <article class="commentaire">
                <h3>Commentaires</h3>
                <span class="errorLogin"> <?php echo  $message;?> </span>
                <form class="formulaire" method="post">
                    <label class="area" for="commentaire">Commentaire : <textarea id="commentaire" name="commentaire" rows="2" cols="100" required > </textarea> </label>
                    <input class="bouton"  type="submit" name="envoye" value="Envoyer">
                </form>
                <ul class="comm">
                    <?php
                    $listeCommentaire=$commentaireRepository->getAllCommentByVideo( $_GET['id_video'],$message);

                    foreach ($listeCommentaire as $content){
                        $membre=$compteRepository->getMemberById($content['id_compte'],$message);

                       if($content['id_compte']==$compteConnecter['id_compte']){
                           ?>

                           <li class="comm">

                               <img class="profil" src="<?php echo './uploads/' . $membre->photo ?>" alt="profil">
                               <?php echo "  " . $membre->login . " : " . $content['commentaire']; ?>
                               <div class="suppressionComm" >
                                   <a class="deleteComm" href="supprimerComm.php?id_video=<?php echo $_GET['id_video'] ?>&id_commentaire=<?php echo $content['id_commentaire'] ?>">x</a>
                               </div>
                           </li>
                           <?php

                       }else {
                           ?>

                           <li class="comm"><img class="profil" src="<?php echo './uploads/' . $membre->photo ?>"
                                                 alt="profil"><?php echo "  " . $membre->login . " : ";
                               echo $content['commentaire']; ?></li>

                           <?php
                       }
                    }
                    ?>

                </ul>
            </article>
        </footer>
    </section>
<?php include("inc/fin.inc.php"); ?>



