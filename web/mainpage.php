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
      <a class="me-5" href="../lib/logout.php"><img type="image" class="btn-nav" src="../media/user.webp" alt="Profile button"></a>
    </div>
  </nav>

  <div class="d-flex justify-content-center ">
    <div id="mainpage-panel">
        <div class="embed-responsive embed-responsive-21by9">
            <video width="100%" height="auto" controls autoplay loop muted>
              <?php echo("<source src='". $selectedVideo . "' type='video/mp4'>") ?>                
            </video>
        </div>
        <form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
          <div class="d-flex flex-column">
              <div class="d-flex justify-content-around thumbs-group">
                <label class="checkbox">
                  <input type="checkbox" value="1" style="display:none;" onChange="this.form.submit()"></inpu>
                  <i class="bi-hand-thumbs-up thumbs-up"></i>
                </label>
                <p>1200</p>
                <label class="checkbox">
                  <input type="checkbox" value="-1" style="display:none;" onChange="this.form.submit()"></inpu>
                  <i class="bi-hand-thumbs-down thumbs-down"></i>
                </label> 
              </div>
              <p class="px-3 video-description"><?php echo($description) ?></p>
              <p class="px-3 video-hashtag"><?php echo($hashtagsVideo) ?></p>
          </div>
        </form>
    </div>

  </div>

  <script src="../js/style.js"></script>
</body>