<?php
require_once 'connectionDB.php';
require_once 'updateAccounts.php';

// function consultadeHashtags() {
//   $db;
//   try
//   {
//     $db        = conexionBBDD();
//     $sql       = 'SELECT `tag` FROM `hashtags`';
//     $prepare = $db->prepare($sql);
//     $prepare->execute();
//     if ($prepare && $prepare->rowCount() > 0) {
//       return $prepare->fetchAll(PDO::FETCH_COLUMN);
//     }
//   } catch (PDOException $e) {
//     fatalError("consultadeHashtagsError", $e->getMessage());
//   }
//   return false;
// }

// function consultaVideoId($filename){
//   $db;
//   try
//   {
//     $db        = conexionBBDD();
//     $sql       = 'SELECT `idvideo` FROM `videos` WHERE `filename` = :videoFilename';
//     $prepare = $db->prepare($sql);
//     $prepare->execute(array(':videoFilename' => $filename));
//     if ($prepare && $prepare->rowCount() > 0) {
//       $result = $prepare->fetch(PDO::FETCH_ASSOC);
//       return $result['idvideo'];
//     }
//   } catch (PDOException $e) {
//     fatalError("consultadeHashtagsError", $e->getMessage());
//   }
//   return false;
// }

// function consultaHashtagId($hashtags) {
  
//   $db;
//   $first = true;
//   try
//   {
//     $db      = conexionBBDD();
//     $sql     = 'SELECT `idhashtag` FROM `hashtags` WHERE `tag` = :tag';
//     $prepare = $db->prepare($sql);
//     foreach($hashtags as $tag){
//       $prepare->execute(array(':tag' => $tag));
//       $idhashtags[] = $prepare->fetch(PDO::FETCH_COLUMN);
//     }
//     return $idhashtags;
//   } catch (PDOException $e) {
//     fatalError("consultadeHashtagsError", $e->getMessage());
//   }
//   return false;
// }

function tieneVideos($iduser) {

  $db;
  $first = true;
  try
  {
    $db      = conexionBBDD();
    $sql     = 'SELECT `idvideo` FROM `videos` WHERE `iduser` = :iduser';
    $prepare = $db->prepare($sql);
    $prepare->execute(array(':iduser' => $iduser));

    if ($prepare && $prepare->rowCount() > 0) {
      $result = $prepare->fetchAll(PDO::FETCH_COLUMN);
      $_SESSION['idLastVideo'] = max($result);
      return true;
    }
  } catch (PDOException $e) {
    fatalError("consultadeHashtagsError", $e->getMessage());
  }
  return false;
}

function randomVideo(){
  rand(5, 15);

  // TODO
  // Obtener el núm máx que haya de vídeos omitiendo $_SESSION['idLastVideo']
  // Obtener el path del video resultante

}