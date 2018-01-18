<?php
  require_once "Session.php";
  $session = new Session();
  if(!$session->isLogged()){
    header("Location: index.php");
  }
?>
<?php
  $errors=array();
  //var_dump($_FILES);
  $value=null;
  if(isset($_FILES['fileData'])){
    $fileName=basename($_FILES['fileData']['name']);
    $fileType=$_FILES['fileData']['type'];
    $fileSize=$_FILES['fileData']['size'];
    $fileError=$_FILES['fileData']['error'];
    $fileTmpLoc=$_FILES['fileData']['tmp_name'];
    if(strlen($fileName)>100)$errors["largeName"]="Името е по-дълго от 100 символа.";
    if($fileSize >4194304){
      $errors["tooLarge"]="Файлът е по-голям от разрешените 4mb.";
    }
    //var_dump($errors);
    if($fileError!==0){
      $errors["errorUpload"]="Възникна грешка при качването!";
    }
    //var_dump($errors);
    if(empty($errors)){
      //var_dump($errors);
      require_once "UserClass.php";
      require_once "FileClass.php";
      $userInfo = getUserById($_SESSION['user_id']);
      $userName = $userInfo['name'];
      $userFolder = '../users/'.$userName."/";
      $shared = $_POST['shared'];
      $fileToDB = new File($fileName,$fileType,$userName,$shared,$fileSize);
      $result=array();
      $result = $fileToDB->addToDB();
      //var_dump($errors);
      if(empty($result)){
        $errors["success"]="Добавянето е успешно!";
        move_uploaded_file($fileTmpLoc,$userFolder.$fileName);
      }
      else $errors=$result;
    }

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
    <li id="mainPage"><a href="mainPage.php">Начало</a></li>
    <li id="files"><a href="#">Файлове</a>
      <ul>
        <li><a id="myFiles" href="myFiles.php">Моите файлове</a></li>
        <li><a id="addFiles" href="addFiles.php">Добави файлове</a></li>
      </ul>
    </li>
  </ul>
  <ul id="rightMenu">
    <li><p>Добре дошъл <?php echo $_SESSION['acc_name'];?> </p></li>
    <li id="settings"><img src="./imgs/settings.ico" alt="Settings"/>
      <ul>
        <li id="accountInfo"><a href="accountInfo.php">Акаунт</a></li>
        <li id="exitSite"><a href="exit.php">Изход</a></li>
      </ul>
    </li>
  </ul>
</nav>
<main>
  <form id="singeFile" name="fileUpload" method="post" enctype="multipart/form-data" target="_self">
    <label for="fileData">Моля, изберете файл:</label><br />
    <input id="iFile"type="file" name="fileData"  /><br />
    <input id="sharedFile" type="radio" name="shared" value="NO" checked /> Private
    <input id="sharedFile" type="radio" name="shared" value="YES" /> Shared<br />
    <input type="submit" value="Качи" />
    <?php if(!empty($errors))
            foreach ($errors as $key => $value)?>
    <p><?php echo $value;?></p><br />
  </form>
</main>
</body>
</html>
