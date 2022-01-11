<?php
  $err = null;
  require "./lib/login.php";
  if($_SERVER["REQUEST_METHOD"] == "POST"){
      
    if(isset($_POST['user']) && isset($_POST['psw'])){
      $userPOST = filter_input(INPUT_POST, 'user');
      $passPOST = filter_input(INPUT_POST, 'psw');

      if($_POST['user']!='' && $_POST['psw']!=''){
        $usuari['user'] = $userPOST;
        $usuari['pass'] = $passPOST;

        if(!verificaUsuari($usuari)){
          $err = TRUE;
          //això és per posarho al primer input
          $user = $userPOST;
        }else{
            session_start();
            $_SESSION['user'] = $usuari['user'];
            $_SESSION['authorized']=TRUE;
            //TODO: tema de la cookie permanent si està clickada
            //Redirecció a la pràgina principal
            header("Location: ./mainPage.php");
            exit;
        }
      }
    }
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
    <!-- <script type="text/javascript" src="app.js"></script> -->
</head>
<body>
  <video autoplay muted loop id="backVideo">
    <source src="friends.mp4" type="video/mp4">
  </video>
  <div class="col-4 lateral-panel">
    <h1 class="logo">Cinetics</h1>
    <?php
    if($err){
      echo '<p class="text-danger text-center" style="font-weight: bold;">No se ha encontrado el usuario</p>';
    }
    ?>
      <form id="login-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <div class="mb-3">
            <label for="iemail" class="form-label">User or Email</label>
            <input type="text" class="form-control " id="iemail" name="user" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="ipassword" class="form-label">Password</label>
            <input type="password" class="form-control " id="ipassword" name="psw">
          </div>
          <div class="flex-container" >
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="remember-me">
              <label class="form-check-label" for="remember-me">Remember me</label>
            </div>
            <div class="check-forgot">
              <a href="./web/forgotpsw.html">Forgot password?</a>
            </div>
          </div>
          <button type="submit" class="btn submit-button" id="login-submit">Log in</button>
      </form>
        <?php
          if($err){
            if($usuari['user']==""){
              echo "<script>document.querySelector('.lateral-panel input[type='text']').classList.add('mystyle');</script>";
            }
            if($usuari['pass']==""){

            }
          }
        ?>
      <div class="sign-up-help">
        <h4>Not yet a memeber? No worry!</h4>
        <a href="./lib/signup.php">Sign up</a>
      </div>

  </div>
</body>

<script type="text/javascript" src="./js/index.js"></script>