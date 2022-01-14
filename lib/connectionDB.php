<?php
require_once 'logs.php';
function conexionBBDD()
{
    // Credenciales totalmente seguras y originales
    $conexion = 'mysql:dbname=cineticsdb;host=localhost:3306';
    $usuario = 'cinetics';
    $passwd = 'cinetics';
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