<?php
class Login{
  private $data;
  private $fields;
  private $errors;
  private $requirements;
  public function __construct(array $_data, array $_req){
    $this->data = $_data;
    $this->fields = array_keys($this->data);
    $this->requirements = $_req;
    $this->errors = array();
    $this->modifyInput();
  }
  public function modifyInput(){
    if(!empty($this->data)){
      foreach ($this->data as $key => $value) {
        $value = trim($value);
        $value = stripcslashes($value);
        $value = htmlspecialchars($value);
      }
    }
  }
  public function isValid():bool{
    if(empty($this->data)) $errors["data"] = "Няма подадени данни";
    foreach($this->fields as $elem){
      $length = strlen($this->data[$elem]);
      if(!in_array($elem,$this->requirements)) continue;
      elseif(is_numeric($this->data[$elem]) &&
       ( ( $this->data[$elem] <  $this->requirements[$elem]["min"] && !is_null($this->requirements[$elem]["min"]) ) ||
         ( $this->data[$elem] > $this->requirements[$elem]["max"] && !is_null($this->requirements[$elem]["max"]) ) ) ){
        $this->errors[$elem] = "$elem не огтоваря на изискванията";
      }
      elseif(( $length <  $this->requirements[$elem]["min"] && !is_null($this->requirements[$elem]["min"]) ) ||
             ( $length > $this->requirements[$elem]["max"] && !is_null($this->requirements[$elem]["max"]))){
        $this->errors[$elem] = "$elem не огтоваря на изискванията";
      }
    }
    return empty($this->errors);
  }
  public function showErrors(){
    if(!empty($this->errors)){
      foreach($this->errors as $error){
        echo "<p>$error</p><br/>\n";
      }
    }
    else echo "<p> Няма грешки при валидацията</p>\n";
  }
  public function showValidData(){

  }
}
 ?>
