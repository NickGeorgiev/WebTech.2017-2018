<?php
  require_once "Session.php";
  $session = new Session();
  if($session->isLogged()){
    header("Location: mainPage.php");
  }
?>
<?php
  require_once "UserClass.php";//was helpfunctions
  $logged=array();
  $error = null;
  $errors = array();
//check available data
  if(isset($_POST['username'])){
    $user = modifyDataFormat($_POST['username']);
    $password = modifyDataFormat($_POST['password']);
    $hashed = hash('sha256',$password);
    require_once "Database.php";
    $database = new Database('pfiles');
//user validation
    if($database){
      $statement = $database->dbConnection->prepare("SELECT id,acc_name FROM `users` where name=:name and password=:password");
      $statement->bindParam(':name',$user);
      $statement->bindParam(':password',$hashed);
      $statement->execute() or die("FAIL");
      $logged = $statement->fetch(PDO::FETCH_ASSOC);
      if($logged){
        //login successfull
        $session->configure($logged);
        header("Location: mainPage.php");
      }
      else $errors["logged"] = "Неправилно име или парола";
    }
    else $errors["database"] = "Неуспешна връзка с базата данни, опитайте по-късно.";
  }
 ?>
<html>
<head>
  <title>FileMeUp LogIn</title>
  <meta charset="utf-8" />
  <meta lang="bg" />
  <meta name="author" content="Nikola Georgiev" />
  <link rel="stylesheet" type="text/css" href="./styles/global.css" />
  <link rel="stylesheet" type="text/css" href="./styles/forms.css" />
  <link rel="stylesheet" type="text/css" href="./styles/logIn.css" />
</head>
<body class="logInBody">
    <div class="information">
      <p class="infoLabel">pFiles</p>
      <p class="infoLabel">Вход</p>
    </div>
    <div class="mainContent">
      <form class="logIn" method="post" action="" enctype="multipart/form-data" target="_self">
        <input id="user" type="text" placeholder="Username" name="username" required/><br />
        <input id="pass" type="password" placeholder="Password" name="password" required /><br />
        <input type="submit" value="Вход" />
        <?php if(isset($errors))
                  foreach($errors as $key=>$error)?>
                    <p class="prompt"><?php echo $error; ?></p><br />

      </form><br />

    </div>
    <div class="mainContent">
      <a class="redirect" href="register.php">Регистрация</a>
    </div>
</body>
</html>
