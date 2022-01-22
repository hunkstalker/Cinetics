<?php



?>
<!DOCTYPE html>
<head>
    <html lang="en">
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
      <source src="../media/waiting.mp4" type="video/mp4">
    </video>
    <div class="col-10 central-panel">
      <a href="../index.php" class="link">
        <h1 class="logo">Cinetics</h1>
      </a>

          <form id="signup-form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
              <div class="flex-container-signup">

                <div id="div-right">
                  <div class="mb-3">
                    <label for="spsw" class="form-label">New password (required)</label>
                    <input type="password" class="form-control" name="psw" id="spsw" required>
                  </div>
                  <div class="mb-3">
                    <label for="psw2" class="form-label">Repeat password (required)</label>
                    <input type="password" class="form-control" name="confirm_password" id="psw2" required>
                  </div>
                </div>

              </div>
              <div class="text-center">
                <button type="submit" class="btn signup-button" id="signup-submit">Send</button>
              </div>

          </form>
    </div>

  </div>
</body>

<!-- <script type="text/javascript" src="./js/index.js"></script> -->