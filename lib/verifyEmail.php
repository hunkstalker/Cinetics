<?php
require_once 'updates.php';

// userStatus: 0 (sesión no iniciada) | 1 (sesión iniciada) | 2 (email verificado) | 3 (mail sin verificar)
if (isset($_COOKIE[session_name()]) && isset($_GET)) {
    session_start();
    if($_SESSION['userStatusCode']==3){
        $usuari['mail']=$_GET['mail'];
        $usuari['activateCode']=$_GET['code'];
        if(activateAccount($usuari)){
            $_SESSION['userStatusCode']=2;   
        }
    }
    header("Location: ../index.php");
}
?>