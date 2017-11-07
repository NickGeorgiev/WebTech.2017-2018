<?php
require_once("ValidateClasses.php");
$requirements = array(
  "courseName" => array(
    "min" => 0,
    "max" => 150
  ),
  "lecturer" => array(
    "min" => 0,
    "max"=>200
  ),
  "courseInfo" => array("min" =>10, "max"=>null),
  "credits" => array("min"=>0, "max"=>null)
);
$loginCheck = new Login($_POST,$requirements);
if($loginCheck->isValid()) echo "<p>Данните са коректни!</p><br>\n";
else $loginCheck->showErrors();
 ?>
