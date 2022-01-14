<?php
require_once "connectionDB.php";
require_once 'logs.php';

function nouUsuari($usuari, &$emailDuplicat, &$usuariDuplicat)
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
            $sqlinsert = "INSERT INTO `users` (`mail`,`username`,`passHash`,`userFirstName`,`userLastName`)
                    VALUES(:mail, :username, :pass, :fname, :sname)";
            $preparada3 = $db->prepare($sqlinsert);
            $preparada3->execute(array(':mail' => $mail, ':username' => $username, ':pass' => $hash,
                ':fname' => $fname, ':sname' => $sname));
            return true;
        }
        return false;

    } catch (PDOException $e) {
        userRegisterError($usuari, $e->getMessage());
    }
}
?>