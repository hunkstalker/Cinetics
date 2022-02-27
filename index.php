<?php
require_once "./libdb/searchAccounts.php";
require_once "./libdb/searchVideos.php";

$err     = null;
$errUser = false;
$errPass = false;

// userStatus: 0 (sin estado) | 1 (sesión iniciada) | 2 (mail verificado) | 3 (email sin verificar)
if (isset($_COOKIE[session_name()])) {
  session_start();
  if ($_SESSION['userStatusCode'] == 1) {
    header("Location: ./web/mainpage.php");
    exit;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST['user']) && isset($_POST['psw'])) {
    $userPOST = filter_input(INPUT_POST, 'user');
    $passPOST = filter_input(INPUT_POST, 'psw');

    if ($_POST['user'] != '' && $_POST['psw'] != '') {
      $usuari['username'] = $userPOST;
      $usuari['pass']     = $passPOST;

      if (!searchUser($usuari)) {
        $err = true;
        //això és per posarho al primer input
        $user = $userPOST;
      } else {
        if (!isset($_COOKIE[session_name()])) {
          session_start();
        }
        $_SESSION['userStatusCode'] = 1;
        $_SESSION['username']       = $usuari['username'];
        $_SESSION['iduser']         = $usuari['iduser'];
        //Redirecció a la pràgina principal
        header("Location: ./web/videoform.php");
        exit;
      }
    }
  }
}
?>

<!DOCTYPE html>

<?php include "./includes/indexHead.php"?>

<body>
  <div id="web-content">
    <video class="d-none d-sm-flex" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
      <source src="./media/friends.mp4" type="video/mp4">
    </video>
    <!-- A partir de aquí el contenido de la web  -->

    <div class="container-fluid p-0">
      <div class="d-flex align-items-center justify-content-start">
        <!--
          - d-flex hace que el elemento ocupe todo el ancho.
          - d-flex se aplica a cada hijo que se quiera alinear.
          - d-flex te lo pone todo en línea (fila), entonces hay que poner el flex-column y hará que se coloque en columna.
          - Ojo! flex-column hará que align y justify se inviertan.
        -->
        <div id="panel" class="p-4 p-sm-4 mt-4 mt-sm-5 ms-sm-4">
          <div class="d-flex d-column justify-content-center">
            <a class="satisfy fw-bold mt-4 mb-4 mb-sm-2 text-center display-1 display-md-1 text-white" href="../index.php">Cinetics</a>
          </div>
          
          <div class="mt-0 mt-sm-3 d-flex justify-content-center">
            <?php
              if ($err) {
                echo '<p class="text-warning bg-dark text-center fw-bold">Incorrect username, email or password</p>';
              } else if (isset($_COOKIE[session_name()])) {
                if ($_SESSION['userStatusCode'] == 3) {
                  echo '<p class="text-warning bg-dark text-center fw-bold">Account not verified, check your mailbox</p>';
                } else if ($_SESSION['userStatusCode'] == 2) {
                  // Podríamos mandar al usuario a una página de bienvenida (y mostrar este mensaje) antes de llevarle a los vídeos
                  echo '<p class="text-success text-center fw-bold">The email has been verified, Welcome!</p>';
                  $_SESSION['userStatusCode'] = 0;
                }
              }
            ?>
          </div>

          <form class="mt-0 p-0 p-sm-4" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="mb-3">
              <label for="iemail" class="form-label mb-1 text-white">User or Email</label>
              <input type="text" class="form-control " id="iemail" name="user" required aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="ipassword" class="form-label mb-1 text-white">Password</label>
              <input type="password" class="form-control" id="ipassword" name="psw" required>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <div class="mt-1 mb-1 form-check">
                <input type="checkbox" class="form-check-input" id="remember-me">
                <label for="remember-me" class="text-white form-check-label">Remember me</label>
              </div>
              <div class="mt-1 mb-1 d-flex">
                <a class="text-white" href="./web/forgotpsw.php">Forgot password?</a>
              </div>
            </div>
            <div class="mt-4 mb-2">
              <button type="submit" class="custom-btn mt-5 mt-sm-3">Log in</button>
            </div>
          </form>

          <div class="d-flex flex-column align-items-center">
            <p class="text-center text-white mt-4 mt-sm-3 d-block h4">Not yet a memeber? No worry!</p>
            <a class="text-center text-white mt-4 mt-sm-3 w-25" href="./web/signup.php">Sign up</a>
          </div>

        </div>
      </div>
    </div>
</body>

<!-- <script type="text/javascript" src="./js/index.js"></script> -->