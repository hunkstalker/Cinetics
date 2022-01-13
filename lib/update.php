<?php
    $bbdd = (object)null;
    require 'conexionDB.php';

    $sqlinsert = 'UPDATE `users` SET `lastSignIn` = NOW() WHERE `username` = :username OR `mail` = :mail';
        $preparada = $bbdd->prepare($sqlinsert);
        $preparada->execute(array(':username' => $usuari['user'], ':mail' => $usuari['user']));
?>