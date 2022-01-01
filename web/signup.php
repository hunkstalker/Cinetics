<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){

      require "../lib/controlNewUser.php";

        if(count($_POST)==6){
          $emailPOST = filter_input(INPUT_POST, 'email');  
          $userPOST = filter_input(INPUT_POST, 'username');
          $fnamePOST = filter_input(INPUT_POST, 'firstname');
          $snamePOST = filter_input(INPUT_POST, 'lastname');
          $passPOST = filter_input(INPUT_POST, 'psw');
    
          $usuari['username'] = $emailPOST;
          $usuari['email'] = $emailPOST;
          $usuari['fname'] = $fnamePOST;
          $usuari['sname'] = $snamePOST;
          $usuari['pss'] = $passPOST;

          if(nouUsuari($usuari))
          {
            echo 'Sha registrat correctament';
          }
          elseif(nouUsuari($usuari)==1)
          {
            $emailDuplicat = TRUE;
          }
          elseif(nouUsuari($usuari)==2)
          {
            $usuariDuplicat = TRUE;
          }

        }else{
            echo 'nothing to do $_POST';
        }
    }else{
        echo 'nothing to do $_SERVER';
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
<body >
  <div class="signup-body">
    <video autoplay muted loop id="backVideo">
      <source src="../waiting.mp4" type="video/mp4">
    </video>
    <div class="col-10 central-panel">
        <h1 class="logo">Cinetics</h1>
          <form id="signup-form" autocomplete="off">
              <div class="flex-container-signup">
                <div id="div-left">
                  <div class="mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname">
                  </div>
                  <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname">
                  </div>
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                    <?php
                        if(isset($emailDuplicat) && $emailDuplicat == TRUE)
                        {
                            echo '<p style="color:red">Usuari repetit</p>';
                        }
                    ?>
                  </div>

                </div>
                <div id="div-right">
                  <div class="mb-3">
                    <label for="semail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="semail" name="email" aria-describedby="emailHelp">
                    <?php
                        if(isset($emailDuplicat) && $emailDuplicat == TRUE)
                        {
                            echo '<p style="color:red">Email ja existeix, fes Login!</p>';
                        }
                    ?>
                  </div>
                  <div class="mb-3">
                    <label for="spsw" class="form-label">Password</label>
                    <input type="password" class="form-control" name="psw" id="spsw">
                  </div>
                  <div class="mb-3">
                    <label for="psw2" class="form-label">Repeat password</label>
                    <input type="password" class="form-control" name="psw2" id="psw2">
                  </div>
                </div>
              </div>
              <button type="submit" class="btn signup-button" id="signup-submit">Sign up</button>
          </form>
    </div>

  </div>
</body>