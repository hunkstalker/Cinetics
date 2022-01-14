<?php
session_start();
require_once "./lib/controlNewUser.php";

if (isset($_SESSION['authorized'])) {
    header("Location: mainPage.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (count($_POST) == 6) {
        $userPOST = filter_input(INPUT_POST, 'username');
        $emailPOST = filter_input(INPUT_POST, 'email');
        $fnamePOST = filter_input(INPUT_POST, 'firstname');
        $snamePOST = filter_input(INPUT_POST, 'lastname');
        $passPOST = filter_input(INPUT_POST, 'psw');
        $confirmPassPOST = filter_input(INPUT_POST, 'confirm_password');

        $usuari['username'] = $userPOST;
        $usuari['email'] = $emailPOST;
        $usuari['fname'] = $fnamePOST;
        $usuari['sname'] = $snamePOST;
        $usuari['pss'] = $passPOST;

        if (nouUsuari($usuari, $emailDuplicat, $usuariDuplicat)) {
            $_SESSION['registered'] = true;
            header("Location: ./index.php");
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
</head>
<body >
  <div class="signup-body">
    <video autoplay muted loop id="backVideo">
      <source src="./media/waiting.mp4" type="video/mp4">
    </video>
    <div class="col-10 central-panel">
      <a href="index.php" class="link">
        <h1 class="logo">Cinetics</h1>
      </a>

          <form id="signup-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
              <div class="flex-container-signup">

                <div id="div-left">
                  <div class="mb-3">
                    <label for="username" class="form-label">Username (required)</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                    <?php
                    if (isset($usuariDuplicat) && $usuariDuplicat) {
                        echo '<p class="text-warning bg-dark" style="color:red"> This username is already in use</p>';
                    }
                    ?>
                  </div>
                  <div class="mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname">
                  </div>
                  <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname">
                  </div>
                </div>

                <div id="div-right">
                  <div class="mb-3">
                    <label for="semail" class="form-label">Email (required)</label>
                    <input type="email" class="form-control" id="semail" name="email" aria-describedby="emailHelp" required>
                    <?php
                    if (isset($emailDuplicat) && $emailDuplicat) {
                        echo '<p class="text-warning bg-dark" style="color:red"> This email is already in use</p>';
                    }
                    ?>
                  </div>
                  <div class="mb-3">
                    <label for="spsw" class="form-label">Password (required)</label>
                    <input type="password" class="form-control" name="psw" id="spsw" required>
                  </div>
                  <div class="mb-3">
                    <label for="psw2" class="form-label">Repeat password (required)</label>
                    <input type="password" class="form-control" name="confirm_password" id="psw2" required>
                  </div>
                </div>

              </div>
              <div class="text-center">
                <button type="submit" class="btn signup-button" id="signup-submit">Sign up</button>
              </div>

          </form>
    </div>

  </div>
</body>

<!-- <script type="text/javascript" src="./js/index.js"></script> -->