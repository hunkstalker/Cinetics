<?php
function userLogVerifySuccess($usuari){
    $data = strftime("%a %b %d %Y %H:%M").": ".$usuari['user']." :: Verify/Connection SUCCESS";
    $file = fopen("./logs/users.log","a");
    fwrite($file,$data.PHP_EOL);
    fclose($file);
}

function userLogVerifyError($usuari, $ex){
    $data = strftime("%a %b %d %Y %H:%M").": ".$usuari['user']." :: Verify/Connection FAIL\nERROR MESSAGE :: ".$ex;
    $file = fopen("./logs/users.log","a");
    fwrite($file,$data.PHP_EOL);
    fclose($file);
}

function userRegisterError($usuari, $ex){
    $data = strftime("%a %b %d %Y %H:%M").": ".$usuari['username']."/".$usuari['email']." :: Register FAIL\nERROR MESSAGE :: ".$ex;
    $file = fopen("./logs/users.log","a");
    fwrite($file,$data.PHP_EOL);
    fclose($file);
}

function fatalError($err, $ex){
    $data = strftime("%a %b %d %Y %H:%M") . " :: " . $err . " FAIL\nERROR MESSAGE :: ".$ex;
    $file = fopen("./logs/php.log","a");
    fwrite($file,$data.PHP_EOL);
    fclose($file);
}
?>