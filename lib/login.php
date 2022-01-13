<?php
    function verificaUsuari($usuari){
        $bbdd = (object)null;
        require 'conexionDB.php';
        try
        {
            $sql = 'SELECT `passHash`, `active` FROM `users` WHERE `username` = :username OR `mail` = :mail';
            $preparada = $bbdd->prepare($sql);
            $preparada->execute(array(':username' => $usuari['user'], ':mail' => $usuari['user']));

            foreach ($preparada as $element) {
                if($element['active']==1){
                    require 'update.php';
                    return password_verify($usuari['pass'], $element['passHash']);
                }
                break;
            }
        }catch(PDOException $e)
        {
            echo 'Error amb la BDs: '.$e->getMessage(); 
        }   
    }
?>