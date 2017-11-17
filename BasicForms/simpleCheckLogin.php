<!DOCTYPE html>
<html>
<header>
  <title>Validating Form</title>
  <style>
  ul{
    margin: 0;
    padding: 0;
    list-style-type:none;
  }
</style>
</header>
<body>
<?php
$errors = array();
$groupName = [ "М","ПМ","ОКН","ЯКН"];
if(strlen($_POST['courseName']) > 150 ){
  $errors['courseName'] = "<p> Името на курса е по-дълго от 15 символа. </p><br />\n";
}
if(strlen($_POST['lecturer'])>200){
  $errors['lecturer'] = "<p> Името на преподавателя е по-дълго от 200 символа. </p><br />\n";
}
if(strlen($_POST['courseInfo'])<10){
  $errors['courseInfo'] = "<p> Описанието на курса е по-малко от 10 символа. </p><br />\n";
}
if($_POST['credits'] < 0){
  $errors['credits'] = "<p> Броят кредити не е положително число.  </p><br />\n";
}
if(!empty($errors)){
  echo "<p>Следните невалидни данни са въведени:</p>\n";
  foreach ($errors as $key => $value) {
    echo $value;
  }
}
else{
  echo "<p> Данните са коректни! </p><br />\n";
  echo  "<ul>\n".
          "<li>Предмет:".$_POST['courseName']."</li>\n".
          "<li>Преподавател:".$_POST['lecturer']."</li>\n".
          "<li>Описание на предмета:".$_POST['courseInfo']."</li>\n".
          "<li>Група:".$groupName[$_POST['courseGroup']-1]."</li>\n".
          "<li>Кредити:".$_POST['credits']."</li>\n".
         "</ul>";
}
 ?>
 </body>
</html>
