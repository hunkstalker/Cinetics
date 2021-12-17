<?php
    require_once('connecta_db_persistent.php');
    try{
        //Iniciem transacció
        $db->beginTransaction();
        $sql = "INSERT INTO `users` (mail, username, passHash, userFirstName, userLastName, creationDate, active) 
                VALUES('$emailPOST', '$userPOST', '$hashPass', 'John', 'Doe', NOW(), 1)";
        $insert = $db->query($sql);

        if(!$insert){
            echo '<p> Error: ';
            echo print_r($db->errorinfo());
            echo '</p>';
            //Anulem transacció
            $db->rollback();
            echo '<p>Transacció Anulada</p>';
        }else{
            $db->commit();
        }
        
    }catch(PDOException $e){
        echo 'Error amb la BDs: ' . $e->getMessage();
    }
?>