<?php
require_once "../lib/auth.php";
require_once "../lib/pathFunctions.php";
require_once "../libdb/videoUpload.php";
require_once "../libdb/searchVideos.php";

auth();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $randomId = randomVideo();
  $videoInfo = selectVideoById($randomId);
  $description = $videoInfo['description'];
  $filename = $videoInfo['fileName'];
  $selectedVideo = "../videoUploads/" . $filename;
  $hashtagsVideo = getHashtags($videoInfo['idvideo']);

} else {

  if (firstCineticsVideo()) {
    $videoInfo = selectVideoById(1);
  } else {
    $idVideo = lastUserVideo($_SESSION['iduser']);
    if ($idVideo) {
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

  $explodeHashtags = explode("#", $hashtagsVideo);
  foreach ($explodeHashtags as $value) {
    if ($value != "") $hashtags[] = "#" . $value;
  }
}
?>

<!DOCTYPE html>
<?php include "../includes/generalHead.php"?>
<!-- Ponemos aquí los iconos de modo temporal porque terminaremos usándolos como archivos locales. -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

<body>
  <div id="web-content">
    <nav id="navbar" class="navbar d-none d-sm-flex navbar-dark bg-dark">
      <div>
        <a href="../index.php">
          <h1 class="satisfy ms-5 mb-0 display-6 display-md-6 text-white">Cinetics</h1>
        </a>
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
              <?php echo "<source src='" . $selectedVideo . "' type='video/webm'>" ?>
              <!-- Más del 70% de los navegadores son compatibles con el formato .webm, en caso de no ser compatibles y en un caso
              real podríamos plantearnos poner un source alternativo a formato .mp4 a costa de requerir más espacio en disco. -->
            </video>
          </div>
          <div>
            <div class="d-flex flex-column">
              <div class="d-flex pt-2 justify-content-around thumbs-group">
                <label class="checkbox">
                  <input type="checkbox" value="1" style="display:none;" onChange="this.form.submit()"></inpu>
                  <div class="d-flex cercle align-items-center justify-content-center">
                    <i class="mb-1 bi-hand-thumbs-up thumbs-up"></i>
                  </div>
                </label>
                <p>1200</p>
                <label class="checkbox">
                  <input type="checkbox" value="-1" style="display:none;" onChange="this.form.submit()"></inpu>
                  <div class="d-flex cercle align-items-center justify-content-center">
                    <i class="bi-hand-thumbs-down thumbs-down"></i>
                  </div>
                </label>
              </div>
              <div class="px-4">
                <div class="ms-2 my-2 d-flex align-items-center justify-content-center">
                  <?php foreach ($hashtags as $value) {
                      echo '<span class="badge rounded-pill bg-secondary mx-1">' . $value . '</span>';
                  } ?>
                </div>
              </div>
              <div class="description mt-sm-5">
                <p class="my-0 video-description"><?php echo ($description) ?></p>
              </div>
            </div>
          </div>
        </div> <!-- Panel -->
      </div>
    </div><!-- Container -->
  </div> <!-- Web-Content -->
  <nav id="navbar" class="navbar fixed-bottom d-sm-none navbar-dark bg-dark justify-content-around">
    <a href="../index.php"><img type="image" class="btn-nav" src="../media/home.webp" alt="Home button"></a>
    <a href="videoform.php"><img type="image" class="btn-nav" src="../media/uploadFile.webp" alt="Upload button"></a>
    <a href="../lib/logout.php"><img type="image" class="btn-nav" src="../media/logout_icon.webp" alt="Profile button"></a>
  </nav>
  <script src="../js/style.js"></script>
</body>