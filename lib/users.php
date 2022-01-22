<?php
require_once 'connectionDB.php';
require_once 'phpmailer.php';
require_once 'logs.php';

function registroUsuario($usuari, &$emailDuplicat, &$usuariDuplicat)
{
    $emailDuplicat = true;
    $usuariDuplicat = true;
    try
    {
        $mail = $usuari['email'];
        $username = $usuari['username'];
        $hash = password_hash($usuari['pss'], PASSWORD_BCRYPT);
        $fname = $usuari['fname'];
        $sname = $usuari['sname'];

        $db = conexionBBDD();

        $sql = 'SELECT mail FROM `users` WHERE `mail` = :mail';
        try {
            $preparada1 = $db->prepare($sql);
            $preparada1->execute(array(':mail' => $mail));
        } catch (PDOException $e) {
            fatalError("preparada1", $e->getMessage());
        }

        $sql = 'SELECT username FROM `users` WHERE `username` = :username';
        try {
            $preparada2 = $db->prepare($sql);
            $preparada2->execute(array(':username' => $username));
        } catch (PDOException $e) {
            fatalError("preparada2", $e->getMessage());
        }

        if ($preparada1->rowCount() == 0) {
            $emailDuplicat = false;
        }

        if ($preparada2->rowCount() == 0) {
            $usuariDuplicat = false;
        }

        if ($emailDuplicat === false && $usuariDuplicat === false) {

            $activationCode="";
            // Todo es correcto, así que podemos guardar todos los datos en la bbdd
            $urlActivationCode = createGetValues($mail, $activationCode);
            // Nos guardamos el mail y el TOKEN del usuario en su sesión para no tener que consultar de nuevo en bbdd a la hora de verificar la cuenta
            session_start();
            $_SESSION['username']=$username;
            $_SESSION['mail']=$mail;
            $_SESSION['userStatusCode']=3;

            // Registramos el usuario, se registará como inactivo y guardamos el TOKEN en bbdd
            $sqlinsert = "INSERT INTO `users` (`mail`,`username`,`passHash`,`userFirstName`,`userLastName`,`activationCode`)
                    VALUES(:mail, :username, :pass, :fname, :sname, :activationCode)";
            $preparada3 = $db->prepare($sqlinsert);
            $preparada3->execute(array(':mail' => $mail, ':username' => $username, ':pass' => $hash,
                ':fname' => $fname, ':sname' => $sname, ':activationCode' => $activationCode));
            
            // Mandamos el mail con el TOKEN para que el usuario haga la verificación
            sendEmailNewUser($mail, $urlActivationCode);
            return true;
        }
        return false;

    } catch (PDOException $e) {
        userRegisterError($usuari, $e->getMessage());
    }
}

function searchEmail($email, $resetPassCode)
{
    try {
        $db = conexionBBDD();
        // Miramos si existe la cuenta
        $sql = 'SELECT mail FROM `users` WHERE `mail` = :mail';
        $preparada1 = $db->prepare($sql);
        $preparada1->execute(array(':mail' => $email));
        if ($preparada1->rowCount()>0) {
            try {
                // Si existe guardaremos el token del reset para el pass
                $sqlinsert = 'UPDATE `users` SET `resetPassCode` = :resetPassCode, `resetPassExpiry` = (NOW() + interval 1 hour) WHERE `mail` = :mail';
                $preparada = $db->prepare($sqlinsert);
                $preparada->execute(array(':resetPassCode' => $resetPassCode, ':mail' => $email));
            } catch (PDOException $e) {
                fatalError("preparada1", $e->getMessage());
            }
        }
    } catch (PDOException $e) {
        fatalError("preparada1", $e->getMessage());
    }
}

// PENDIENTE VERIFICAR EMAIL Y RESETPASSCODE
function searchAccount($usuari){
    try {
        $db = conexionBBDD();
        // Miramos si existe la cuenta
        $sql = 'SELECT resetPassExpiry FROM `users` WHERE `mail` = :mail AND `resetPassCode` = :resetPassCode';
        $preparada = $db->prepare($sql);
        $preparada->execute(array(':mail' => $usuari['email'], ':resetPassCode' => $usuari['resetPassCode']));
        $result=$preparada->fetch(PDO::FETCH_ASSOC);
        if($result['resetPassExpiry']==1){
            updateLastSignIn($usuari);
            userLogVerifySuccess($usuari);
            $usuari['username']=$result['username'];
            return password_verify($usuari['pass'], $result['passHash']);
        }
    } catch (PDOException $e) {
        fatalError("preparada1", $e->getMessage());
    }
}
?>