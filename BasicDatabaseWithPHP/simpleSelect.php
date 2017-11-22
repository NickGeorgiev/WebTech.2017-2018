<?php
try{
  $test = new PDO("mysql:host=localhost;dbname=electives","root","");
  $selectQ = "SELECT * FROM `electives` ";
  $query = $test->query($selectQ) or die("FAIL!");
  while($row = $query->fetch(PDO::FETCH_ASSOC)){
    echo $row['title']."<br />";
  }
}
catch(Exception $e){
  echo "FAIL";
}

 ?>
