<?php
  require_once "Session.php";
  $session = new Session();
  if($session->isLogged()){
    header("Location: mainPage.php");
  }
?>
<?php
  $errors=array();
  $error=null;
  if(isset($_POST['username'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $password2=$_POST['password2'];
    if($password !== $password2)
      $errors["password"]="Паролата не съвпада в двете полета!";
    if(strlen($username)>10)
      $errors["username"]="Името трябва да бъде до 10 символа";
    if(empty($errors)){
      require_once "UserClass.php";
      $register=new User($username,$password);
      $regErrors=$register->submitData();
      if(!empty($regErrors)){
        foreach ($regErrors as $key => $value) {
          $errors[$key]=$value;
        }
      }
      else{
        header("Location:index.php");
      }
    }
  }
?>
<html>
<head>
  <title>FileMeUp Register</title>
  <meta charset="utf-8" />
  <meta lang="bg" />
  <meta name="author" content="Nikola Georgiev" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./styles/global.css" />
  <link rel="stylesheet" type="text/css" href="./styles/forms.css" />
  <link rel="stylesheet" type="text/css" href="./styles/logIn.css" />
</head>
<body class="logInBody">
  <div class="information">
    <p class="infoLabel">pFiles</p>
    <p class="infoLabel">Регистрация</p>
  </div>
    <div class="mainContent">
      <form class="logIn" method="post" action="" enctype="multipart/form-data" target="_self">
        <input id="user" type="text" placeholder="Username" name="username" required/><br />
        <input id="pass" type="password" placeholder="Password" name="password" required /><br />
        <input id="pass2" type="password" placeholder="Repeat pass" name="password2" required /><br />
        <input type="submit"  id="reg" value="Регистрация" />
        <?php if(isset($errors))?>
        <?php foreach ($errors as $key => $error)?>
                      <p class="prompt"><?php echo $error;?></p><br />
      </form>
    </div>
    <div class="mainContent">
      <a class="redirect" href="index.php">Вход</a>
    </div>
</body>
</html>
