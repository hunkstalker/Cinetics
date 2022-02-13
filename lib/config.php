<?php
require_once("pathFunctions.php");

// PHPMAILER
define("SMTP_HOST","smtp.gmail.com");
define("SMTP_PORT",587);
define("ACCOUNT_USER","cineticsdenai@gmail.com");
define("ACCOUNT_PASS","educem2122");

// DATABASE CONNECTION
define("DB_STRING","mysql:dbname=cineticsdb;host=localhost:3306");
define("DB_USER","cinetics");
define("DB_PSW","cinetics");

// RUTA ARREL A PROVA DE MICOS
define("PATH",substract(createRootPath(),"htdocs/",1));
?>