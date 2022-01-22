<?php
    require_once 'connectionDB.php';
    require_once 'updates.php';
    require_once 'logs.php';
    
    function login(&$usuari){
        try
        {
            $db=conexionBBDD();
            $sql = 'SELECT `passHash`, `active`, `username` FROM `users` WHERE `username` = :username OR `mail` = :mail';
            $preparada = $db->prepare($sql);
            $preparada->execute(array(':username' => $usuari['username'], ':mail' => $usuari['username']));

            // HAY QUE TESTEAR ESTO, QUERÍA EVITAR EL USO DE FOREACH AHORA ES MÁS PRO
            if($preparada && $preparada->rowCount()>0){
                $result=$preparada->fetch(PDO::FETCH_ASSOC);
                if($result['active']==1){
                    updateLastSignIn($usuari);
                    userLogVerifySuccess($usuari);
                    $usuari['username']=$result['username'];
                    return password_verify($usuari['pass'], $result['passHash']);
                }
            }
        }catch(PDOException $e)
        {
            userLogVerifyError($usuari, $e->getMessage());
        }   
    }
?>