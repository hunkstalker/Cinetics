<?php
require_once "../lib/auth.php";
require_once "../lib/pathFunctions.php";
require_once "../libdb/videoUpload.php";
require_once "../libdb/searchVideos.php";

auth();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
<head>
  <html lang="en">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel = 'icon' href = '../media/logo.png' type = 'image/x-icon'>
  <title>Cinetics</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- TODO: cambiar este css al unificado custom.css -->
  <link rel="stylesheet" type="text/css" href="../css/custom.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>

<body>
  <nav id="navbar" class="navbar navbar-dark bg-dark justify-content-around">
    <a href="../index.php"><img type="image" class="btn-nav" src="../media/home.png"></a>
    <a href="./videoform.php"><img type="image" class="btn-nav" src="../media/uploadFile.png"></a>
    <a href="../lib/logout.php"><img type="image" class="btn-nav" src="../media/user.png"></a>
  </nav>

  <div class="d-flex justify-content-center ">
    <div id="mainpage-panel">
        <div class="embed-responsive embed-responsive-21by9">
            <video width="100%" height="auto" controls autoplay loop muted>
              <?php echo("<source src='". $selectedVideo . "' type='video/mp4'>") ?>                
            </video>
        </div>
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-around thumbs-group">
                <i class="bi-hand-thumbs-up thumbs-up"></i>
                <p>1200</p>
                <i class="bi-hand-thumbs-down thumbs-down"></i>
            </div>
            <p class="px-3 video-description"><?php echo($description) ?></p>
            <p class="px-3 video-hashtag"><?php echo($hashtagsVideo) ?></p>
        </div>
    </div>

  </div>

  <script src="../js/style.js"></script>
</body>