<?php include("inc/header.inc.php"); ?>
<?php
require 'inc/myFctChaine.inc.php';

use Chaine\ChaineRepository as ChaineRepository;
use Chaine\Chaine;
$chaineRepository = new ChaineRepository();
$message="";
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}
$chaineRepository->debloquerChaine($_GET['id_chaine'],$message);


header('location: listeChaine.php');

include("inc/fin.inc.php");