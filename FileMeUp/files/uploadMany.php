<?php
  session_start();
  $errors=array();
  $value=null;
  $uploadedFiles=array();
  if(isset($_FILES['fileData']['name'][0])){
    require_once "UserClass.php";
    require_once "FileClass.php";
    $userInfo = getUserById($_SESSION['user_id']);
    $userName = $userInfo['name'];
    $userFolder = '../users/'.$userName."/";
    $shared = 'NO';
    foreach ($_FILES['fileData']['name'] as $indx => $name) {
      $fileName=basename($_FILES['fileData']['name'][$indx]);
      $fileType=$_FILES['fileData']['type'][$indx];
      $fileSize=$_FILES['fileData']['size'][$indx];
      $fileError=$_FILES['fileData']['error'][$indx];
      $fileTmpLoc=$_FILES['fileData']['tmp_name'][$indx];
      if(strlen($fileName)>100)$errors["largeName"]="Името трябва да е не повече от 100 символа.";
      if($fileSize >4194304)$errors["tooLarge"]="Файловете трябва да не са по-големи от 4MB.";
      if($fileError!==0)$errors["errorUpload"]="Възникна грешка при качването на някой от файловете!";
      if(empty($errors)){
        $fileToDB = new File($fileName,$fileType,$userName,$shared,$fileSize);
        $result=array();
        $result = $fileToDB->addToDB();
        if(empty($result)){
          $uploadedFiles[]=array('name'=>$fileName,'status'=>'Uploaded successfully');
          move_uploaded_file($fileTmpLoc,$userFolder.$fileName);
        }
        else $uploadedFiles[]=array('name'=>$fileName,'status'=>'Already exist');
      }
      else $uploadedFiles[]=array('name'=>$fileName,'status'=>'error adding');
      }
    echo json_encode($uploadedFiles);
  }

 ?>
