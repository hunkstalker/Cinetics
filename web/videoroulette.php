<?php
require_once "../lib/auth.php";
require_once "../lib/pathFunctions.php";
require_once "../libdb/videoUpload.php";
require_once "../libdb/searchVideos.php";

auth();
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
  <link rel="stylesheet" type="text/css" href="../css/custom-two.css">
</head>

<body>
  <nav id="navbar" class="navbar navbar-dark bg-dark justify-content-around">
    <a href="../index.php"><img type="image" class="btn-nav" src="../media/home.png"></a>
    <a href="videoform.php"><img type="image" class="btn-nav" src="../media/uploadFile.png"></a>
    <a href="../lib/logout.php"><img type="image" class="btn-nav" src="../media/user.png"></a>
  </nav>

  <div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-center">

      <div>
        <video autoplay muted loop id="back-video">
          <source src="../media/waiting.mp4" type="video/mp4">
        </video>
      </div>

      <div id="central-panel" class="p-4 mt-3">
        <div class="d-flex align-items-center justify-content-center mt-5">
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="../js/style.js"></script>
</body>