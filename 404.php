<!DOCTYPE html>
<?php include "./includes/indexHead.php"?>

<body>
  <div id="web-content">
    <video class="d-none d-sm-flex" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
      <source src="../media/confused_404.webm" type="video/mp4">
    </video>
    <!-- A partir de aquí el contenido de la página  -->
    <div class="container-fluid p-0">
      <div class="d-flex align-items-center justify-content-center">
        <div id="panel" class="p-4 p-sm-5 mt-4 mt-sm-5 recoverpsw">
          <div class="d-flex flex-column align-items-center">
						<a href="../index.php"><h1 class="mt-4 mb-4 mb-sm-2 display-1 text-white">404</h1></a>
            <p class="h1 text-center text-white mt-4">Page not found</p>
            <a href="./index.php"><p class="link h4 text-center text-white mt-5 mb-3">Do you want to be rescued?</p></a>
          </div>
        </div> <!-- Panel -->
      </div>
    </div> <!-- Container -->
  </div> <!-- Web-Content -->
</body>