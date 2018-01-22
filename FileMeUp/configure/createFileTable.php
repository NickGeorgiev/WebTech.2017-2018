<?php
  require_once "Database.php";
  $db = new Database('pfiles');
  $statement = "CREATE TABLE files(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    owner VARCHAR(10),
    type VARCHAR(10),
    shared VARCHAR(3),
    size VARCHAR(10),
    date TIMESTAMP)";
  $db->dbConnection->query($statement) or die("Failed!");
 ?>
