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
      header("Location: recoverpsw.php?rcver=true");
      exit;
    } catch (PDOException $e) {
      fatalError("Activ. Account", $e->getMessage());
    }
  }
}
?>
<!DOCTYPE html>
<?php include "../includes/generalHead.php" ?>

<body>
  <div id="web-content">
    <video class="d-none d-sm-flex" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
      <source src="../media/friends.webm" type="video/mp4">
    </video>
    <!-- A partir de aquí el contenido de la página  -->
    <div class="container-fluid p-0">
      <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
        <div id="panel" class="p-4 p-sm-4 mt-4 mt-sm-5 ms-0 ms-lg-4">
          <div class="d-flex justify-content-center">
						<a href="../index.php"><h1 class="satisfy mt-4 mb-4 mb-sm-2 display-1 display-md-1 text-white">Cinetics</h1></a>
          </div>
					<p class="text-white text-center h5 mt-3 mb-5 mb-sm-3">We can save you from your bad memory</p>
          <form class="mt-0 p-0 p-sm-4" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="mb-3">
              <label for="iemail" class="form-label mb-1 text-white">Enter your email</label>
              <input type="email" class="form-control" id="iemail" name="email" required aria-describedby="emailHelp">
            </div>
            <div class="mt-5 mb-2">
              <button type="submit" class="custom-btn mt-5 mt-sm-3">Save me</button>
            </div>
            <div class="d-flex flex-column align-items-center">
              <p class="text-center text-white mt-5 h5">Not yet a memeber? No worry!</p>
							<a class="text-center text-white mt-4 mt-sm-3 w-25" href="signup.php">Sign up</a>
            </div>
          </form>
        </div> <!-- Panel -->
      </div>
    </div> <!-- Container -->
  </div> <!-- Web-Content -->
</body>