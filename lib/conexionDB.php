<?php
    // Credenciales totalmente seguras y originales
    $conexion='mysql:dbname=cineticsdb;host=localhost:3306';
    $usuario = 'cinetics';
    $passwd = 'cinetics';
    try{
        // Conexión persistente
        $bbdd = new PDO($conexion, $usuario, $passwd,
            array(PDO::ATTR_PERSISTENT => true));
    }catch(PDOException $e){
        print "Error!: " . $e->getMessage() . "<br/>";
    }
?>