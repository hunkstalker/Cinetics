<?php
    function verificaUsuari($usuari){
        $bbdd = (object)null;
        require 'conexionDB.php';
        try
        {
            $sql = 'SELECT `passHash` FROM `users` WHERE `username` = :username OR `mail` = :mail';
            $preparada = $bbdd->prepare($sql);
            $preparada->execute(array(':username' => $usuari['user'], ':mail' => $usuari['user']));

            foreach ($preparada as $element) {
                return password_verify($usuari['pass'], $element['passHash']);
            }
            
        }catch(PDOException $e)
        {
            echo 'Error amb la BDs: '.$e->getMessage();
        }   
    }
?>