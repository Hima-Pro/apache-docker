<?php
/**
 * HimaDB
 * NoSQL needed PHP Class to store and retrieve data/objects only with pure PHP Language.
 *
 * @package Hima-Pro/HimaDB
 * @author  Ibrahim Megahed [@tdim.dev] <tdim.dev@gmail.com>
 * @link    https://github.com/Hima-Pro/HimaDB
 * @version 1.0
 */
 
class HimaDB {
  /**
    * The main constructor
    * @make folder
  **/
  public $gName;
  public $safe = true;
  function __construct($dbName="data") {
    if(strpos($dbName, "../") !== false || $dbName[0]=="/"){
      $this->safe = false;
    } else{
      $this->gName = $dbName;
      if (!is_dir("data")) {
        mkdir("data");
      }
      if (!is_dir("data/" . $dbName) && $dbName != "data") {
        mkdir("data/" . $dbName);
      }
    }
  }
  
  /**
    * Make bad auth response
    * @return object
  **/
  private function er500(){
    return $this->response("500", "bad auth");
  }
  
  /**
    * Make response template
    * @return object
  **/
  private function response($status, $result) {
    $string = [
      "status" => $status,
      "result" => $result,
    ];
    $string = json_encode($string, 128);
    return str_replace("  ", " ", $string);
  }
  
  /**
    * Make random string made of 0123456789abcdefABCDEF
    * @return string
  **/
  private function RandomString($lnth = 10) {
    $characters = '0123456789abcdefABCDEF';
    $randstring = '';
    for ($i = 0; $i < $lnth; $i++) {
      $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
  }
  
  /**
    * Convert file name to only name, ex: abcdef.json => abcdef
    * @return string
  **/
  private function fileToKey($file) {
    return explode(".", $file)[0];
  }
  
  /**
    * Retrieve data from a DB Folder by name
    * @print object response
  **/
  public function get($key) {
    if($this->safe==false){echo $this->er500();exit();}
    if(file_exists("data/$this->gName/$key.json")){
      $content = json_decode(file_get_contents("data/$this->gName/$key.json"));
      echo $this->response("200", $content->content);
    } else{
      echo $this->response("404", "$key not exist");
    }
  }
  
  /**
    * Retrieve all data keys
    * @print object response 
  **/
  public function getAll() {
    if($this->safe==false){echo $this->er500();exit();}
    $files = scandir("data/$this->gName");
    $keys = [];
    foreach ($files as $file) {
      array_push($keys, $this->fileToKey($file));
    }
    echo $this->response("200", $keys);
  }
  
  /**
    * Store data in a DB Folder
    * @print object response
  **/
  public function create($value) {
    if($this->safe==false){echo $this->er500();exit();}
    $key = $this->RandomString();
    if(!file_exists("data/$this->gName/$key.json")){
      $content = json_encode(["content" => $value], 128);
      file_put_contents("data/$this->gName/$key.json", $content);
      echo $this->response("200", $key);
    } else{
      echo $this->response("500", "try again");
    }
  }
  
  /**
    * Update stored data in a DB Folder
    * @print object response
  **/
  public function update($key, $value) {
    if($this->safe==false){echo $this->er500();exit();}
    $content = json_encode(["content" => $value], 128);
    file_put_contents("data/$this->gName/$key.json", $content);
    echo $this->response("200", $key);
  }
  
  /**
    * Delete stored data from a DB Folder
    * @print object response
  **/
  public function delete($key) {
    if($this->safe==false){echo $this->er500();exit();}
    if(file_exists("data/$this->gName/$key.json")){
      unlink("data/$this->gName/$key.json");
      echo $this->response("200", "success");
    } else{
      echo $this->response("404", "$key not exist");
    }
  }
  
  /**
    * Delete a DB Folder
    * @return object
  **/
  public function format() {
    if($this->safe==false){echo $this->er500();exit();}
    unlink("data/$this->gName");
    echo $this->response("200", "success");
  }
}