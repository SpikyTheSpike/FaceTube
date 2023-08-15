<?php include("inc/header.inc.php");
require_once("php/db_compte.php");
require_once("php/db_demande.php");

use Compte\CompteRepository as CompteRepository;
use Demande\DemandeRepository as DemandeRepository;
use Compte\Compte;
use demande\demande;
$compteRepository = new CompteRepository();
$demandeRepository = new DemandeRepository();
$message = '';
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}
?>
    <h2>Mes amis</h2>


    <section class="ami">


        <div class="demander">
            <form method="get" action="rechercheAmis.php">
                <label for="cherche"></label><input id="cherche" name="cherche" type="text" placeholder="Login / Email">
            </form>
        </div>

        <?php
        $nbr = $demandeRepository->getNumberCompteEnAttente($compteConnecter['id_compte'],$message);
        if(intval($nbr[0])>0) {

            ?>
            <h3> En attente </h3>
            <article class="confirme">
                <?php
                $enAttente = $demandeRepository->getAllCompteEnAttente($compteConnecter['id_compte'], $message);
                $i=0;

                foreach ($enAttente as $attente) {
                    ?>
                    <div class="ami">
                    <span class="ami"><img class="profilAmi" src="<?php echo './uploads/' . $enAttente[$i]['photo'] ?>"
                                           alt="video"> </span>
                        <a class="chaineUtilisateur" href="chaineAmi.php?id_compte=<?php echo $enAttente[$i]['id_compte']?>" <span class="ami"><?php echo $enAttente[$i]['login'] ?> </span></a>

                        <a class="ami" href="accepterAmi.php?id_compte=<?php echo $enAttente[$i]['id_compte']?>">Accepter</a>
                        <a class="ami" href="annulerInvitation.php?id_compte1=<?php echo $enAttente[$i]['id_compte']?>">Refuser</a>

                    </div>

                    <?php
                    $i++;
                }
                ?>
            </article>
            <?php
        }
            ?>

            <?php
            $nbrAmi = $demandeRepository->getNumberCompteAmi($compteConnecter['id_compte'],$message);
            if(intval($nbrAmi[0])>0) {

            ?>
        <h3> Mes amis </h3>
        <article class="confirme">

            <?php
            $mesAmis=$demandeRepository->getAllCompteAmis( $compteConnecter['id_compte'],$message);
            $j=0;

            foreach ($mesAmis as $ami){

                ?>
                <div class="ami">
                    <span class="ami"><img class="profilAmi" src="<?php echo './uploads/' . $mesAmis[$j]['photo'] ?>" alt="video" > </span>
                    <a class="chaineUtilisateur" href="chaineAmi.php?id_compte=<?php echo $mesAmis[$j]['id_compte']?>"  <span class="ami"><?php echo $mesAmis[$j]['login'] ?> </span></a>
                    <a class="ami" href="supprimerAmis.php?id_compte=<?php echo $mesAmis[$j]['id_compte']?>">Supprimer</a>
                </div>

                <?php
                $j++;
            }
            ?>


        </article>
        <?php
        }
        ?>

        <?php
            $nbrDemande=$demandeRepository->getNumberCompteDemande($compteConnecter['id_compte'],$message);

            if(intval($nbrDemande[0])>0) {
                ?>
                <h3>Mes demandes </h3>
                <article class="confirme">

                    <?php
                    $medDemande = $demandeRepository->getAllCompteMesDemande($compteConnecter['id_compte'], $message);
                    $m=0;

                    foreach ($medDemande as $demande) {
                        ?>
                        <div class="ami">

                    <span class="ami"><img class="profilAmi" src="<?php echo './uploads/' . $medDemande[$m]['photo'] ?>"
                                           alt="video"> </span>
                            <a class="chaineUtilisateur" href="chaineAmi.php?id_compte=<?php echo $medDemande[$m]['id_compte']?>"        <span class="ami"><?php echo  $medDemande[$m]['login']; ?> </span></a>
                            <a class="ami" href="annulerDemande.php?id_compte1=<?php echo  $medDemande[$m]['id_compte']?>">Annuler</a>

                        </div>

                        <?php
                        $m++;
                    }

                    ?>


                </article>
                <?php
            }
                ?>




    </section>
<?php include("inc/fin.inc.php"); ?>