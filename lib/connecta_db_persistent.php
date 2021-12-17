<?php
    $cadena_connexio = 'mysql:dbname=cineticsdb;host=localhost:3306';
    $usuari = 'cinetics';
    $passwd = 'cinetics';
    try{
        //Creem una connexió persistent a BDs
        $db = new PDO($cadena_connexio, $usuari, $passwd, 
                        array(PDO::ATTR_PERSISTENT => true));
    }catch(PDOException $e){
        echo 'Error amb la BDs: ' . $e->getMessage();
    }