<!DOCTYPE html>
<?php
include "../includes/generalHead.php";

// userStatus: 0 (sesión no iniciada) | 1 (sesión iniciada) | 2 (mail verificado) | 3 (email sin verificar)
if (isset($_COOKIE[session_name()])) {
  session_start();
  if ($_SESSION['userStatusCode'] != 1) {
    header("Location: ../index.php");
    exit;
  }
} else {
  header("Location: ../index.php");
  exit;
}
?>

<body>
  <div id="web-content">
    <video class="d-none d-sm-flex" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
      <source src="../media/celebrate.webm" type="video/mp4">
    </video>
    <!-- A partir de aquí el contenido de la página  -->
    <div class="container-fluid p-0">
      <div class="d-flex align-items-center justify-content-center">
        <div id="panel" class="p-4 p-sm-5 mt-4 mt-sm-5 newmember">
          <div class="d-flex flex-column align-items-center">
            <a href="../index.php"><h1 class="satisfy mt-4 mb-4 mb-sm-2 display-1 text-white">Cinetics</h1></a>
            <p class="h1 text-center text-white mt-4">Welcome to our network!</p>
            <a href="../index.php"><p class="h4 text-center text-white mt-5 mb-3">Verify your email and come back &nbsp;;)</p></a>
          </div>
        </div> <!-- Panel -->
      </div>
    </div> <!-- Container -->
  </div> <!-- Web-Content -->
</body>