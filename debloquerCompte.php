<?php include("inc/header.inc.php");

require_once("php/db_compte.php");
require_once("php/db_demande.php");

use Compte\CompteRepository as CompteRepository;


use Compte\Compte;
$compteRepository = new CompteRepository();

$message = '';

if(empty($_SESSION['connecter'])){
    header('location: index.php');
}
$compteRepository->debloqueMember($_GET['id_compte'], $message);
header('location: listeChaine.php');
?>

    <h2>Ajout ami</h2>
<?php include("inc/fin.inc.php"); ?>