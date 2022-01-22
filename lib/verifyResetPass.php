<?php
require_once 'users.php';

if (isset($_GET)) {
    $usuari['mail']=$_GET['mail'];
    $usuari['activateCode']=$_GET['code'];
    searchAccount($usuari);
    
}
header("Location: ../index.php");
?>