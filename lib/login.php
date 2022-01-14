<?php
    require_once 'connectionDB.php';
    require_once 'updates.php';
    require_once 'logs.php';
    
    function verificaUsuari($usuari){

        try
        {
            $db=conexionBBDD();
            $sql = 'SELECT `passHash`, `active` FROM `users` WHERE `username` = :username OR `mail` = :mail';
            $preparada = $db->prepare($sql);
            $preparada->execute(array(':username' => $usuari['user'], ':mail' => $usuari['user']));

            // HAY QUE TESTEAR ESTO, QUERÍA EVITAR EL USO DE FOREACH AHORA ES MÁS PRO
            if($preparada && $preparada->rowCount()>0){
                $result=$preparada->fetch(PDO::FETCH_ASSOC);
                if($result['active']==1){
                    updateLastSignIn($usuari);
                    userLogVerifySuccess($usuari);
                    return password_verify($usuari['pass'], $result['passHash']);
                }
            }
            
            // CÓDIGO ANTIGUO
            // foreach ($preparada as $element) {
            //     if($element['active']==1){
            //         updateLastSignIn();
            //         return password_verify($usuari['pass'], $element['passHash']);
            //     }
            //     break;
            // }

        }catch(PDOException $e)
        {
            userLogVerifyError($usuari, $e->getMessage());
        }   
    }
?>