<?php
require_once "../lib/auth.php";
require_once "../lib/logs.php";
require_once "../lib/pathFunctions.php";
require_once "../libdb/videoUpload.php";
require_once "../libdb/searchVideos.php";

auth();

$errorFileSize = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (count($_POST) >= 1) {
    $mida = $_FILES["user_file"]["size"];
    // CONFIGURADO EL php.ini EN 100MB
    if ($mida > (1024 * 1024) * 100) {
      $errorFileSize = true;
    } else {
      // Sólo se ha eliminado el title del diseño, dejo esto así para que no pete en bbdd
      $video['title'] = "";
      $video['description'] = filter_input(INPUT_POST, 'description');
      // Nos aseguramos de que la carpeta de subida de los vídeos existe y sino la crea
      // MERGE: !!
      $filepath = createFilePath($_FILES['user_file']['tmp_name']);
      if (!file_exists($filepath)) {
        mkdir($filepath, 0700);
      }
      $hashValue = $_SESSION['username'] . date('YmdHms');
      // Hash sha256: el filename serán 64 carácteres
      $filename = hash('sha256', $hashValue);
      $ext = explode('.', $_FILES['user_file']['name']);
      $pathfile = $filepath . '/' . $filename . '.' . $ext[1];
      $video['filename'] = $filename;
      // RECORDATORIO: ESTO FUERA, ES PREFERIBLE QUE SALTE ERROR DE INSERT QUE NO CONSULTAR TODOS LOS HASHTAGS Y FILTRAR
      // $hashtags = consultadeHashtags();
      // if($hashtags != false AND $hashtags != NULL){
      //   $newHashtags = array_diff($video['hashtags'], $hashtags);
      // } else {
      //   $newHashtags = $video['hashtags'];
      // }
      $idhashtags;
      try {
        $res = move_uploaded_file($_FILES['user_file']['tmp_name'], $pathfile);
        $idvideo = guardarVideo($video, $_SESSION['iduser']);
        // Comprobamos si nos viene vacío
        if (!empty(filter_input(INPUT_POST, 'hashtags'))) {
          // Limpieza de hashtags repetidos
          $video['hashtags'] = array_unique(array_map('trim', explode(",", filter_input(INPUT_POST, 'hashtags'))));
          // SALTARÁN ERRORES POR INTENTAR INSERTAR VALORES QUE YA ESTÁN. LOS OMITIMOS
          $idhashtags = guardarHashtags($video['hashtags']);
          // CONSULTAS INNECESARIAS, NOS LLEVAMOS LAS IDs AL INSERTARLAS
          // $idvideo    = consultaVideoId($filename);
          // $idhashtags = consultaHashtagId($video['hashtags']);
          guardarVideoHashtags($idvideo, $idhashtags);
        }
      } catch (PDOException $e) {
        fatalError('InsertVideoError', $e->getMessage());
      }
      if ($res) {
        header("Location: videoRoulette.php");
        exit;
      } else {
        fatalError("ErrorMove_Uploaded_File");
      }
    }
  }
}
?>

<!DOCTYPE html>
<?php include "../includes/generalHead.php"?>

<body>
  <div id="web-content">
    <video class="d-none d-sm-flex" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
      <source src="../media/waiting.mp4" type="video/mp4">
    </video>
    <nav id="navbar" class="navbar d-none d-sm-flex navbar-dark bg-dark">
      <div>
        <a href="../index.php"><h1 class="satisfy ms-5 mb-0 display-6 display-md-6 text-white">Cinetics</h1></a>
      </div>
      <div>
        <a class="me-5" href="videoform.php"><img type="image" class="btn-nav" src="../media/uploadFile.png"></a>
        <a class="me-5" href="../lib/logout.php"><img type="image" class="btn-nav" src="../media/user.png"></a>
      </div>
    </nav>
    <!-- Navbar superior tablet/desktop -->
    <!-- A partir de aquí el contenido de la página  -->
    <div class="container-fluid p-0">
      <div class="d-flex align-items-center justify-content-center">
        <div id="panel" class="p-4 p-sm-5 mt-4">
          <form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <div class="mt-5 mb-4">
              <p class="satisfy mb-5 text-center display-6 text-white">Upload your first video!</p>
            </div>
            <div class="mb-5">
              <input id="formFile" name="user_file" class="form-control" type="file">
              <?php if($errorFileSize){ echo '<p class="text-warning bg-dark text-center" style="font-weight: bold;">Archivo demasiado grande (límite 100 MB)</p>'; } ?>
            </div>
            <div class="mb-4">
              <label for="hashtags" class="form-label mb-0 text-white">Hashtags</label>
              <input type="text" class="form-control" name="hashtags">
            </div>
            <div class="mb-4">
              <label for="description" class="form-label mb-0 text-white">Description</label>
              <input type="text" class="form-control" name="description">
            </div>
            <div class="mt-5">
              <button type="submit" class="custom-btn">Send</button>
            </div>
          </form>
        </div> <!-- Panel -->
      </div>
    </div> <!-- Container -->
  </div> <!-- Web-Content -->
  <nav id="navbar" class="navbar fixed-bottom d-sm-none navbar-dark bg-dark justify-content-around">
    <a href="../index.php"><img type="image" class="btn-nav" src="../media/home.png"></a>
    <a href="videoform.php"><img type="image" class="btn-nav" src="../media/uploadFile.png"></a>
    <a href="../lib/logout.php"><img type="image" class="btn-nav" src="../media/user.png"></a>
  </nav>
  <!-- Navbar inferior móvil -->
</body>