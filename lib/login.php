<?php
    function verificaUsuari($usuari){
        require 'conexionDB.php';
        try
        {
            $sql = 'SELECT `passHash` FROM `users` WHERE `username` = :username OR `mail` = :mail';
            $preparada = $db->prepare($sql);
            $preparada->execute(array(':username' => $usuari['user'], ':mail' => $usuari['user']));
            echo $preparada->rowCount();
            foreach ($preparada as $element) {
                return password_verify($usuari['pass'], $element['passHash']);
            }
        }catch(PDOException $e)
        {
            echo 'Error amb la BDs: '.$e->getMessage();
        }   
    }
?>