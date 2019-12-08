<?php

class Autheticate{
  private $db;
  private $status;
  private $response;

  function __construct($db){
    $this->db = $db;
    return $this->status = 200;
    $this->response = array();
  }

  function login($request){
    if(!isset($request["username"]) || !isset($request["password"])){
      $this->status = 400;
      return $this->setResponse();
    }

    $result = $this->db->readSimple("blog_users","*","username",$request["username"]);

    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    // print_r($result);

    $uid = $result[0]["uid"];

    $result = $this->db->readSimple(" blog_users_credentials","*","uid",$uid);
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }
    // print_r($result);

    $password = $result[0]["password"];
    // echo $request["password"];
    // echo "<br>";
    // echo md5($request["password"]);
    // echo "<br>";
    // echo $password;
    if(md5($request["password"]) == $password){
      // echo "MATCHED";
      $this->status = 200;
    }else{
      $this->status = 404;
    }
    return $this->setResponse();
  }

  function setResponse(){
    if($this->status == 200){
      $this->response["status"] = 200;
    }else{
      $this->response["status"] = 400;
    }
  }

  function getResponse(){
    return $this->response;
  }

}