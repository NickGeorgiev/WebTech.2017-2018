<?php
  require_once "Database.php";
  $db = new Database('pfiles');
  $statement = "CREATE TABLE users(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(10),
    password VARCHAR(64),
    acc_name VARCHAR(30)
);";
  $db->dbConnection->query($statement) or die("Failed!");
 ?>
