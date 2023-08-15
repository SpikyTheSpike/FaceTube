<?php include("inc/header.inc.php"); ?>
<?php
require 'inc/myFctVideo.inc.php';
use Video\VideoRepository as VideoRepository;
use Video\Video;
$message = '';
$noError = true;
$videoRepository = new VideoRepository();
$id=$_GET['id_chaine'];
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}

?>
<?php

if (isset($_POST['creer'])) {

    $tmpname=$_FILES['minia']['tmp_name'];
    $name=$_FILES['minia']['name'];
    $size=$_FILES['minia']['size'];
    $error=$_FILES['minia']['error'];
    $type=$_FILES['minia']['type'];

    $name = str_replace(' ', '', $name);

    if(empty($name)){
        $name="default-video.jpg";
    }
    move_uploaded_file($tmpname, './uploads/'.$name);

    $video = new Video();
    $video->intitule = htmlentities($_POST['nom']);
    $video->description = htmlentities($_POST['description']);
    $video->html_fragment = htmlentities($_POST['frag']);    /* iframe   */
    $video->duree = $_POST['duree'];
    $video->url_apercu =$_POST['url'];     /* url de la video youtube */
    $video->date_ajout = date('j/m/y');
    $video->est_bloquee = 0;
    $video->miniature=$name;
    $video->id_chaine=$id;


    $noError=isValidVideo($video->intitule, $video->id_chaine,$message);
    if ($noError) {
        $noError = $videoRepository->storeVideo($video, $message);
    }


}

?>
	<h2>Ajouter une vidéo</h2>
<?php
if(isset($_POST['creer'])){
    $tab="La video ".htmlentities($_POST['nom'])." a été correctement ajouté à notre listing.";
    if(strcmp($message, $tab)===5){

        $class="valide";
    }else{

        $class="errorLogin";
    }
}
?>
    <span class="<?php echo $class;?>"> <?php echo  $message; ?> </span>
	<form class="formulaire" method="post" enctype="multipart/form-data">
				<label for="nom">Nom : <input id="nom" name="nom" type="text"  value="<?php if (!$noError && isset($_POST["nom"])) echo htmlentities($_POST["nom"]); ?>"  placeholder="Nom"></label>
				<label for="description">Description : <textarea id="description" name="description" rows="2" cols="50"  required > </textarea> </label>
                 <label for="frag">Fragment php du layer : <input id="frag" name="frag" type="text" value="<?php if (!$noError && isset($_POST["frag"])) echo htmlentities($_POST["frag"]); ?>"  ></label>
                <label for="duree">Durée : <input id="duree" name="duree" type="time"  value="<?php if (!$noError && isset($_POST["duree"])) echo htmlentities($_POST["duree"]); ?>" required ></label>
                 <label for="url">Url : <input id="url" name="url" type="text" value="<?php if (!$noError && isset($_POST["url"])) echo htmlentities($_POST["url"]); ?>"  pattern="https://www.youtube.com/.*"></label>
                <label for="minia">Miniature : <input id="minia" name="minia" type="file"  accept=".png, .jpg"  ></label>
				<label for="chaine">Chaîne : <input id="chaine" name="chaine" type="number"  value="<?php echo $id; ?>" disabled placeholder="Chaîne"></label>
				<input class="bouton" type="submit" name="creer" value="Créer">
	</form>


		<?php include("inc/fin.inc.php"); ?>