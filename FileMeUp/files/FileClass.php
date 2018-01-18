<?php
  require_once "Database.php";
  class File{
    private $name;
    private $type;
    private $owner;
    private $shared;
    private $size;
    private $db;
    public function __construct(string $_name,string $_type,string $_owner,string $_shared,string $_size){
      $this->name = $_name;
      $this->type = $_type;
      $this->owner = $_owner;
      $this->shared = $_shared;
      $this->size = $_size;
      $this->db = new Database('logintest');
    }
    public function checkQuery():array{
      $result=array();
      $statement = $this->db->dbConnection->prepare("SELECT * FROM `files` WHERE name=:name and owner=:owner and type=:type");
      $statement->bindParam(':name',$this->name);
      $statement->bindParam(':owner',$this->owner);
      $statement->bindParam(':type',$this->type);
      $statement->execute();
      if($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $result = $row;
      }
      return $result;
    }
    public function addToDB():array{
      $errors = array();
      if(empty($this->checkQuery())){
        $statement = $this->db->dbConnection->prepare("INSERT INTO `files`(name,owner,type,shared,size) VALUES(:name,:owner,:type,:shared,:size)");
        $statement->bindParam(':name',$this->name);
        $statement->bindParam(':owner',$this->owner);
        $statement->bindParam(':type',$this->type);
        $statement->bindParam(':shared',$this->shared);
        $statement->bindParam(':size',$this->size);
        if(!$statement->execute()){
          $errors["insertError"] = "Възникна грешка при добавянето.";
        }
      }
      else $errors["alreadyExist"] = "Съществува такъв файл!";
      return $errors;
    }
    public function removeFromDB():array{
      $result = array();
      $statement = $this->db->dbConnection->prepare("DELETE FROM `files` WHERE name=:name and owner=:owner and type=:type)");
      $statement->bindParam(':name',$this->name);
      $statement->bindParam(':owner',$this->owner);
      $statement->bindParam(':type',$this->type);
      if(!$statement->execute()){
          $result["removeError"] = "Възникна грешка при премахването.";
      }
      else $result["success"] = "Премахването е успешно.";
      return $result;
    }
  }
  function getFilesForUser(string $user,string $criteria="date",string $style="ASC"){
    $results = array();
    $db = new Database('logintest');
    $statement = $db->dbConnection->prepare("SELECT * FROM `files` where owner=:owner ORDER BY :criteria :style");
    $statement->bindParam(':owner',$user);
    $statement->bindParam(':criteria',$criteria);
    $statement->bindParam(':style',$style);
    $statement->execute();
    $indx=0;
    while($row=$statement->fetch(PDO::FETCH_ASSOC)){
      $results[$indx]=$row;
      $indx++;
    }
    return $results;
  }
 ?>
