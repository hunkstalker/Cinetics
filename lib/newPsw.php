<?php
require_once '../libdb/searchAccounts.php';
require_once '../libdb/updateAccounts.php';
require_once '../lib/phpmailer.php';
require_once 'logs.php';

if (isset($_GET) && !empty($_GET) && count($_GET) == 2) {
  $mail = filter_input(INPUT_GET, 'mail');
  $usuari['mail'] = $mail;
  $code = filter_input(INPUT_GET, 'code');
  $usuari['resetPassCode'] = $code;
  if (!searchAndVerify($usuari)) {
    header("Location: ../index.php");
    exit;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (count($_POST) == 4) {
    $passPOST = filter_input(INPUT_POST, 'psw');
    $confirmPassPOST = filter_input(INPUT_POST, 'confirm_password');
    $mailSubmit = filter_input(INPUT_POST, 'mail');
    $codeSubmit = filter_input(INPUT_POST, 'code');

    $usuari['pass'] = $passPOST;
    $usuari['confirmPass'] = $confirmPassPOST;
    $usuari['mail'] = $mailSubmit;
    $usuari['resetPassCode'] = $codeSubmit;

    if ($usuari['pass'] == $usuari['confirmPass']) {
      try {
        if (updatePass($usuari)) {
          sendEmailResetPswSuccess($usuari['mail']);
          header("Location: ../index.php");
          exit;
        }
      } catch (PDOException $e) {
        fatalError("errorUpdateNewPass", $e->getMessage());
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
      <source src="../media/celebrate.webm" type="video/mp4">
    </video>
    <!-- A partir de aquí el contenido de la página  -->
    <div class="container-fluid p-0">
      <div class="d-flex align-items-center justify-content-center">
        <div id="panel" class="p-4 p-sm-5 mt-4 mt-sm-5 newmember">
          <div class="d-flex flex-column align-items-center">
            <a href="../index.php"><h1 class="satisfy mt-4 mb-4 mb-sm-5 display-1 text-white">Cinetics</h1></a>
            <form id="signup-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
              <div class="flex-container-signup">
                <div id="div-right">
                  <div class="mb-3">
                    <label class="form-label text-white" for="psw" >New password (required)</label>
                    <input  id="psw" class="form-control" type="password" name="psw" onkeyup="check();" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label text-white" for="psw2" >Repeat password (required)</label>
                    <input id="psw2" class="form-control" type="password" name="confirm_password" onkeyup="check();" required>
                    <span id="message"></span>
                  </div>
                  <input type="hidden" id="mail" name="mail" value="<?php echo (isset($mail))?$mail:'';?>">
                  <input type="hidden" id="code" name="code" value="<?php echo (isset($code))?$code:'';?>">
                </div>
              </div>
              <div class="mt-5">
                <button type="submit" class="custom-btn">Send</button>
              </div>
            </form>
          </div>
        </div> <!-- Panel -->
      </div>
    </div> <!-- Container -->
  </div> <!-- Web-Content -->
  <script type="text/javascript" src="../js/passMatching.js"></script>
</body>