<?php
    function verificaUsuari($usuari)
    {
        require 'conexionDB.php';
        try
        {
            $sql = 'SELECT `passHash` FROM `users` WHERE `username` = :ps';
            $preparada = $db->prepare($sql);
            $preparada->execute(array(':ps' => $usuari['user']));
            echo $preparada->rowCount();
            return password_verify($usuari['pass'], $preparada['passHash']);
        }catch(PDOException $e)
        {
            echo 'Error amb la BDs: '.$e->getMessage();
        }   
    }

    function verificarUsuario($usuari){
        require_once('conexionDB.php');
        try{
            $sql='SELECT `username`, `passHash` FROM `users`';
            $usuarios = $db->query($sql);
            return strtolower($usuari['user']) == strtolower($usuarios['username']) && password_verify($usuari['pass'], $usuarios['passHash']);
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        $usuarios=null;
        $db=null;
    }
?>