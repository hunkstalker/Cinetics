<?php
    require_once('connecta_db_persistent.php');
    
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
?>