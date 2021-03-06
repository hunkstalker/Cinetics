<?php
require_once (__DIR__.'\..\lib\logs.php');
require_once (__DIR__.'\..\lib\config.php');

function conexionBBDD()
{
    $db;
    // Credenciales totalmente seguras y originales
    $conexion = DB_STRING;
    $usuario = DB_USER;
    $passwd = DB_PSW;
    try {
        // Conexión persistente
        $db = new PDO($conexion, $usuario, $passwd,
            array(PDO::ATTR_PERSISTENT => true));
    } catch (PDOException $e) {
        fatalError("DBConnection", $e->getMessage());
    }
    return $db;
}
?>