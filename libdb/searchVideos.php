<?php
require_once 'connectionDB.php';
require_once 'updateAccounts.php';



function lastUserVideo($iduser) {
  $db;
  try {
    $db = conexionBBDD();
    $sql = 'SELECT `idvideo` FROM `videos` WHERE `iduser` = :iduser ORDER BY `publicationDate` DESC LIMIT 1';
    $prepare = $db->prepare($sql);
    $prepare->execute(array(':iduser' => $iduser));

    if ($prepare && $prepare->rowCount() > 0) {
      $result = $prepare->fetchAll(PDO::FETCH_COLUMN);
      //TODO: no parece seguro asignar un path a una cookie
      //$_SESSION['idLastVideo'] = max($result);
      return $result[0];
    }
  } catch (PDOException $e) {
    fatalError("consultadeHashtagsError", $e->getMessage());
  }
  return false;
}

function randomVideo(){
  $db;
  $randomVideoName;
  $randomVideoNum;
  $maxRandom;
  try {
    $db = conexionBBDD();
    $sql = 'SELECT count(*) FROM `videos`';
    $prepare = $db->prepare($sql);
    $prepare->execute();

    if ($prepare && $prepare->rowCount() > 0) {
      $result = $prepare->fetchAll(PDO::FETCH_COLUMN);
      $maxRandom = max($result);
      $randomVideoNum = rand(1, $maxRandom);
      return $randomVideoNum;   
    }

  } catch (PDOException $e) {
    fatalError("noHiHaVideos", $e->getMessage());
  }
  return false;

  // TODO
  // Obtener el núm máx que haya de vídeos omitiendo $_SESSION['idLastVideo']
  // Obtener el path del video resultante
  //cuando se envia el post el id del video anterior puede ser un input oculto

}

function selectVideoById($idVideo) {
  $db;
  try {
    $db = conexionBBDD();
    $sql = 'SELECT * FROM `videos` WHERE `idvideo` = :idvideo';
    $prepare = $db->prepare($sql);
    $prepare->execute(array(':idvideo' => $idVideo));

    if ($prepare && $prepare->rowCount() > 0) {
      $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
      return $result[0];
    }

  } catch (PDOException $e) {
    fatalError("videoNoTrobat", $e->getMessage());
  }
  return false;
 }

 function firstCineticsVideo() {
  $db;
  $predefined = false;
  try {
    $db = conexionBBDD();
    $sql = 'SELECT * FROM `videos`';
    $prepare = $db->prepare($sql);
    $prepare->execute();

    if ($prepare && $prepare->rowCount() > 0) {
      if($prepare->rowCount() == 1) {
        $predefined = true;
      }
      return $predefined;
    }
    
  } catch (PDOException $e) {
    fatalError("videoNoTrobat", $e->getMessage());
  }
  return false;
 }

 function getHashtags($idVideo) {
  $db;
  $hashtagCollection = [];
  try {
    $db = conexionBBDD();
    $sql = 'SELECT `idhashtag` FROM `videohashtags` WHERE `idvideo` = :idvideo';
    $prepare = $db->prepare($sql);
    $prepare->execute(array(':idvideo' => $idVideo));

    if ($prepare && $prepare->rowCount() > 0) {
      $result = $prepare->fetchAll(PDO::FETCH_COLUMN);
      // foreach($row as $result) {
      //   $hashtagCollection = $row['idhashtag'];
      // }
      for($i=0;$i<count($result);$i++) {

        try {
          $db = conexionBBDD();
          $sql = 'SELECT `tag` FROM `hashtags` WHERE `idhashtag` = :idhashtag ';
          $prepare = $db->prepare($sql);
          $prepare->execute(array(':idhashtag' => $result[$i]));
      
          if ($prepare && $prepare->rowCount() > 0) {
            $resultTag = $prepare->fetchAll(PDO::FETCH_COLUMN);
            array_push($hashtagCollection, $resultTag[0]);
          }

        } catch (PDOException $e) {
          fatalError("videoNoTrobat", $e->getMessage());
        }
        
      }
      $hashtagString = "#" . implode("#",$hashtagCollection);
      return $hashtagString;
    }
    
  } catch (PDOException $e) {
    fatalError("videoNoTrobat", $e->getMessage());
  }
  return false;
 }