<?php
require_once "../libdb/userRegister.php";

// userStatus: 0 (sesión no iniciada) | 1 (sesión iniciada) | 2 (mail verificado) | 3 (email sin verificar)
if (isset($_COOKIE[session_name()])) {
  session_start();
  if ($_SESSION['userStatusCode'] == 1) {
    header("Location: ../index.php");
    exit;
  }
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

    if (registroUsuario($usuari, $emailDuplicat, $usuariDuplicat)) {
      header("Location: newmember.php");
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<?php include "../includes/generalHead.php"?>

<body>
  <div id="web-content">
    <video class="d-none d-sm-flex" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
      <source src="../media/friends.mp4" type="video/mp4">
    </video>
    <!-- A partir de aquí el contenido de la página  -->
    <div class="container-fluid p-0">
      <div class="d-flex align-items-center justify-content-center">

        <div id="panel" class="p-4 p-sm-5 mt-4 mt-sm-5 h-100 signup">
          <div class="d-flex justify-content-center">
            <a href="../index.php">
              <h1 class="satisfy mt-2 mt-sm-3 mb-4 mb-sm-3 display-1 display-md-1 text-white">Cinetics</h1>
            </a>
          </div>
          <form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="row">
              <div class="col-12 col-sm-6 mb-3 mb-sm-5">
                <label for="username" class="form-label text-white">Username (required)</label>
                <input type="text" class="form-control" name="username" id="username" required>
                <?php
                  if (isset($usuariDuplicat) && $usuariDuplicat) {
                    echo '<p class="text-warning bg-dark" style="color:red">&nbsp This username is already in use</p>';
                  }
                ?>
              </div>
              <div class="col-12 col-sm-6 mb-3 mb-sm-5">
                <label for="semail" class="form-label text-white">Email (required)</label>
                <input type="email" class="form-control" id="semail" name="email" aria-describedby="emailHelp" required>
                <?php
                  if (isset($emailDuplicat) && $emailDuplicat) {
                    echo '<p class="text-warning bg-dark" style="color:red">&nbsp This email is already in use</p>';
                  }
                ?>
              </div>
            </div> <!-- 1st row -->
            <div class="row">
              <div class="col-12 col-sm-6 mb-3 mb-sm-5">
                <label for="firstname" class="form-label text-white">First Name</label>
                <input type="text" class="form-control" name="firstname" id="firstname">
              </div>
              <div class="col-12 col-sm-6 mb-3 mb-sm-5">
                <label for="psw" class="form-label text-white">Password (required)</label>
                <input type="password" class="form-control" name="psw" id="psw" required>
              </div>
            </div> <!-- 2nd row -->
            <div class="row">
              <div class="col-12 col-sm-6 mb-3 mb-sm-5">
                <label for="lastname" class="form-label text-white">Last Name</label>
                <input type="text" class="form-control" name="lastname" id="lastname">
              </div>
              <div class="col-12 col-sm-6 mb-3 mb-sm-5">
                <label for="psw2" class="form-label text-white">Repeat password (req.)</label>
                <input type="password" class="form-control" name="confirm_password" id="psw2" onkeyup='check();' required>
                <span id='message'></span>
              </div>
            </div> <!-- 3rd row -->
            <div class="row">
              <div class="col-12">
                <button type="submit" class="custom-btn mt-3 mb-3">Sign up</button>
              </div>
            </div> <!-- 4th row -->
          </form>
        </div> <!-- Panel -->
      </div>
    </div> <!-- Container -->
  </div> <!-- Web-Content -->
  <script type="text/javascript">
  function check() {
    var valuePsw = document.getElementById('psw').value;
    var valuePsw2 = document.getElementById('psw2').value;

    if (valuePsw == valuePsw2) {
      document.getElementById('message').style.color = 'green';
      document.getElementById('psw').style.borderColor = 'white';
      document.getElementById('psw2').style.borderColor = 'white';
      document.getElementById('message').innerHTML = 'Matching passwords';
    } else if (valuePsw != valuePsw2) {
      document.getElementById('message').style.color = 'red';
      document.getElementById('psw').style.borderColor = 'red';
      document.getElementById('psw2').style.borderColor = 'red';
      document.getElementById('message').innerHTML = 'Not matching passwords';
    }
  }
  </script>
</body>