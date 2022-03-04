<?php
require_once '../libdb/updateAccounts.php';

$usuari['mail'] = $_GET['mail'];
$usuari['activateCode'] = $_GET['code'];
if (activateAccount($usuari)) {
  $_SESSION['userStatusCode'] = 2;
}
header("Location: ../index.php");
exit;
?>