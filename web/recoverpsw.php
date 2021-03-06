<!DOCTYPE html>
<?php
include "../includes/generalHead.php";

if (isset($_GET) && !empty($_GET) && count($_GET) == 1) {
  $recoverpsw = filter_input(INPUT_GET, 'rcver');
  if (!$recoverpsw) {
    header("Location: ../index.php");
    exit;
  }
} else {
  header("Location: ../index.php");
  exit;
}
?>

<!-- Hay que controlar el acceso a esta página, que sólo se pueda cuando se viene del formulario de recuperación de contraseña. -->
<body>
  <div id="web-content">
    <video class="d-none d-sm-flex" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
      <source src="../media/celebrate.webm" type="video/mp4">
    </video>
    <!-- A partir de aquí el contenido de la página  -->
    <div class="container-fluid p-0">
      <div class="d-flex align-items-center justify-content-center">
        <div id="panel" class="p-4 p-sm-5 mt-4 mt-sm-5 recoverpsw">
          <div class="d-flex flex-column align-items-center">
						<a href="../index.php"><h1 class="satisfy mt-4 mb-4 mb-sm-2 display-1 text-white">Cinetics</h1></a>
            <p class="h1 text-center text-white mt-4">We have just sent you a message!</p>
            <a href="../index.php"><p class="h4 text-center text-white mt-5 mb-3 link">Check your email and come back</p></a>
          </div>
        </div> <!-- Panel -->
      </div>
    </div> <!-- Container -->
  </div> <!-- Web-Content -->
</body>