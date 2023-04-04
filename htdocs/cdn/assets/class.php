<?php

class HimaDB {
  public $path = "data/";
  public $responsed = false;
  function __construct($dbPath=""){
    if (con($dbPath, "../") || $dbPath[0]=="/") {
      echo $this->response("500", "invalid $dbPath, mustn't start with \"/\" or contains \"../\"");
      $this->responsed = true;
    } else {
      $this->path = $this->path . $dbPath;
      if (!is_dir($this->path)) {mkdir($this->path);}
    }
  }
  private function response($status, $result) {
    $string = [
      "status" => $status,
      "result" => $result,
    ];
    $string = json_encode($string, 128);
    return str_replace("  ", " ", $string);
  }
  private function randStr($length = 10) {
    $characters = '0123456789abcdefABCDEF';
    $randstring = '';
    for ($i = 0; $i < $length; $i++) {
      $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
  }
  public function setItem($key, $value) {
    $content = json_encode(["content" => $value], 128);
    file_put_contents("$this->path/$key.json", $content);
    echo $this->response("200", $key);
  }
  
  public function getItem($key) {
    if(file_exists("$this->path/$key.json")){
      $item = json_decode(file_get_contents("$this->path/$key.json"));
      echo $this->response("200", $item->content);
    } else{
      echo $this->response("404", "$key not exist");
    }
  }
  
}