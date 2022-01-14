<?php
require_once 'logs.php';
function updateLastSignIn($usuari)
{
    try{
        $db = conexionBBDD();
        $sqlinsert = 'UPDATE `users` SET `lastSignIn` = NOW() WHERE `username` = :username OR `mail` = :mail';
        $preparada = $db->prepare($sqlinsert);
        $preparada->execute(array(':username' => $usuari['user'], ':mail' => $usuari['user']));
    }catch(PDOException $e)
    {
        fatalError("SignIn", $e->getMessage());
    }  
}
?>