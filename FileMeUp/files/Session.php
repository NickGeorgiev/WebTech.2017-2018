<?php
  class Session{
    public function __construct(){
      session_start();
    }
    public function configure(array $user){
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['acc_name'] = $user['acc_name'];
    }
    public function isLogged():bool{
      return isset($_SESSION['user_id']);
    }
    public function checkSession(string $address = "index.php"){
      if(!$this->isLogged()){
        header("Location: $address");
        die();
      }
    }
    public function destroySession(){
      session_destroy();
    }
  }
 ?>
