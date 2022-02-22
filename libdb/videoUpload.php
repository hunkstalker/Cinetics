<?php
require_once 'connectionDB.php';

// Tabla info
function guardarVideo($videoInfo, $id) {
  $db;
  try
  {
    $db = conexionBBDD();
    $sqlinsert = "INSERT INTO `videos` (`description`, `fileName`, `iduser`)
            VALUES (:description, :fileName, :iduser)";
    $preparada = $db->prepare($sqlinsert);
    $preparada->execute(array(':description' => $videoInfo["description"], ':fileName' => $videoInfo["filename"], ':iduser' => $id));
  } catch (PDOException $e) {
    fatalError("preparada1", $e->getMessage());
  }
}

// Tabla hashtags
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
    fatalError("preparada1", $e->getMessage());
  }
}

  // Tabla videohashtags