<?php

require "./connecta_db_persistent.php";

function nouUsuari($usuari)
{
    try
    {
        $mail = $usuari['mail'];
        $username = $usuari['username'];
        $hash = password_hash($usuari['pss'], PASSWORD_BCRYPT);
        $fname = $usuari['fname'];
        $sname = $usuari['sname'];


        $sql = 'SELECT mail FROM `users` WHERE `mail` = :mail';
        $preparada1 = $db->prepare($sql);
        $preparada1->execute(array(':mail'=>$mail));

        if(!$preparada1)
        {
            $sql = 'SELECT username FROM `users` WHERE `username` = :username';
            $preparada2 = $db->prepare($sql);
            $preparada2->execute(array(':username'=>$username));

            if(!$preparada2)
            {
                $sqlinsert = "INSERT INTO `users` (`mail`,`username`,`passHash`,`userFirstName`,`userLastName`)
                    VALUES(:mail,:username,:pass,:fname,:sname)";
                $preparada3 = $db->prepare($sqlinsert);
                $preparada3->execute(array(':mail'=>$mail,':username'=>$username,':pass'=>$hash,
                                      ':fname'=>$fname,':sname'=>$sname));
                return TRUE;
            }
            else
            {
                echo 'Error amb usuari o email';
                return 2;
            }
        }
        else
        {
            echo 'Error amb usuari o email';
            return 1;
        }  

    }catch(PDOException $e)
    {
        echo 'Error amb la BDs: '.$e->getMessage();
    }   
}
