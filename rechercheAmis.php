<?php include("inc/header.inc.php");

require_once("php/db_compte.php");
require_once("php/db_demande.php");

use Compte\CompteRepository as CompteRepository;
use Demande\DemandeRepository as DemandeRepository;
use Demande\Demande;
use Compte\Compte;
$compteRepository = new CompteRepository();
$demandeRepository = new DemandeRepository();
$message = '';
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}

?>

<h2>Recherché</h2>





        <?php
        $listCompte= $compteRepository->getAllCompte($_GET['cherche'], $compteConnecter['id_compte'],$message);
        $mesAmis=$demandeRepository->getAllCompteAmis( $compteConnecter['id_compte'],$message);
        $enAttente = $demandeRepository->getAllCompteEnAttente($compteConnecter['id_compte'], $message);
        $medDemande = $demandeRepository->getAllCompteMesDemande($compteConnecter['id_compte'], $message);
          $i=0;
          $j=0;
          $m=0;
          $n=0;

        ?>

            <article class="confirme">
                <?php
        if(sizeof($listCompte)==0){
            echo "Pas d'utilisateur trouver.";
        }else{
        foreach ($listCompte as $compte) {
            $isAmis=false;
            $isAtt=false;
            $isDem=false;

                foreach($mesAmis as $ami){

                    if($listCompte[$i]['id_compte']===$mesAmis[$j]['id_compte']){
                        $isAmis=true;
                    }

                    $j++;
                }

            foreach($enAttente as $att){

                if($listCompte[$i]['id_compte']===$enAttente[$m]['id_compte']){
                    $isAtt=true;
                }

                $m++;
            }

            foreach($medDemande as $dem){

                if($listCompte[$i]['id_compte']===$medDemande[$n]['id_compte']){
                    $isDem=true;
                }

                $n++;
            }



                ?>
                <div class="ami">
                    <span class="ami"><img class="profilAmi" src="<?php echo './uploads/' . $listCompte[$i]['photo']?>" alt="video" > </span>
                    <a class="chaineUtilisateur" href="chaineAmi.php?id_compte=<?php echo $listCompte[$i]['id_compte']?>"   <span class="ami"><?php echo $listCompte[$i]['login'] ?> </span></div>

                        <?php  if($isAmis){?>
                        <a class="ami" href="supprimerAmis.php?id_compte=<?php echo $listCompte[$i]['id_compte']?>">Supprimer</a>
                         <?php }elseif($isAtt){?>
                            <a class="ami" href="accepterAmi.php?id_compte=<?php echo $listCompte[$i]['id_compte']?>">Accepter</a>
                            <a class="ami" href="annulerInvitation.php?id_compte1=<?php echo $listCompte[$i]['id_compte']?>">Refuser</a>
                        <?php }elseif($isDem){?>
                            <a class="ami" href="annulerDemande.php?id_compte1=<?php echo $listCompte[$i]['id_compte']?>">Annuler</a>
                        <?php  }else{?>
                            <a  class="ami" href="ajouterAmi.php?id_compte=<?php echo $listCompte[$i]['id_compte']?>">Ajouter</a>
                        <?php  }?>

                </div>


                <?php
                $i++;
                $j=0;
                $m=0;
                $n=0;
        }
        }

        ?>


             </article>


<?php include("inc/fin.inc.php"); ?>
