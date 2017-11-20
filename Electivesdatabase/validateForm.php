<?php
  class ValidateForm{
    private $data;
    private $errors;
    private function modifyInput(){
      if(!empty($this->data)){
        foreach ($this->data as $key => $value) {
          $value = trim($value);
          $value = stripcslashes($value);
          $value = htmlspecialchars($value);
        }
      }
    }
    public function __construct(array $_data){
      $this->data = $_data;
      $this->modifyInput();
    }
    public function validate():bool{
      if(strlen($this->data['title']) > 128){
        $error['title']="<p>Заглавието е по-дълго от 128 символа!</p><br />\n";
      }
      if(strlen($this->data['description'] > 1024)){
        $error['description']="<p>Описанието е по-дълго от 1024 символа!</p><br />\n";
      }
      if(strlen($this->data['lecturer']) > 128){
        $error['lecturer']="<p>Името на преподавателя е по-дълго от 128 символа!</p><br />\n";
      }
      return empty($this->errors);
    }
    public function show_errors(){
      if(!empty($this->errors)){
        foreach($this->errors as $key=>$value){
          echo $value;
        }
      }
    }
    public function returnData():array{
      return $this->data;
    }
  }
 ?>
