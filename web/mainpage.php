<?php
require_once "../lib/auth.php";
require_once "../lib/pathFunctions.php";
require_once "../libdb/videoUpload.php";
require_once "../libdb/searchVideos.php";

auth();
$likeClass = "bi-hand-thumbs-up";
$dislikeClass = "bi-hand-thumbs-down";
$videoInfo;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(isset($_POST['reaction'])) {
      $reactionPOST = filter_input(INPUT_POST, 'reaction');
      $idvideoPOST = filter_input(INPUT_POST, 'lastvideo');
      //TODO: posar videos de mostra i anar veient que tot rutlla
      //First update user reaction with a check inside to avoid repetitive reactions
      $iduserSession = $_SESSION['iduser'];
      if(!sameUserReaction($reactionPOST, $iduserSession, $idvideoPOST)) {
        updateUserReaction($reactionPOST, $iduserSession, $idvideoPOST);
        updateScore($idvideoPOST, $reactionPOST);
      } 
    }

    $randomId = randomVideo();
    $videoInfo = selectVideoById($randomId);
    $description = $videoInfo['description'];
    $filename = $videoInfo['fileName'];
    $selectedVideo = "../videoUploads/" . $filename;
    $hashtagsVideo = getHashtags($videoInfo['idvideo']);

  } else {

    if(firstCineticsVideo()) {
      $videoInfo = selectVideoById(1);
    } else {
      $idVideo = lastUserVideo($_SESSION['iduser']);
      if($idVideo) {
        $videoInfo = selectVideoById($idVideo);
      } else {
        $randomId = randomVideo();
        $videoInfo = selectVideoById($randomId);
      }
    }
  

    $description = $videoInfo['description'];
    $filename = $videoInfo['fileName'];
    $selectedVideo = "../videoUploads/" . $filename;
    $hashtagsVideo = getHashtags($videoInfo['idvideo']);
  }

  if($hashtagsVideo) {
    $explodeHashtags = explode("#", $hashtagsVideo);
    foreach ($explodeHashtags as $value) {
      if ($value != "") $hashtags[] = "#" . $value;
    }
  } else { $hashtags = array("");}

  $totalScore = getVideoScore($videoInfo['idvideo']);
  //if we use boolean condition will end in error if the reaction of this video was dislike
  //if getVideoReaction return a -1, it is like a error response
  $reaction = getVideoReaction($videoInfo['idvideo'], $_SESSION['iduser']); 
  if($reaction != -1) {
    if($reaction) {
      $likeClass = "bi-hand-thumbs-up-fill active-like";
    } else {
      $dislikeClass = "bi-hand-thumbs-down-fill active-dislike";
    }
  }

?>

<!DOCTYPE html>
<?php include "../includes/generalHead.php"?>
<!-- Ponemos aquí los iconos de modo temporal porque terminaremos usándolos como archivos locales. -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<body>
  <nav id="navbar" class="navbar d-none d-sm-flex navbar-dark bg-dark">
    <div>
      <a href="../index.php"><h1 class="satisfy ms-5 mb-0 display-6 display-md-6 text-white">Cinetics</h1></a>
    </div>
    <div>
      <a class="me-5" href="videoform.php"><img type="image" class="btn-nav" src="../media/uploadFile.webp" alt="Upload button"></a>
      <a class="me-5" href="../lib/logout.php"><img type="image" class="btn-nav" src="../media/logout_icon.webp" alt="Profile button"></a>
    </div>
  </nav>
  <div class="container p-0">
    <div class="d-flex align-items-center justify-content-center">
      <div id="panel" class="mainpage p-0 mt-4">
        <div class="my-0 embed-responsive embed-responsive-21by9">
          <video width="100%" height="auto" controls autoplay loop muted>
            <?php echo "<source src='". $selectedVideo . "' type='video/webm'>"?>
            <!-- Más del 70% de los navegadores son compatibles con el formato .webm, en caso de no ser compatibles y en un caso 
            real podríamos plantearnos poner un source alternativo a formato .mp4 a costa de requerir más espacio en disco. -->
          </video>
        </div>
        <div>
        <form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
          <div class="d-flex flex-column">
              <div class="d-flex justify-content-around thumbs-group pt-2 m-0">
                <label class="checkbox">
                  <input type="checkbox" name='reaction' value="1" style="display:none;" onChange="this.form.submit()"></inpu>
                  <!-- <i class="bi-hand-thumbs-up thumbs-up"></i> -->
                  <?php echo "<i name='reaction' class='". $likeClass . " thumbs-up' ></i>"?>
                </label>
                <?php echo "<p>" . $totalScore . "</p>"?>
                <label class="checkbox">
                  <input type="checkbox" name='reaction' value="0" style="display:none;" onChange="this.form.submit()"></inpu>
                  <!-- <i class="bi-hand-thumbs-down thumbs-down"></i> -->
                  <?php echo "<i class='". $dislikeClass . " thumbs-down'></i>"?>
                </label> 
                <?php echo "<input name='lastvideo' value='" . $videoInfo['idvideo'] . "' style='display:none;' />" ?>
              </div>
              <div class="px-4">
                <div class="d-flex align-items-center justify-content-center">
                  <?php foreach ($hashtags as $value) {
                      echo '<span class="badge rounded-pill bg-secondary mx-1">' . $value . '</span>';
                    }
                  ?>
                </div>
              </div>
              <div class="description mt-4 mt-ms-2">
                <p class="my-0 text-white"><?php echo ($description) ?></p>
              </div>
            </div>
          </div>
        </form>
      </div> <!-- Panel -->
    </div>
  </div> <!-- Container -->
  <nav id="navbar" class="navbar fixed-bottom d-sm-none navbar-dark bg-dark justify-content-around">
    <a href="../index.php"><img type="image" class="btn-nav" src="../media/home.webp" alt="Home button"></a>
    <a href="videoform.php"><img type="image" class="btn-nav" src="../media/uploadFile.webp" alt="Upload button"></a>
    <a href="../lib/logout.php"><img type="image" class="btn-nav" src="../media/logout_icon.webp" alt="Profile button"></a>
  </nav>
  <script src="../js/style.js"></script>
</body>