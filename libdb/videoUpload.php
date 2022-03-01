<?php
require_once 'connectionDB.php';
require_once '../lib/logs.php';

function guardarVideo($videoInfo, $id) {
  $db;
  try
  {
    $db = conexionBBDD();
    $sqlinsert = "INSERT INTO `videos` (`description`, `fileName`, `iduser`)
            VALUES (:description, :fileName, :iduser)";
    $preparada = $db->prepare($sqlinsert);
    $preparada->execute(array(':description' => $videoInfo["description"], ':fileName' => $videoInfo["filename"], ':iduser' => $id));
    return $db->lastInsertId();
  } catch (PDOException $e) {
    fatalError("guardarVideoError", $e->getMessage());
  }
}

function guardarHashtags($hashtagsArray) {
  $db;
  try
  {
    $db = conexionBBDD();
    $sqlinsert = "INSERT INTO `hashtags` (`tag`) VALUES (:tag)";
    $preparada = $db->prepare($sqlinsert);
    foreach ($hashtagsArray as $k => $v) {
      $preparada->execute(array(':tag' => $v));
      $idhashtags[] = $db->lastInsertId();
    }
    return $idhashtags;
  } catch (PDOException $e) {
    fatalError("guardarHashtagsError", $e->getMessage());
  }
}

function guardarVideoHashtags($idvideo, $idhashtags) {
  $db;
  try
  {
    $db = conexionBBDD();
    $sqlinsert = "INSERT INTO `videohashtags` (`idvideo`, `idhashtag`) VALUES (:idvideo, :idhashtag)";
    $prepare = $db->prepare($sqlinsert);
    foreach ($idhashtags as $k => $v) {
      $prepare->execute(array(':idvideo' => $idvideo, ':idhashtag' => $v));
    }
  } catch (PDOException $e) {
    fatalError("guardarVideoHashtagsError", $e->getMessage());
  }
}