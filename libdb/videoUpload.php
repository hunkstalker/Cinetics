<?php
require_once 'connectionDB.php';
require_once '../lib/logs.php';

function guardarVideo($videoInfo, $id) {
  $db;
  try
  {
    $db = conexionBBDD();
    $sqlinsert = "INSERT INTO `videos` (`title`, `description`, `filename`, `iduser`)
            VALUES (:title, :description, :filename, :iduser)";
    $preparada = $db->prepare($sqlinsert);
    $preparada->execute(array(':title' => $videoInfo["title"],':description' => $videoInfo["description"], ':filename' => $videoInfo["filename"], ':iduser' => $id));
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
    }
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