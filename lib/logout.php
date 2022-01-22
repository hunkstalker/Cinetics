<?php        
    //Ens unim a la sessió per poder-la liquidar
    session_start();
    //Netegem les variables de sessió creades (nom de l'usuari)
    $_SESSION = array();
    //Destruïm la sessió en si mateixa (en el costat server)
    session_destroy();
    //Eliminem la cookie de sessió (en el costat client)
    setcookie(session_name(), "", time() - 3600, "/");
    //Redirecció a Login
    header("Location: ../index.php");
    exit;
?>