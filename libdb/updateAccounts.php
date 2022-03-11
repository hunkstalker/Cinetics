<?php
require_once 'connectionDB.php';

function updateLastSignIn($usuari)
{
    $db;
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
    $db;
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
    $db;
    try{
        $passHash = password_hash($usuari['pass'], PASSWORD_BCRYPT);
        $db = conexionBBDD();
        $sqlinsert = 'UPDATE `users` SET `passHash` = :passHash WHERE `mail` = :mail AND `resetPassCode` = :resetPassCode';
        $preparada = $db->prepare($sqlinsert);
        $preparada->execute(array(':passHash' => $passHash, ':mail' => $usuari['mail'], ':resetPassCode' => $usuari['resetPassCode']));
        userActivationSuccess($usuari);
        return true;
    }catch(PDOException $e)
    {
        fatalError("Activ. Account", $e->getMessage());
        return false;
    }
}

function updateRecovery($db, $email, $resetPassCode){
    try{
        // Le daremos al usuario 30 minutos de tiempo para poder cambiar el pass.
        $sqlinsert = 'UPDATE `users` SET `resetPassCode` = :resetPassCode, `resetPassExpiry` = DATE_ADD(NOW(), INTERVAL 30 MINUTE)  WHERE `mail` = :mail';
        $preparada = $db->prepare($sqlinsert);
        $preparada->execute(array(':resetPassCode' => $resetPassCode, ':mail' => $email));
        passResetSuccess($email);
    }catch(PDOException $e)
    {
        fatalError("Update resetPassCode", $e->getMessage());
    }
}

// Search & Update Date
function searchEmailAndUpdateCode($email, $resetPassCode)
{
    $db;
    try {
        $db = conexionBBDD();
        // Miramos si existe la cuenta
        $sql = 'SELECT mail FROM `users` WHERE `mail` = :mail';
        $preparada1 = $db->prepare($sql);
        $preparada1->execute(array(':mail' => $email));
        if ($preparada1->rowCount()>0) {
            try {
                // Si existe guardaremos el token del reset para el pass
                //$expireDate = date("Y-m-d H:i:s", time() + 1*60*60);
                $expireDate = date("Y-m-d H:i:s", strtotime("+1 hours"));
                $sqlinsert = 'UPDATE `users` SET `resetPassCode` = :resetPassCode, `resetPassExpiry` = :resetPassExpiry WHERE `mail` = :mail';
                $preparada = $db->prepare($sqlinsert);
                $preparada->execute(array(':resetPassCode' => $resetPassCode, ':resetPassExpiry' => $expireDate, ':mail' => $email));
            } catch (PDOException $e) {
                fatalError("updateResetPassCode", $e->getMessage());
            }
        }
    } catch (PDOException $e) {
        fatalError("searchEmail", $e->getMessage());
    }
}
?>