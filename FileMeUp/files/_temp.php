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
