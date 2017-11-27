<?php
  require_once("validateForm.php");

  $database = new PDO("mysql:host=localhost;dbname=electives","root","");
  $addQuery = $database->prepare("UPDATE electives  SET title=:title, description=:description, lecturer=:lect where title=:title");
  $addQuery->bindParam(':title',$title);
  $addQuery->bindParam(':description',$description);
  $addQuery->bindParam(':lect',$lecturer);
  $input = new ValidateForm($_POST);
  if($input->validate()){
    $data = $input->returnData();
    $title = $data['title'];
    $description = $data['description'];
    $lecturer = $data['lecturer'];
    $addQuery->execute() or die("Fail");
  }
  else $input->show_errors();
  $database = null;
 ?>
