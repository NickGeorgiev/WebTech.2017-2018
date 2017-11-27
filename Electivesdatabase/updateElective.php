<!DOCTYPE html>
<html>
<head>
  <title>Elective Course Update Form</title>
  <meta charset="utf-8" />
  <style>
    label{
      vertical-align: top;
    }
    ::placeholder{
      font-size: 15px;
    }
    input{
      font-size: 15px;
      font-style: italic;
    }
  </style>
</head>
<body>
<div>
  <?php
    $title = $_POST['title'];
    $database = new PDO("mysql:host=localhost;dbname=electives","root","");
    $existCheck = $database->prepare("SELECT * FROM electives where title = :title");
    $existCheck->bindParam(':title',$title);
    $existCheck->execute();
    if($retrievedData=$existCheck->fetch(PDO::FETCH_ASSOC)){
      echo $retrievedData['lecturer'];
      echo '<form action="updateDatabase.php" method="post" target="_self">'."\n";
      echo '<label for="title">Име на курс:</label>'."\n";
      echo '<input type="text" name="title" placeholder="име на курс" value ="'.$retrievedData['title'].'" required /><br />'."\n";
      echo '<label for="lecturer">Име на преподавател:</label>'."\n";
      echo '<input type="text" name="lecturer" placeholder="име на преподавателя" value ="'.$retrievedData['lecturer'].'" required /><br />'."\n";
      echo '<label for="description">Описание на курса:</label>'."\n";
      echo '<textarea name="description" rows="3" cols="30" placeholder="Описание" required>'.$retrievedData['description'].'</textarea><br />'."\n";
      echo '<input type="submit" value="Изпрати" />'."\n";
        echo '</form>'."\n";
      }
    else echo "<p>Няма такава изборна дисциплина!</p><br />\n";
    $database = null;
   ?>


</div>
</body>
</html>
