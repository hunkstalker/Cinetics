<?php
function nouUsuari($usuari)
{
    require 'conexionDB.php';
    try
    {
        $mail = $usuari['mail'];
        $username = $usuari['username'];
        $hash = password_hash($usuari['pss'], PASSWORD_BCRYPT);
        $fname = $usuari['fname'];
        $sname = $usuari['sname'];

        $sql = 'SELECT mail FROM `users` WHERE `mail` = :mail';
        $preparada1 = $db->prepare($sql);
        $preparada1->execute(array(':mail' => $mail));

        if (!$preparada1) {
            $sql = 'SELECT username FROM `users` WHERE `username` = :username';
            $preparada2 = $db->prepare($sql);
            $preparada2->execute(array(':username' => $username));

            if (!$preparada2) {
                $sqlinsert = "INSERT INTO `users` (`mail`,`username`,`passHash`,`userFirstName`,`userLastName`)
                    VALUES(:mail,:username,:pass,:fname,:sname)";
                $preparada3 = $db->prepare($sqlinsert);
                $preparada3->execute(array(':mail' => $mail, ':username' => $username, ':pass' => $hash,
                    ':fname' => $fname, ':sname' => $sname));
                return true;
            } else {
                echo 'Error amb usuari o email';
                return 2;
            }
        } else {
            echo 'Error amb usuari o email';
            return 1;
        }

    } catch (PDOException $e) {
        echo 'Error amb la BDs: ' . $e->getMessage();
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
    <source src="../friends.mp4" type="video/mp4">
  </video>
  <div class="col-4 lateral-panel">
    <h1 class="logo">Cinetics</h1>
      <form id="login-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          <div class="mb-3">
            <label for="isuer" class="form-label">Username (required)</label>
            <input type="text" class="form-control " id="isuer" name="user">
          </div>
          <div class="mb-3">
            <label for="iemail" class="form-label">Email (required)</label>
            <input type="email" class="form-control " id="iemail" name="email" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="ifirstname" class="form-label">Firstname (optional)</label>
            <input type="text" class="form-control " id="ifirstname" name="firstname">
          </div>
          <div class="mb-3">
            <label for="ilastname" class="form-label">Lastname (optional)</label>
            <input type="text" class="form-control " id="ilastname" name="lastname">
          </div>

          <div class="mb-3">
            <label for="ipassword" class="form-label">Password (required)</label>
            <input type="password" class="form-control " id="ipassword" name="psw">
          </div>
          <div class="mb-3">
            <label for="iverfyPassword" class="form-label">Verify password (required)</label>
            <input type="password" class="form-control " id="iverfyPassword" name="repsw">
          </div>
          <button type="submit" class="btn signup-button">Confirm</button>
      </form>
    </div>
</body>
