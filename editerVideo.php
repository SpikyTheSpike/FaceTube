<?php include("inc/header.inc.php"); ?>
<?php
require 'inc/myFctVideo.inc.php';
use Video\VideoRepository as VideoRepository;
use Video\Video;
$message = '';
$noError = true;
$videoRepository = new VideoRepository();
$video=$videoRepository->getVideoById($_GET['id_video'],$message);
if(empty($_SESSION['connecter'])){
    header('location: index.php');
}
?>

<?php
if (isset($_POST['editer'])) {

    $tmpname = $_FILES['minia']['tmp_name'];
    $name = $_FILES['minia']['name'];
    $size = $_FILES['minia']['size'];
    $error = $_FILES['minia']['error'];
    $type = $_FILES['minia']['type'];

    if(empty($name)){
        $name=$video->miniature;
    }



    $name = str_replace(' ', '', $name);


    move_uploaded_file($tmpname, './uploads/' . $name);



    $videoNew = new Video();
    $videoNew->intitule = htmlentities($_POST['nom']);
    if($_POST['description']===" "){
        $videoNew->description = $video->description;
    }else{
        $videoNew->description = htmlentities($_POST['description']);
    }

    $videoNew->html_fragment = htmlentities($_POST['frag']);    /* iframe   */
    $videoNew->duree = $_POST['duree'];
    $videoNew->url_apercu = htmlentities($_POST['url']);     /* url de la video youtube */
    $videoNew->miniature = $name;

    $noError = $videoRepository->updateVideoById($videoNew ,$_GET['id_video'],$message);
    header('location:chaines.php');
}

?>
	<h2>Éditer Vidéo</h2>
<?php
echo $message;
?>
		<form class="formulaire" method="post" enctype="multipart/form-data">
            <label for="nom">Nom : <input id="nom" name="nom" type="text"  value="<?php echo $video->intitule ;?>"  placeholder="Nom"></label>
            <label for="description">Description : <textarea id="description" name="description" rows="2" cols="50"  required > </textarea> </label>
            <label for="frag">Fragment php du layer : <input id="frag" name="frag" type="text" value="<?php echo $video->html_fragment ;?>"  ></label>
            <label for="duree">Durée : <input id="duree" name="duree" type="time"  value="<?php echo $video->duree ;?>" required ></label>
            <label for="url">Url : <input id="url" name="url" type="text" value="<?php echo $video->url_apercu ;?>"  pattern="https://www.youtube.com/.*"></label>
            <label for="minia">Miniature : <input id="minia" name="minia" type="file"  accept=".png, .jpeg"  ></label>
            <label for="chaine">Chaîne : <input id="chaine" name="chaine" type="text"  value="<?php echo $video->id_chaine;?>" disabled placeholder="Chaîne"></label>
            <input class="bouton" type="submit" name="editer" value="Éditer">
		
		</form>
		<?php include("inc/fin.inc.php"); ?>