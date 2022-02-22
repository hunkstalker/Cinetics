<?php
function substract($string, $chr, $pos, $len = NULL) {
  return implode($chr, array_slice(explode($chr, $string), $pos, $len));
}

function createRootPath() {
  $path     = dirname(__FILE__, 2);
  $badChar  = "\\";
  $rootPath = str_replace($badChar, '/', $path);
  return $rootPath;
}

function createFilePath($userNametmpName) {
  $pathexplode  = explode("\\tmp", $userNametmpName);
  $badChar      = "\\";
  $pathreplaced = str_replace($badChar, '/', $pathexplode);
  return $pathreplaced[0] . "/videoUploads";
}
?>