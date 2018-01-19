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
  <title>pFiles</title>
  <meta charset="utf-8" />
  <meta lang="bg" />
  <meta name="author" content="Nikola Georgiev" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./styles/global.css" />
</head>
<body>
<header class="siteLogo">
  <p id="siteName">pFiles</p>
</header>
<nav class="siteNavigation">
  <ul id="leftMenu">
    <li id="mainPage"><a href="mainPage.php" class="active">Начало</a></li>
    <li id="files"><a href="#">Файлове</a>
      <ul>
        <li><a id="myFiles" href="myFiles.php">Моите файлове</a></li>
        <li><a id="addFiles" href="addFiles.php">Добави файлове</a></li>
      </ul>
    </li>
  </ul>
  <ul id="rightMenu">
    <li><p>Добре дошъл, <span><?php echo $_SESSION['acc_name'];?></span> </p></li>
    <li id="settings"><img src="./imgs/settings.ico" alt="Settings"/>
      <ul>
        <li id="accountInfo"><a href="accountInfo.php">Акаунт</a></li>
        <li id="exitSite"><a href="exit.php">Изход</a></li>
      </ul>
    </li>
  </ul>
</nav>
<main>
</main>
</body>
</html>
