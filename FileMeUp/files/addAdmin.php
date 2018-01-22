<?php
  $user = 'root';
  $pass = '';
  $dbName = 'pfiles';
  $connect = new PDO("mysql:host=localhost;dbname=$dbName",$user,$pass)or die("FAIL2222!");
  $connect->query("SET NAMES utf8") or die("MMA");
  $admin = 'nickgr';
  $adminPass = '81132';
  $adminName = 'Nick Georgiev';
  $hashedPass = hash('sha256',$adminPass);
  $statement = $connect->prepare("INSERT INTO `users` (name,password,acc_name) VALUES (:name,:password,:acc_name)");
  $statement->bindParam(':name',$admin);
  $statement->bindParam(':password',$hashedPass);
  $statement->bindParam(':acc_name',$adminName);
  $statement->execute() or die("FAIL");
?>
