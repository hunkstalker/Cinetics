<?php
    session_start();
    if(!isset($_SESSION['authorized'])){
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <?php
        echo
        '<div class="container">
            <h1>Acceso permitido</h1>
            <p>La sesión del usuario ' . $_SESSION['username'] . ' está iniciada</p>
            <a class="btn btn-outline-primary " href="./lib/logout.php" role="button">Cerrar Sesión</a>
        </div>';
    ?>
</body>
</html>