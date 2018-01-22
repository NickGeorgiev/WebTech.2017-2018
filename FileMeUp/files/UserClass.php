<?php
  require_once "Database.php";
  function modifyDataFormat(string $data){
    trim($data);
    stripslashes($data);
    strip_tags($data);
    return $data;
  }
  class User{
    private $username;
    private $password;
    private $database;
    public function __construct(string $user,string $pass){
      $this->username=$user;
      $this->password=$pass;
      $this->database=new Database('pfiles');
    }
    public function getUserInfo():array{
      $record=array();
      $exist = $this->database->dbConnection->prepare("SELECT * FROM `users` WHERE name=:user");
      $exist->bindParam(':user',$this->username);
      $exist->execute();
      if($row = $exist->fetch(PDO::FETCH_ASSOC))  $record=$row;
      return $record;
    }
    public function submitData():array{
      $errors=array();
      $record=$this->getUserInfo();
      if(!empty($record)) $errors["hasUser"]="Съществува потребител с това име!";
      if(empty($errors)){
        $hashedPass=hash("sha256",$this->password);
        $statement=$this->database->dbConnection->prepare("INSERT INTO `users`(name,password,acc_name) VALUES(:user,:pass,:account)");
        $statement->bindParam(':user',$this->username);
        $statement->bindParam(':pass',$hashedPass);
        $statement->bindParam(':account',$this->username);
        if(!$statement->execute()){
          $errors["addFail"]="Грешка при добавянето!";
        }
      }
      if(empty($errors)){
        $path="../users/".$this->username;
        mkdir($path);

      }
      return $errors;
    }
    public function UpdateUserInfo(string $id,string $newName):array{
      $result=array();
      $nickname = modifyDataFormat($newName);
      $statement = $this->database->dbConnection->prepare("UPDATE `users` SET acc_name=:nick , password=:password WHERE id=:id");
      $statement->bindParam(':nick',$nickname);
      $statement->bindParam(':password',$this->password);
      $statement->bindParam(':id',$id);
      if($statement->execute()) $result["success"] = "Промяната е успешна.";
      else $result["error"]="Възникна грешка при промяната.";
      return $result;
    }
}
function getUserById(string $id):array{
  $record=array();
  $database=new Database('pfiles');
  $exist = $database->dbConnection->prepare("SELECT * FROM `users` WHERE id=:id");
  $exist->bindParam(':id',$id);
  $exist->execute();
  $record = $exist->fetch(PDO::FETCH_ASSOC);
  return $record;
}
?>
