<?php
  require_once("validateForm.php");

  $database = new PDO("mysql:host=localhost;dbname=electives","root","");
  $existCheck = $database->prepare("SELECT * FROM electives where title = ?");
  $addQuery = $database->prepare("INSERT INTO electives (title,description,lecturer) VALUES (:title,:description,:lect)");
  $addQuery->bindParam(':title',$title);
  $addQuery->bindParam(':description',$description);
  $addQuery->bindParam(':lect',$lecturer);
  $input = new ValidateForm($_POST);
  if($input->validate()){
    $data = $input->returnData();
    $title = $data['title'];
    $description = $data['description'];
    $lecturer = $data['lecturer'];
    $existCheck->execute(array($title));
    if(!$existCheck->fetch()){
      $addQuery->execute() or die("Fail");
    }
  }
  else $input->show_errors();
  $database = null;
 ?>
