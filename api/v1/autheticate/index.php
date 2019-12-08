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
    if(isset($_SESSION["uid"]) && isset($_SESSION["username"])){
      if($request["username"] == $_SESSION["username"]){
        if($request["password"] == $_SESSION["password"]){
          $this->status = 1;
        }
      }
    }
    if($this->status == 1){
      $this->status = 200;
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
      $_SESSION["uid"] = $uid;
      $_SESSION["username"] = $request["username"];
      $_SESSION["password"] = $password;

      $this->response["data"] = array(
        "uid" => $_SESSION["uid"]
      );

    }else{
      $this->status = 400;
    }
    return $this->setResponse();
  }

  function logout(){
    $this->response["data"] = array(
      "username" => $_SESSION["username"]
    );
    $this->status = 200;
    unset($_SESSION);
    session_destroy();
    return $this->setResponse();
  }

  function isLoggedIn(){
    $response = array();
    if(isset($_SESSION["username"]) && isset($_POST["username"]))
      if($_SESSION["username"] == $_POST["username"]){
        $response["data"]["session"] = true;
      }
    if(!isset($response["data"]["session"]))
      $response["data"]["session"] = false;

    return $response;
  }


  function setResponse(){
    // echo $this->status;
    if($this->status == 200){
      $this->response["status"] = 200;
    }else{
      $this->response["status"] = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "authetication failed due to incorrect"
      );
    }
  }

  function getResponse(){
    return $this->response;
  }

}