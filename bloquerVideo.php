<?php include("inc/header.inc.php"); ?>
<?php
require 'php/db_video.php';

use Video\VideoRepository as VideoRepository;
use Video\Video;
$videoRepository = new VideoRepository();
$message="";
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}
$videoRepository->bloquerVideo($_GET['id_video'],$message);


header('location: listeChaine.php');

include("inc/fin.inc.php");