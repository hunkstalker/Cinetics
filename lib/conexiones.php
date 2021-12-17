<?php
    function conexionBBDD(){       
        $cadena_connexio = 'mysql:dbname=cineticsdb;host=localhost:3306';
        $usuari = 'cinetics';
        $passwd = 'cinetics';
        try{
            // Creamos la conexión a BBDD
            $dbCinetics = new PDO($cadena_connexio, $usuari, $passwd, 
                            array(PDO::ATTR_PERSISTENT => true));
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        return $dbCinetics;
    }   

    function verificarUsuario($userPOST, $passPOST){
        $dbCinetics=conexionBBDD();
        try{
            $sql = 'SELECT * FROM `users`';
            $usuaris = $dbCinetics->query($sql);
            foreach ($usuaris as $element) {
                if($userPOST==$element['username'] && password_verify($passPOST, $element['passHash'])){
                    echo 'login OK';
                    break;
                }
            }
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
    }

    function transaction($emailPOST, $userPOST, $hashPass){
        $dbCinetics=conexionBBDD();
        try{
            $dbCinetics->beginTransaction();
            $sql = "INSERT INTO `users` (mail, username, passHash, userFirstName, userLastName, creationDate, active) 
                    VALUES('$emailPOST', '$userPOST', '$hashPass', 'John', 'Doe', NOW(), 1)";
            $insert = $dbCinetics->query($sql);
            if($insert){
                $dbCinetics->commit();
                echo 'Usuario guardado correctamente';
            }
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
            $dbCinetics->rollback();
            echo 'Transacción abortada';
        }
    }
?>
