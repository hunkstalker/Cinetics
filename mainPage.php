<?php
// userStatus: 0 (sin estado) | 1 (sesión iniciada) | 2 (mail verificado) | 3 (email sin verificar)
if (isset($_COOKIE[session_name()])) {
    session_start();
    if ($_SESSION['userStatusCode'] != 1) {
        header("Location: index.php");
        exit;
    }
}else{
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinetics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/custom.css">
    <script type="text/javascript" src="./js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="app.js"></script>
</head>
<body>
  <video autoplay muted loop id="backVideo">
    <source src="./media/friends.mp4" type="video/mp4">
  </video>
  <div class="col-4 lateral-panel">
    <h1 class="logo">Cinetics</h1>
            <?php
            if (!isset($_COOKIE[session_name()])) {
                session_start();
            }
            echo
                '<h4 style="color: white;">Welcome ' . $_SESSION['username'] . '!</h4>
                <p class="text-success mt-3 bg-dark text-center" style="font-weight: bold;">Connection success</p>
                <div class="container">
                    <br>
                    <a class="btn submit-button" href="./lib/logout.php" role="button">Logout</a>
                </div>';
            ?>
      </form>
  </div>
</body>