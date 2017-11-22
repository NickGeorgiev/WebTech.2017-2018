<?php
  $database = new PDO("mysql:host=localhost;dbname=electives","root","");
  $altQuery = "ALTER TABLE `electives` ADD created_at TIMESTAMP";
  $database->query($altQuery);
  $database = null;
 ?>
