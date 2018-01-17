<?php
  class Database{
    private $dbname;
    private $user='root';
    private $pass='';
    public $dbConnection;
    public function __construct(string $database){
      $this->dbname = $database;
      $this->dbConnection = new PDO("mysql:host=localhost;dbname={$this->dbname}",$this->user,$this->pass) or die("EEEE");
      $this->dbConnection->query("SET NAMES utf8");
    }
  }
?>
