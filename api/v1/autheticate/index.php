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
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "provided information if not good"
      );
      return $this->setResponse();
    }
    if(isset($_SESSION["uid"]) && isset($_SESSION["username"])){
      if($request["username"] == $_SESSION["username"]){
        if($request["password"] == $_SESSION["password"]){
          $this->status = 1;
        }else{
          $this->logout();
          // $this->status = 400;
          return $this->login($request);
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
    }else if($result["length"] < 1){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "provided username is incorrect",
        "error" => "username"
      );
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
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "incorrect password provided",
        "error" => "password"
      );
    }
    return $this->setResponse();
  }

  function logout(){
    if(!isset($_SESSION["uid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "user not logged in"
      );
      unset($_SESSION);
      session_destroy();
      return $this->setResponse();
    }

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

  function changePassword($request){
    if(!isset($request["username"]) || !isset($request["password"]) || !isset($request["new_password"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "provided information if not good"
      );
      return $this->setResponse();
    }

    // echo $_SESSION["uid"];
    if(!isset($_SESSION["uid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "user not authenticated",
        "error" => "authentication"
      );
      return $this->setResponse();
    }

    // echo $_SESSION["username"];
    if($_SESSION["username"] != $request["username"]){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "incorrect username provided",
        "error" => "username"
      );
      return $this->setResponse();
    }

    $uid = $_SESSION["uid"];

    // echo $_SESSION["password"];
    $result = $this->db->readSimple(" blog_users_credentials","*","uid",$uid);
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    // echo "<br>";
    // echo $result[0]["password"]." --- ".md5($request["password"]);
    if($result[0]["password"] == md5($request["password"])){
      $result = $this->db->updateSimple(" blog_users_credentials","password",md5($request["new_password"]),"uid",$uid);
      if($result["query_error"]){
        $this->status = $result["query_error"];
        return $this->setResponse();
      }
    }else{
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "incorrect password provided",
        "error" => "password"
      );
      return $this->setResponse();
    }
    $this->status = 200;
    $this->response["data"] = array(
      "uid" => $_SESSION["uid"]
    );
    return $this->setResponse();

  }

  function register($request){
    if(!isset($request["username"]) || !isset($request["password"]) || !isset($request["email"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "provided information if not good"
      );
      return $this->setResponse();
    }

    // $phoneNumber = 0;
    // if(isset($request["phoneNumber"])){
    //   $phoneNumber = $request["phoneNumber"];
    // }

    $query = [[
        "tablename" => "blog_users_information",
        "whereClause" => [
          "email" => $request["email"]
        ]
      ],[
        "tablename" => "blog_users",
        "whereClause" => [
          "username" => $request["username"]
        ]
    ]];

    $result = $this->db->readMultiples($query);
    if($result["length"] > 0){
      $this->status = $result["query_error"];
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "data already exists",
        "error_list" => array()
      );
      // print_r($result);
      for($i=0;$i<$result["length"];$i++){
        if($result[$i]["email"] == $request["email"]){
          $response = array(
            "code" => "auth/incorrect-details",
            "message" => "email already exists",
            "error" => "email"
          );
          $this->response["data"]["error_list"]["email"] = $response;
        }
        if($result[$i]["username"] == $request["username"]){
          $response = array(
            "code" => "auth/incorrect-details",
            "message" => "username already exists",
            "error" => "username"
          );
          $this->response["data"]["error_list"]["username"] = $response;
        }
      }

      return $this->setResponse();
    }

    $result = $this->db->insertSimple("blog_users","username","'".$request["username"]."'");
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $result = $this->db->readSimple("blog_users","*","username",$request["username"]);
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $uid = $result[0]["uid"];

    $result = $this->db->insertSimple("blog_users_credentials","uid,password","'$uid','".md5($request["password"])."'");
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $result = $this->db->insertSimple("blog_users_information","uid,email","'$uid','".$request["email"]."'");
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $this->status = 200;
    $this->response["data"] = array(
      "uid" => $uid
    );
    return $this->setResponse();
  }

  function setResponse(){
    // echo $this->status;
    if($this->status == 200){
      $this->response["status"] = 200;
    }else{
      $this->response["status"] = 400;
      // if(!isset($this->$response))
      // $this->response["data"] = array(
      //   "code" => "auth/incorrect-details",
      //   "message" => "authetication failed due to incorrect",
      //   "error" => ($this->status)
      // );
    }
  }

  function getResponse(){
    return $this->response;
  }

}