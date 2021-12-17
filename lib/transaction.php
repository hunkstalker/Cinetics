<?php
    require_once('connecta_db_persistent.php');

    function transaction($emailPOST, $userPOST, $hashPass){
        $dbCinetics=conexionBBDD();
        try{
            // Iniciamos transacción
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