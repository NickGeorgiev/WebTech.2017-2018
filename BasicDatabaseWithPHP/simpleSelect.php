<?php
try{
  $test = new PDO("mysql:host=localhost;dbname=electives","root","");
  $selectQ = "SELECT * FROM `electives` ";
  $query = $test->query($selectQ) or die("FAIL!");
  while($row = $query->fetch(PDO::FETCH_ASSOC)){
    print_r($row);
  }
}
catch(Exception $e){
  echo "FAIL";
}

 ?>
