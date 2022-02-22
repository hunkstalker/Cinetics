<?php
require_once '../libdb/updateAccounts.php';
require_once '../lib/phpmailer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $userPOST = filter_input(INPUT_POST, 'email');

        try {
            $_POST['email'] != '';
            $usuari['email'] = $userPOST;
            // Generar un Token en BBDD junto una fecha de caducidad
            $urlActivationCode = createGetValues($usuari['email'], $resetPassCode);
            // Verificar que existe una cuenta asociada al mail (BBDD) y actualizar ActivationCode
            searchEmailAndUpdateCode($usuari['email'], $resetPassCode);
            // Enviar el mail con un urlResetCode
            sendEmailResetPsw($usuari['email'], $urlActivationCode);
            header("Location: recoverpsw.html");
            exit;
        } catch (PDOException $e) {
            fatalError("Activ. Account", $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>

<?php include "./includes/indexHead.php" ?>

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
        <a href="signup.php">Sign up</a>
      </div>

  </div>
</body>