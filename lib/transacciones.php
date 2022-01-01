<?php
    function verificarUsuario($userPOST, $passPOST){
        require_once('conexionDB.php');
        try{
            $sql='SELECT * FROM `users`';
            $usuarios = $con->query($sql);
            foreach ($usuarios as $element) {
                if(strtolower($userPOST) == strtolower($element['username']) && password_verify($passPOST, $element['passHash']) && $element['active']==1){
                    $_SESSION['authorized']=TRUE;
                    $_SESSION['username']=$element['username'];
                    $_SESSION['mail']=$element['mail'];
                    session_regenerate_id();
                    break;
                }else{
                    echo 'Error en el nombre o contraseña introducidos';
                }
            }
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
        }
        $usuarios=null;
        $con=null;
    }

    function registrarUsuario($emailPOST, $userPOST, $hashPass){
        require_once('conexionDB.php');
        try{
            $con->beginTransaction();
            $sql = "INSERT INTO `users` (mail, username, passHash, userFirstName, userLastName, creationDate, active) 
                    VALUES('$emailPOST', '$userPOST', '$hashPass', 'John', 'Doe', NOW(), 1)";
            $insert = $con->query($sql);
            if($insert){
                $con->commit();
                echo 'Usuario guardado correctamente';
            }
        }catch(PDOException $e){
            echo 'Error amb la BDs: ' . $e->getMessage();
            $con->rollback();
            echo 'Transacción abortada';
        }
        $con=null;
    }
?>
