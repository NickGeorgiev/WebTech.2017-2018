<?php
  session_start();
  if(isset($_POST['name'])){
    $fName = $_POST['name'];
    $fType = $_POST['type'];
    $fShare = $_POST['share'];
    require_once "UserClass.php";
    require_once "Database.php";
    $userInfo = getUserById($_SESSION['user_id']);
    $userName = $userInfo['name'];
    $db = new Database('pfiles');
    $statement = $db->dbConnection->prepare("UPDATE `files` set shared=:shared WHERE name=:name and type=:type and owner=:owner");
    $statement->bindParam(':name',$fName);
    $statement->bindParam(':type',$fType);
    $statement->bindParam(':owner',$userName);
    $statement->bindParam(':shared',$fShare);
    if(!$statement->execute()){
      echo "FAIL";
    }
    else echo "Success";
  }
  else echo "FAIL";
 ?>
