<?php
  require_once "Session.php";
  $session = new Session();
  if($session->isLogged()){
    $session->destroySession();
    header("Location: index.php");
  }
?>
