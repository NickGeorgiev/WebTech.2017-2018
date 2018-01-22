<?php
  session_start();
  if(isset($_POST['name'])){
    $fName = $_POST['name'];
    $fType = $_POST['type'];
    require_once "FileClass.php";
    require_once "UserClass.php";
    $userInfo = getUserById($_SESSION['user_id']);
    $userName = $userInfo['name'];
    $userFolder = '../users/'.$userName."/";
    $fullFilePath = $userFolder.$fName;
    $temp = "";
    $file = new File($fName,$fType,$userName,$temp,$temp);
    $result = array();
    $result = $file->removeFromDB();
    if(isset($result['success'])){
      unlink($fullFilePath);
      echo "Success";
    }
    else echo $result['removeError'];
  }
  else echo "Fail nothing";
 ?>
