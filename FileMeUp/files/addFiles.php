<?php
  require_once "Session.php";
  $session = new Session();
  if(!$session->isLogged()){
    header("Location: index.php");
  }
?>
<!--DOCTYPE html-->
<html>
<head>
  <title>FileMeUp</title>
  <meta charset="utf-8" />
  <meta lang="bg" />
  <meta name="author" content="Nikola Georgiev" />
</head>
<body>
<header class="tempMenu">
  <h1>Добре дошъл, о велики <?php echo $_SESSION['acc_name'];?> </h1>
  <a href="mainPage.php">Начало</a>
  <a href="accountInfo.php">Акаунт</a>
  <a href="userFiles.php">Моите файлове</a>
  <a href="exit.php">Изход</a>
</header>
<main>
  <form id="singeFile" name="fileUpload" method="post" enctype="multipart/form-data" target="_self">
    <label for="fileData">Моля, изберете файл:</label>
    <input id="iFile"type="file" name="fileData" />
    <input type="submit" value="Качи" />
  </form>
</main>
</body>
</html>
