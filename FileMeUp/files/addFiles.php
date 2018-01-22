<?php
  require_once "Session.php";
  $session = new Session();
  if(!$session->isLogged()){
    header("Location: index.php");
  }
?>
<?php
  $errors=array();
  $value=null;
  if(isset($_FILES['fileData']['name'][0])){
    require_once "UserClass.php";
    $userInfo = getUserById($_SESSION['user_id']);
    $userName = $userInfo['name'];
    $userFolder = '../users/'.$userName."/";
    $shared = $_POST['shared'];
    foreach ($_FILES['fileData']['name'] as $indx => $name) {
      $fileName=$_FILES['fileData']['name'][$indx];
      $fileNameDB=pathinfo($_FILES['fileData']['name'][$indx], PATHINFO_FILENAME).".".pathinfo($_FILES['fileData']['name'][$indx],PATHINFO_EXTENSION);
      $fileType=$_FILES['fileData']['type'][$indx];
      $fileSize=$_FILES['fileData']['size'][$indx];
      $fileError=$_FILES['fileData']['error'][$indx];
      $fileTmpLoc=$_FILES['fileData']['tmp_name'][$indx];
      if(strlen($fileName)>100)$errors["largeName"]="Името трябва да е не повече от 100 символа.";
      if($fileSize >4194304)$errors["tooLarge"]="Файловете трябва да не са по-големи от 4MB.";
      if($fileError!==0)$errors["errorUpload"]="Възникна грешка при качването на някой от файловете!";
      if(empty($errors)){
        require_once "FileClass.php";
        $fileToDB = new File($fileNameDB,$fileType,$userName,$shared,$fileSize);
        $result=array();
        $result = $fileToDB->addToDB();
        if(empty($result)){
          //$errors["success"]="Добавянето е успешно!";
          move_uploaded_file($fileTmpLoc,$userFolder.$fileName);
        }
      }
    }
    if(empty($errors)){
      if(empty($result)){
        $errors["success"]="Добавянето е успешно!";
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
        <li><a class="active" id="addFiles" href="addFiles.php">Добави файлове</a></li>
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
<div class="information">
  <p class="infoLabel">Добавяне на файлове</p>
  <p class="infoText">Добави по един файл:</p>
</div>
<div class="mainContent">
  <form class="addForm" id="singeFile" name="fileUpload" method="post" enctype="multipart/form-data" target="_self">
    <label id="iFileLabel" class="fileLabel" for="iFile"><img src="./imgs/upload.png" alt="upload" /> <p>Избери</p></label>
    <input id="iFile" type="file" name="fileData[]" />
    <label id="nSharedLabel" class="radioOption">Private
      <input id="sharedFile" type="radio" name="shared" value="NO" checked />
    </label>
    <label id="ySharedLabel"class="radioOption">Shared
      <input id="sharedFile" type="radio" name="shared" value="YES" / />
    </label>
    <input type="submit" value="Качи" />
    <?php if(!empty($errors))
            foreach ($errors as $key => $value)?>
    <p class="prompt"><?php echo $value;?></p><br />
  </form>
</div>
<div class="information"><p class="infoText">Или няколко наведнъж:</p></div>
<div class="mainContent">
  <div class="dropFiles" id="dropZone">
    Drop Files here
  </div>
</div>
</body>
<script type="text/javascript">
  (function(){
    //script for drag&drop menu
    var dropTarget = document.getElementById('dropZone');
    var showResult = function(data){
        dropTarget.className='dropFiles dropOrd';
        dropTarget.innerHTML="";
        var indx;
        for(indx=0;indx<data.length;indx++){
            var pgraph = document.createElement('p');
            pgraph.style='color:#A22133';
            console.log(data[indx].name);
            pgraph.innerHTML=data[indx].name+" "+data[indx].status;
            dropTarget.appendChild(pgraph);
        }
    };
    var uploadFiles=function(files){
        var form = new FormData();
        var xhrReq = new XMLHttpRequest();
        var indx;
        for(indx=0;indx<files.length;indx++){
            form.append('fileData[]',files[indx]);
        }


        xhrReq.open('post','uploadMany.php');
        xhrReq.send(form);
        xhrReq.onload = function(){
            var response = JSON.parse(this.responseText);
            showResult(response);
        }

    };
    dropTarget.ondrop=function(e){
      e.preventDefault();
      this.className='dropFiles';
      uploadFiles(e.dataTransfer.files);
    };
    dropTarget.ondragover=function(){
        this.className='dropFiles dragOver';
        return false;
    };
    dropTarget.ondragleave=function(){
      this.className='dropFiles';
      return false;
    };
    //script for singeFile form
    var singleForm = document.getElementById('iFile');
    var fileLabel = document.getElementById('iFileLabel');
    singleForm.onchange=function(){
        //console.log(fileLabel.getElementsByTagName('p')[0].innerText);
        fileLabel.getElementsByTagName('p')[0].innerText=singleForm.files[0].name;
    }
  }());
</script>
</html>
