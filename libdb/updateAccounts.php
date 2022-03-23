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

function updateRecovery($db, $email, $resetPassCode)
{
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

function selectTotalLikes($idvideo)
{
    $db;
    try{
        $db = conexionBBDD();
        $sqlselect = 'SELECT `likes` FROM `videos` WHERE `idvideo` = :idvideo';
        $preparada = $db->prepare($sqlselect);
        $preparada->execute(array(':idvideo' => $idvideo));

        if ($preparada->rowCount() > 0) {
            $result = $preparada->fetch(PDO::FETCH_ASSOC);
            return $result['likes'];
        }

    }catch(PDOException $e)
    {
        fatalError("Get likes", $e->getMessage());
    }
}

function selectTotalDislikes($idvideo)
{
    $db;
    try{
        $db = conexionBBDD();
        $sqlselect = 'SELECT `dislikes` FROM `videos` WHERE `idvideo` = :idvideo';
        $preparada = $db->prepare($sqlselect);
        $preparada->execute(array(':idvideo' => $idvideo));

        if ($preparada->rowCount() > 0) {
            $result = $preparada->fetch(PDO::FETCH_ASSOC);
            return $result['dislikes'];
        }

    }catch(PDOException $e)
    {
        fatalError("Get dislikes", $e->getMessage());
    }
}

function updateScore($idvideo, $reaction)
{
    $valueToIncrement;
    if($reaction) {
        $valueToIncrement = selectTotalLikes($idvideo);
        $valueToIncrement++;
        updateLikes($idvideo,$valueToIncrement);
     } elseif(!$reaction) {
        $valueToIncrement = selectTotalDislikes($idvideo);
        $valueToIncrement++;
        updateDislikes($idvideo,$valueToIncrement);
     }
}

function updateLikes($idvideo, $newValue)
{
    $db;
    try{
        $db = conexionBBDD();
        $sqlinsert = 'UPDATE `videos` SET `likes` = :newValue  WHERE `idvideo` = :idvideo';
        $preparada = $db->prepare($sqlinsert);
        $preparada->execute(array(':newValue' => $newValue,':idvideo' => $idvideo));

    }catch(PDOException $e)
    {
        fatalError("Update likes", $e->getMessage());
    }
}

function updateDislikes($idvideo, $newValue)
{
    $db;
    try{
        $db = conexionBBDD();
        $sqlinsert = 'UPDATE `videos` SET `dislikes` = :newValue  WHERE `idvideo` = :idvideo';
        $preparada = $db->prepare($sqlinsert);
        $preparada->execute(array(':newValue' => $newValue,':idvideo' => $idvideo));

    }catch(PDOException $e)
    {
        fatalError("Update dislikes", $e->getMessage());
    }
}

function sameUserReaction($reaction, $iduser, $idvideo) {
    $db;
    try{
        $db = conexionBBDD();
        $sqlselect = 'SELECT `reaction` FROM `userreactions` WHERE `idvideo` = :idvideo AND `iduser` = :iduser';
        $preparada = $db->prepare($sqlselect);
        $preparada->execute(array(':idvideo' => $idvideo, ':iduser' => $iduser));

        if ($preparada->rowCount() > 0) {
            $result = $preparada->fetch(PDO::FETCH_ASSOC);
            if($result['reaction'] == $reaction) {
                return true;
            }
            return false;
        }

    }catch(PDOException $e) {
        fatalError("Get dislikes", $e->getMessage());
    }
}

function updateUserReaction($reaction, $iduser, $idvideo)
{
$db;
    try {
        $db = conexionBBDD();
        // $sqlinsert = 'UPDATE `userreactions` SET `reaction` = :reaction  WHERE `iduser` = :iduser AND `idvideo` = :idvideo';
        $sqlinsert = 'INSERT INTO `userreactions` (`idvideo`,`iduser`,`reaction`) VALUES (:idvideo, :iduser, :reaction) ON DUPLICATE KEY UPDATE `reaction` = :reaction';
        $preparada = $db->prepare($sqlinsert);
        $preparada->execute(array(':reaction' => $reaction, ':iduser' => $iduser, ':idvideo' => $idvideo));

    } catch(PDOException $e) {
        fatalError("Update user reaction", $e->getMessage());
    }
}

function getVideoScore($idvideo) {
    $likes = 0;
    $dislikes = 0;
    $likes = selectTotalLikes($idvideo);
    $dislikes = selectTotalDislikes($idvideo);
    //TODO: no coge bien los likes y dislikes (problema de id?)
    return ($likes - $dislikes);
}