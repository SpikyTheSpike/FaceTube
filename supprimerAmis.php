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

$demandeRepository->deleteAmi($compteConnecter['id_compte'], $_GET['id_compte'],$message);
header('location: ami.php');
?>

    <h2>Refuser ami</h2>
<?php include("inc/fin.inc.php"); ?>