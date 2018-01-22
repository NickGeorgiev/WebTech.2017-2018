<?php
  require_once "Session.php";
  $session = new Session();
  if(!$session->isLogged()){
    header("Location: index.php");
  }
?>
<?php
  require_once "UserClass.php";
  $id=$_SESSION['user_id'];
  $userInfo=getUserById($id);
  $result=array();
  if(!empty($_POST)){
    $pass=$userInfo['password'];
    $nick=$_SESSION['acc_name'];
    if(!empty($_POST['nickname'])) $nick=$_POST['nickname'];
    if(!empty($_POST['password'])) $pass=hash("sha256",modifyDataFormat($_POST['password']));
    $user = new User($userInfo['name'],$pass);
    $result=$user->UpdateUserInfo($id,$nick);
    if(isset($result['success'])) $_SESSION['acc_name']=$nick;
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
  <link rel="stylesheet" type="text/css" href="./styles/forms.css" />
</head>
<body>
  <header class="siteLogo">
    <p id="siteName">pFiles</p>
  </header>
  <nav class="siteNavigation">
    <ul id="leftMenu">
      <li id="mainPage"><a href="mainPage.php">Начало</a></li>
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
          <li id="accountInfo"><a class="active" href="accountInfo.php">Акаунт</a></li>
          <li id="exitSite"><a href="exit.php">Изход</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  <div class="information">
    <p class="infoLabel">Информация за акаунта</p><br />
    <p class="infoText">Тук можете да промените името си в системата, както и паролата си!</p><br />
  </div>
  <div class="mainContent">
      <form class="accountForm" name="editUser" target="_self" method="post" enctype="multipart/form-data">
        <label class="fieldLabel" for="nickname">Име:</label><br />
        <input id="nickname" type="text" name="nickname" placeholder="Промени името" value='<?php echo $_SESSION['acc_name'];?>' ><br />
        <label class="fieldLabel" for="nickname">Потребителско име:</label><br />
        <input id="user" type="text" name="username" value=<?php echo $userInfo['name'];?> disabled><br />
        <label class="fieldLabel" for="nickname">Парола:</label><br />
        <input id="pass" type="password" name="password" placeholder="Въведи нова парола"><br />
        <input type="submit" value="Промени" /><br />
        <?php $value=null;if(!empty($result))
                foreach ($result as $key => $value)?>
                <p class="prompt"><?php echo $value;?></p>
      </form>
  </div>
</body>
</html>
