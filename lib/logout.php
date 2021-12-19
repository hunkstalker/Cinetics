<?php        
    session_start();
    session_destroy();
    setcookie('KeepSigned_Hunk', '' ,time()-3600);
    header("Location: ../index.php");
    exit();
?>