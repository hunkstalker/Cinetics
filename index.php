<?php
require_once "./lib/verifyUser.php";

$err = null;
$errUser = false;
$errPass = false;

// userStatus: 0 (sesión no iniciada) | 1 (sesión iniciada) | 2 (mail verificado) | 3 (email sin verificar)
if (isset($_COOKIE[session_name()])) {
    session_start();
    if($_SESSION['userStatusCode']==1){
        header("Location: ./mainPage.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['user']) && isset($_POST['psw'])) {
        $userPOST = filter_input(INPUT_POST, 'user');
        $passPOST = filter_input(INPUT_POST, 'psw');

        if ($_POST['user'] != '' && $_POST['psw'] != '') {
            $usuari['username'] = $userPOST;
            $usuari['pass'] = $passPOST;

            if (!login($usuari)) {
                $err = true;
                //això és per posarho al primer input
                $user = $userPOST;
            } else {
                if (!isset($_COOKIE[session_name()])) {
                    session_start();
                }
                $_SESSION['userStatusCode'] = 1;
                $_SESSION['username'] = $usuari['username'];
                //Redirecció a la pràgina principal
                header("Location: mainPage.php");
                exit;
            }
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
    <link rel="stylesheet" type="text/css" href="./css/custom.css">
    <!-- <script type="text/javascript" src="app.js"></script> -->
</head>
<body>
  <video autoplay muted loop id="backVideo">
    <source src="./media/friends.mp4" type="video/mp4">
  </video>

  <div class="col-4 lateral-panel">
    <a href="#" class="link">
      <h1 class="logo">Cinetics</h1>
    </a>

    <?php
    if ($err) {
        echo '<p class="text-warning bg-dark text-center" style="font-weight: bold;">Incorrect username, email or password</p>';
    }else if(isset($_COOKIE[session_name()])) {
        if($_SESSION['userStatusCode']==2){
            echo '<p class="text-success bg-dark text-center" style="font-weight: bold;">The email has been verified, Welcome!</p>';
            $_SESSION['userStatusCode']=0;
        }
    }
    ?>
      <form id="login-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <div class="mb-3">
            <label for="iemail" class="form-label">User or Email</label>
            <input type="text" class="form-control " id="iemail" name="user" required aria-describedby="emailHelp">

          </div>
          <div class="mb-3">
            <label for="ipassword" class="form-label">Password</label>
            <input type="password" class="form-control " id="ipassword" name="psw" required>

          </div>
          <div class="flex-container" >
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="remember-me">
              <label for="remember-me" class="form-check-label">Remember me</label>
            </div>
            <div class="check-forgot">
              <a href="./lib/forgotpsw.php">Forgot password?</a>
            </div>
          </div>
          <button type="submit" class="btn submit-button" id="login-submit">Log in</button>
      </form>
      <div class="sign-up-help">
        <h4 class="mb-3">Not yet a memeber? No worry!</h4>
        <a href="./lib/signup.php">Sign up</a>
      </div>

  </div>
</body>

<!-- <script type="text/javascript" src="./js/index.js"></script> -->