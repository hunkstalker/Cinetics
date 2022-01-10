<?php
  require "./lib/login.php";
  if($_SERVER["REQUEST_METHOD"] == "POST"){
      
    if(isset($_POST['user']) && isset($_POST['psw'])){
      $userPOST = filter_input(INPUT_POST, 'user');
      $passPOST = filter_input(INPUT_POST, 'psw');

      if($_POST['user']!='' && $_POST['psw']!=''){
        $usuari['user'] = $userPOST;
        $usuari['pass'] = $passPOST;

        if(!verificarUsuario($usuari)){
          $err = TRUE;
          //això és per posarho al primer input
          $user = $userPOST;
        }else{
            session_start();
            $_SESSION['usuari'] = $usuari['nom'];
            //TODO: tema de la cookie permanent si està clickada
            //Redirecció a la pràgina principal
            header("Location:mainpage.php");
            exit;
        }
      }else{
        if(empty($_POST['user'])){
          echo 'El campo user no puede estar vacío <br>';
        }
        if(empty($_POST['psw'])){
          echo 'El campo password no puede estar vacío';
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
    <script type="text/javascript" src="./js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="app.js"></script>  
</head>
<body>
  <video autoplay muted loop id="backVideo">
    <source src="friends.mp4" type="video/mp4">
  </video>
  <div class="col-4 lateral-panel">
    <h1 class="logo">Cinetics</h1>
      <form id="login-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <div class="mb-3">
            <label for="iemail" class="form-label">User or Email</label>
            <input type="text" class="form-control" id="iemail" name="user" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="ipassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="ipassword" name="psw">
          </div>
          <div class="flex-container">
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

      <div class="sign-up-help">
        <h4>Not yet a memeber? No worry!</h4>
        <a href="./web/signup.html">Sign up</a>
      </div>

  </div>
</body>