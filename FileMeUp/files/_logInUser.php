<?php
  $logged=array();
  $id = null;
  if(isset($_POST['username'])){
    $user = $_POST['username'];
    $password = $_POST['password'];
    $hashed = hash('sha256',$password);
    require_once "Database.php";
    $database = new Database('logintest');
    if($database){
      $statement = $database->dbConnection->prepare("SELECT id FROM `users` where name=:name and password=:password");
      $statement->bindParam(':name',$user);
      $statement->bindParam(':password',$hashed);
      $statement->execute() or die("FAIL");
      $logged = $statement->fetch(PDO::FETCH_ASSOC);
      if($logged){
        $id = $logged['id'];
        //echo "Success";
      }
      else echo "No such user";
    }
    else echo "error connect";
  }

?>
