<?php
require_once "pathFunctions.php";

// userStatus: 0 (sesión no iniciada) | 1 (sesión iniciada) | 2 (mail verificado) | 3 (email sin verificar)
function auth() {
  if (isset($_COOKIE[session_name()])) {
    session_start();
    if ($_SESSION['userStatusCode'] != 1) {
      header("Location: ../index.php");
      exit;
    }
  } else {
    header("Location: ../index.php");
    exit;
  }
}

// userStatus: 0 (sin estado) | 1 (sesión iniciada) | 2 (mail verificado) | 3 (email sin verificar)
function initialAuth() {
  if (isset($_COOKIE[session_name()])) {
    session_start();
    if ($_SESSION['userStatusCode'] == 1) {
      header("Location: ./web/mainpage.php");
      exit;
    }
  }
}