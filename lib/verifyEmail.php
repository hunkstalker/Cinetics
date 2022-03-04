<?php
require_once '../libdb/updateAccounts.php';
require_once "../libdb/searchAccounts.php";

if (isset($_GET) && !empty($_GET) && count($_GET) == 2) {
  $usuari['mail'] = filter_input(INPUT_GET, 'mail');
  $usuari['activateCode'] = filter_input(INPUT_GET, 'code');

  if (activateAccount($usuari)) {
    $usuari = getUserData($usuari);
    session_start();
    $_SESSION['userStatusCode'] = 1;
    $_SESSION['username'] = $usuari['username'];
    $_SESSION['iduser'] = $usuari['iduser'];
    //Redirecció a la pràgina principal
    header("Location: ../web/mainpage.php");
    exit;
  }
}
header("Location: ../index.php");
exit;
?>