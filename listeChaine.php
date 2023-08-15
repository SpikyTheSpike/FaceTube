<?php include("inc/header.inc.php");
require_once("php/db_compte.php");
require_once("php/db_chaine.php");
require_once("php/db_video.php");
use Compte\CompteRepository as CompteRepository;
use Chaine\ChaineRepository as ChaineRepository;
use Video\VideoRepository as VideoRepository;
use Compte\Compte;
use Video\Video;
use Chaine\Chaine;
$compteRepository = new CompteRepository();
$chaineRepository = new ChaineRepository();
$videoRepository = new VideoRepository();
$message="";
$listeCompte=$compteRepository->getAll($message);
$listeChaine=$chaineRepository->getAllChaineAdmin($message);
$listeVideo=$videoRepository->getAllVideo($message);
?>
    <h2>Liste modération</h2>


<h3>Compte</h3>
<article class="moderation">
<?php

foreach ($listeCompte as $compte){
    ?>
    <div class="ami">
                    <span class="ami"><img class="profilAmi" src="<?php echo './uploads/' . $compte->photo ?>"
                                           alt="video"> </span>
        <a class="chaineUtilisateur" href="chaineAmi.php?id_compte=<?php echo $compte->id_compte?>" <span class="ami"><?php echo $compte->login ?> </span></a>
      <?php if ($compte->est_bloque==0){?>  <a href="bloquerCompte.php?id_compte=<?php echo $compte->id_compte; ?>" >Bloquer</a>
        <?php
    }else{
        ?>
        <a href="debloquerCompte.php?id_compte=<?php echo $compte->id_compte; ?>" >Débloquer</a>
        <?php
      }
        ?>
    </div>

    <?php
}
?>
</article>

    <h3>Chaine</h3>
    <article class="moderation">
<?php

foreach ($listeChaine as $chaine){
    ?>
    <div class="ami">

     <span class="ami"><?php echo $chaine->nom ?> </span>
        <?php if ($chaine->est_bloquee==0){?>  <a href="bloquerChaine.php?id_chaine=<?php echo $chaine->id_chaine; ?>" >Bloquer</a>
            <?php
        }else{
            ?>
            <a href="debloquerChaine.php?id_chaine=<?php echo $chaine->id_chaine; ?>" >Débloquer</a>
            <?php
        }
        ?>
    </div>

    <?php
}
?>
    </article>

    <h3>Vidéo</h3>
    <article class="moderation">
<?php

foreach ($listeVideo as $video){
    ?>
    <div class="ami">

        <span class="ami"><?php echo $video['intitule'] ;?> </span>
        <?php if ($video['est_bloquee']==0){?>  <a href="bloquerVideo.php?id_video=<?php echo $video['id_video']; ?>" >Bloquer</a>
            <?php
        }else{
            ?>
            <a href="debloquerVideo.php?id_video=<?php echo $video['id_video']; ?>" >Débloquer</a>
            <?php
        }
        ?>
    </div>

    <?php
}
?>
    </article>


<?php include("inc/fin.inc.php"); ?>