<?php
function modifyDataFormat(string $data){
  trim($data);
  stripslashes($data);
  strip_tags($data);
  return $data;
}
function getUserById(string $id):array{
  require_once "Database.php";
  $record=array();
  $database=new Database('pfiles');
  $exist = $database->dbConnection->prepare("SELECT * FROM `users` WHERE id=:id");
  $exist->bindParam(':id',$id);
  $exist->execute();
  $record = $exist->fetch(PDO::FETCH_ASSOC);
  return $record;
}
 ?>
