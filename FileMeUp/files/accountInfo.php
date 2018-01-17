<?php
  require_once "Session.php";
  $session = new Session();
  if(!$session->isLogged()){
    header("Location: index.php");
  }
?>
<?php
  require_once "UserClass.php";
  require_once "helpFunctions.php";
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
  <title>FileMeUp</title>
  <meta charset="utf-8" />
  <meta lang="bg" />
  <meta name="author" content="Nikola Georgiev" />
</head>
<body>
<header class="tempMenu">
  <h1>Добре дошъл, о велики <?php echo $_SESSION['acc_name'];?> </h1>
  <a href="accountInfo.php">Акаунт</a>
  <a href="userFiles.php">Моите файлове</a>
  <a href="exit.php">Изход</a>
</header>
<main>
<form name="editUser" target="_self" method="post" enctype="multipart/form-data">
  <input id="nickname" type="text" name="nickname" value='<?php echo $_SESSION['acc_name'];?>' ><br />
  <input id="user" type="text" name="username" value=<?php echo $userInfo['name'];?> disabled><br />
  <input id="pass" type="password" name="password"><br />
  <input type="submit" value="Промени" /><br />
  <?php $value=null;if(!empty($result))
          foreach ($result as $key => $value)?>
          <p><?php echo $value;?></p>
</form>
</main>
</body>
</html>
