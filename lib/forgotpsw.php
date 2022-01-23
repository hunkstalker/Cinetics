<?php
    require_once 'phpmailer.php';
    require_once 'updates.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $userPOST = filter_input(INPUT_POST, 'user');

        if ($_POST['email'] != '') {
            $usuari['email'] = $userPOST;
            // Generar un Token
            $urlActivationCode = createGetValues($usuari['email'], $resetPassCode);
            // Verificar que existe una cuenta asociada al mail (BBDD)
            // Guardar Token en BBDD junto una fecha de caducidad
            searchEmail($usuari['email'], $resetPassCode);
            // Enviar el mail con un urlResetCode
            sendEmailResetPsw($usuari['email'], $urlActivationCode);
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
    <link rel="stylesheet" type="text/css" href="../css/custom.css">
</head>
<body>
  <video autoplay muted loop id="backVideo">
    <source src="../media/friends.mp4" type="video/mp4">
  </video>
  <div class="col-4 lateral-panel">
      <a href="../index.php" class="link">
        <h1 class="logo">Cinetics</h1>
      </a>
      <form id="login-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h4>We can save you from your bad memory</h4>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Enter your email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
          </div>

          <button type="submit" id="recover-button" class="btn submit-button">Save me</button>
      </form>

      <div class="sign-up-help">
        <h4>Not yet a memeber? No worry!</h4>
        <a href="./signup.php">Sign up</a>
      </div>

  </div>
</body>