<?php
require_once "../lib/auth.php";
require_once "../lib/pathFunctions.php";
require_once "../libdb/videoUpload.php";

auth();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (count($_POST) >= 1) {

    $mida = $_FILES["user_file"]["size"];
    // He configurado el límite de php.ini en 100MB
    if ($mida > (1024 * 1024) * 100) {
      // Falta añadir el error en el log
      echo "<br>El fichero es demasiado grande ( >5MB )";
      return;
    }

    $video["title"]       = filter_input(INPUT_POST, 'title');
    // Separamos los hashtags por comas y eliminamos duplicados con array_unique
    $video["hashtags"]    = array_unique(explode(",", filter_input(INPUT_POST, 'hashtags')));
    $video["description"] = filter_input(INPUT_POST, 'description');

    // Nos aseguramos de que la carpeta de subida de los vídeos existe y sino la crea
    $filepath = createFilePath($_FILES["user_file"]["tmp_name"]);
    if (!file_exists($filepath)) {
      mkdir($filepath, 0700);
    }

    $randomValue = $_SESSION['username'] . date("YmdHms");
    $filename    = hash('sha256', $randomValue);
    $ext         = explode('.', $_FILES["user_file"]["name"]);
    $pathfile    = $filepath . '/' . $filename . '.' . $ext[1];
    $video["filename"] = $filename;

    // Hacer un SELECT y sacar los hashtags para comparar y guardar solo los nuevos
    try{
      $res = move_uploaded_file($_FILES["user_file"]["tmp_name"], $pathfile);
      guardarVideo($video, $_SESSION["iduser"]);
      guardarHashtags($video["hashtags"]);
    } catch (PDOException $e) {
      fatalError("InsertVideoError", $e->getMessage());
    }   

    if ($res) {
      // redirigir a la vista de videos y visionar lastvideoPath
    } else {
      // devolver error y reportar en el log
    }
  }
}
?>

<!DOCTYPE html>

<head>
  <html lang="en">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinetics</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../css/custom-two.css">
</head>

<body>

  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand font-title ms-1 fs-1" href="#">Cinetics</a>
      <div class="d-flex">
        <a href="videoform.php"><img type="image" class="btn-nav me-3 " src="../media/uploadFile.png"></a>
        <a href="../lib/logout.php"><img type="image" class="btn-nav me-3" src="../media/user.png"></a>
      </div>
    </div>
  </nav>

  <video autoplay muted loop id="back-video">
    <source src="../media/waiting.mp4" type="video/mp4">
  </video>

  <div class="col-12 central-panel">
    <h2 class="upload-text">Upload your first video!</h2>

    <form id="signup-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
      <div class="flex-container-signup">

        <div id="div-left">
          <div class="mb-4">
            <label for="file" class="form-label mb-0"></label>
            <input id="file" name="user_file" class="form-control" type="file" >
          </div>
          <div class="mb-5">
            <label for="title" class="form-label mb-0">Title</label>
            <input type="text" class="form-control" name="title">
          </div>
          <div class="mb-5">
            <label for="hashtags" class="form-label mb-0">Hashtags</label>
            <input type="text" class="form-control" name="hashtags">
          </div>
          <div class="mb-5">
            <label for="description" class="form-label mb-0">Description</label>
            <input type="text" class="form-control" name="description">
          </div>
        </div>
      </div>
      <div class="mb-5">
        <button type="submit" class="btn mt-4">Send</button>
      </div>
    </form>

  </div>
  </div>

</body>