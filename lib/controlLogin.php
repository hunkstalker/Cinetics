<?php
require "./connecta_db_persistent.php";

function verificaUsuari($usuari)
{
    try
    {
        $username = $usuari['nom'];

        $sql = 'SELECT passHash FROM `users` WHERE `username` = :ps';
        $preparada = $db->prepare($sql);
        $preparada->execute(array(':ps'=>$username));
        $bd_pss = $preparada['passHash'];

        return password_verify($usuari['pass'],$bd_pss);

    }catch(PDOException $e)
    {
        echo 'Error amb la BDs: '.$e->getMessage();
    }   
}