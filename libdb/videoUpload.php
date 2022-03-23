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

function distincNewHashtags($hashtagsArray) {
  $db;
  try
  {
    $idhashtags = array();
    $db = conexionBBDD();
    $sqlselect = "SELECT `idhashtag` FROM `hashtags` WHERE `tag` = :tag";
    $preparada = $db->prepare($sqlselect);
    foreach ($hashtagsArray as $k => $v) {
      $preparada->execute(array(':tag' => $v));
      if ($preparada && $preparada->rowCount() == 0) {
        $idhashtags[] = insertHashtag($v);
      } elseif($preparada && $preparada->rowCount() > 0) {
        $result = $preparada->fetchAll(PDO::FETCH_ASSOC);
        $hashtagToAdd = $result[0];
        $idhashtags[] = $hashtagToAdd['idhashtag'];
      }    
    }
    return $idhashtags;
  } catch (PDOException $e) {
    fatalError("guardarHashtagsError", $e->getMessage());
  }
}

//TODO: function insert 1 hashtag
function insertHashtag($tagValue) {
  $db;
  try
  {
    $db = conexionBBDD();
    $sqlinsert = "INSERT INTO `hashtags` (`tag`) VALUES (:tag)";
    $preparada = $db->prepare($sqlinsert);
    $preparada->execute(array(':tag' => $tagValue));
    $hashtagId = $db->lastInsertId();
    return $hashtagId;
  } catch (PDOException $e) {
    fatalError("guardarHashtagsError", $e->getMessage());
  }
}

//TODO: si un hastag està repetit, sha de tornar la id
function guardarHashtags($hashtagsArray) {
  $hashtagsIds = distincNewHashtags($hashtagsArray);
  return $hashtagsIds;
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
