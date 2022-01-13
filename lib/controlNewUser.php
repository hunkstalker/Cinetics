<?php

function nouUsuari($usuari, &$emailDuplicat, &$usuariDuplicat)
{
    $bbdd = (object)null;
    $emailDuplicat=TRUE;
    $usuariDuplicat=TRUE;

    require "conexionDB.php";
    try
    {
        $mail = $usuari['email'];
        $username = $usuari['username'];
        $hash = password_hash($usuari['pss'], PASSWORD_BCRYPT);
        $fname = $usuari['fname'];
        $sname = $usuari['sname'];

        $sql = 'SELECT mail FROM `users` WHERE `mail` = :mail';
        $preparada1 = $bbdd->prepare($sql);
        $preparada1->execute(array(':mail'=>$mail));

        $sql = 'SELECT username FROM `users` WHERE `username` = :username';
        $preparada2 = $bbdd->prepare($sql);
        $preparada2->execute(array(':username'=>$username));

        if($preparada1->rowCount()==0){
            $emailDuplicat=FALSE;
        } 

        if($preparada2->rowCount()==0){
            $usuariDuplicat=FALSE;
        }
        
        if($emailDuplicat===FALSE && $usuariDuplicat===FALSE)
        {
            $sqlinsert = "INSERT INTO `users` (`mail`,`username`,`passHash`,`userFirstName`,`userLastName`)
                VALUES(:mail, :username, :pass, :fname, :sname)";
            $preparada3 = $bbdd->prepare($sqlinsert);
            $preparada3->execute(array(':mail'=>$mail,':username'=>$username,':pass'=>$hash,
                                    ':fname'=>$fname,':sname'=>$sname));
            return TRUE;
        }
        return FALSE;

    }catch(PDOException $e)
    {
        echo 'Error amb la BDs: '.$e->getMessage();
    }   
}
