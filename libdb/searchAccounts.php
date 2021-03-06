<?php
require_once 'connectionDB.php';
require_once 'updateAccounts.php';
require_once __DIR__.'\..\lib\logs.php';

// Verificación de usuario para realizar el login
function searchUser(&$usuari) {
  $db;
  try
  {
    $db = conexionBBDD();
    $sql = 'SELECT `passHash`, `active`, `username`, `iduser` FROM `users` WHERE `username` = :username OR `mail` = :mail';
    $preparada = $db->prepare($sql);
    $preparada->execute(array(':username' => $usuari['username'], ':mail' => $usuari['username']));

    if ($preparada && $preparada->rowCount() > 0) {
      $result = $preparada->fetch(PDO::FETCH_ASSOC);
      if ($result['active'] == 1) {
        updateLastSignIn($usuari);
        userLogVerifySuccess($usuari);
        $usuari['username'] = $result['username'];
        $usuari['iduser'] = $result['iduser'];
        return password_verify($usuari['pass'], $result['passHash']);
      }
    }
  } catch (PDOException $e) {
    userLogVerifyError($usuari, $e->getMessage());
  }
}

// Mira si la cuenta existe para recuperar pass
function searchUserMail($email, $resetPassCode) {
  $db;
  try {
    $db = conexionBBDD();
    $sql = 'SELECT mail FROM `users` WHERE `mail` = :mail';
    $preparada = $db->prepare($sql);
    $preparada->execute(array(':mail' => $email));
    if ($preparada->rowCount() > 0) {
      updateRecovery($db, $email, $resetPassCode);
      return true;
    }
  } catch (PDOException $e) {
    fatalError("Search Mail", $e->getMessage());
  }
  return false;
}

// Recuperar todos los datos del usuario
function getUserData($usuari) {
  $db;
  try {
    $db = conexionBBDD();
    $sql = 'SELECT * FROM `users` WHERE `mail` = :mail AND `activationCode` = :code';
    $preparada = $db->prepare($sql);
    $preparada->execute(array(':mail' => $usuari['mail'], ':code' => $usuari['activateCode']));

    if ($preparada->rowCount() > 0) {
      $result = $preparada->fetch(PDO::FETCH_ASSOC);

      if ($result['active'] == 1) {
        updateLastSignIn($result);
        emailVerificationLog($result);
        $usuari['username'] = $result['username'];
        $usuari['iduser'] = $result['iduser'];
        return $usuari;
      }
    }
  } catch (PDOException $e) {
    fatalError("Search Mail", $e->getMessage());
  }
  return false;
}

// Verifica si caduca el mail de recuperación de pass
function searchAndVerify($urlData) {
  $db;
  try {
    $db = conexionBBDD();
    // Miramos si existe la cuenta verificando el email y el resetPassCode obtenidos por GET
    // Hay que verificar si la el resetPassDate ha expirado
    //TODO: fix time
    $sql = 'SELECT mail FROM `users` WHERE `mail` = :mail AND `resetPassCode` = :resetPassCode AND `resetPassExpiry` > current_timestamp()';
    $preparada = $db->prepare($sql);
    $preparada->execute(array(':mail' => $urlData['mail'], ':resetPassCode' => $urlData['resetPassCode']));
    // Si resetPassExpiry es inferior a la fecha y hora actuales todo OK
    // En ese caso el execute nos habrá devuelto un row
    if ($preparada->rowCount() > 0) {
      return true;
    }
  } catch (PDOException $e) {
    fatalError("searchAccount", $e->getMessage());
    return false;
  }
}
