<?php
require_once 'connectionDB.php';
require_once 'logs.php';

function updateLastSignIn($usuari)
{
    try{
        $db = conexionBBDD();
        $sqlinsert = 'UPDATE `users` SET `lastSignIn` = NOW() WHERE `username` = :username OR `mail` = :mail';
        $preparada = $db->prepare($sqlinsert);
        $preparada->execute(array(':username' => $usuari['username'], ':mail' => $usuari['username']));
    }catch(PDOException $e)
    {
        fatalError("Update SignIn", $e->getMessage());
    }  
}

function activateAccount($usuari)
{
    try{
        $db = conexionBBDD();
        $sqlinsert = 'UPDATE `users` SET `active` = 1, `activationDate` = NOW() WHERE `mail` = :mail AND `activationCode` = :activationCode';
        $preparada = $db->prepare($sqlinsert);
        $preparada->execute(array(':mail' => $usuari['mail'], ':activationCode' => $usuari['activateCode']));
        userActivationSuccess($usuari);
        return true;
    }catch(PDOException $e)
    {
        fatalError("Activ. Account", $e->getMessage());
        return false;
    }
}

function updatePass($usuari)
{
    try{
        $passHash = password_hash($usuari['pass'], PASSWORD_BCRYPT);
        $db = conexionBBDD();
        $sqlinsert = 'UPDATE `users` SET `passHash` = :passHash WHERE `mail` = :mail AND `activationCode` = :activationCode';
        $preparada = $db->prepare($sqlinsert);
        $preparada->execute(array(':passHash' => $passHash, ':mail' => $usuari['mail'], ':activationCode' => $usuari['activateCode']));
        userActivationSuccess($usuari);
        return true;
    }catch(PDOException $e)
    {
        fatalError("Activ. Account", $e->getMessage());
        return false;
    }
}
?>