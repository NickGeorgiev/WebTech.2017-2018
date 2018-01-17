<?php
  require_once "Session.php";
  $session = new Session();
  if($session->isLogged()){
    header("Location: mainPage.php");
  }
?>
<?php
  function modifyDataFormat(string $data){
    trim($data);
    stripslashes($data);
    strip_tags($data);
    return $data;
  }
  $logged=array();
  $error = null;
  $errors = array();
  if(isset($_POST['username'])){
    $user = modifyDataFormat($_POST['username']);
/*    trim($user);
    stripslashes($user);
    strip_tags($user);*/
    $password = modifyDataFormat($_POST['password']);
/*    trim($password);
    stripslashes($password);
    strip_tags($password);*/
    $hashed = hash('sha256',$password);
    require_once "Database.php";
    $database = new Database('logintest');
    if($database){
      $statement = $database->dbConnection->prepare("SELECT id,acc_name FROM `users` where name=:name and password=:password");
      $statement->bindParam(':name',$user);
      $statement->bindParam(':password',$hashed);
      $statement->execute() or die("FAIL");
      $logged = $statement->fetch(PDO::FETCH_ASSOC);
      if($logged){
        //var_dump($logged);
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
</head>
<body>
  <header>

  </header>
  <main>
    <div>
      <form method="post" action="" enctype="multipart/form-data" target="_self">
        <input id="user" type="text" placeholder="Username" name="username" required/><br />
        <input id="pass" type="password" placeholder="password" name="password" required /><br />
        <input type="submit" value="Вход" />
        <?php if(isset($errors))
                  foreach($errors as $key=>$error)?>
                    <p><?php echo $error; ?></p><br />
      </form>
      <a href="register.php">Регистрация</a>
    </div>

  </main>
</body>
</html>
