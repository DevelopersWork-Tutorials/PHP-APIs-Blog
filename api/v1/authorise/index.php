<?php

class Authorise{
  private $db;
  private $status;
  private $response;

  function __construct($db){
    $this->db = $db;
    $this->status = 200;
    $this->response = array();
  }

  function getClaims(){
    if(!isset($_SESSION["uid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "user not logged in"
      );
      return $this->setResponse();
    }

    $result = $this->db->readSimple("blog_roles_services_users_map","role_id,service_id","user_id",$_SESSION["uid"]);
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $services = array();
    for($i=0;$i<$result["length"];$i++){
      if($result[$i]["service_id"])
        // push($services,$result[$i]["service_id"]);
        $services[$result[$i]["service_id"]] = true;
      if($result[$i]["role_id"]){
        $result2 = $this->db->readSimple("blog_roles_services_map","service_id","role_id",$result[$i]["role_id"]);
        if($result2["query_error"]){
          // $this->status = $result["query_error"];
          // return $this->setResponse();
          continue;
        }
        for($j=0;$j<$result2["length"];$j++)
          // push($services,$result2[$i]["service_id"]);
          $services[$result2[$i]["service_id"]] = true;
      }
    }
    $data = array();
    foreach($services as $key => $value){
      $result = $this->db->readSimpleOR("blog_services","service_id,service_name,service_parent",array("service_id","service_parent"),array($key,$key));
      if($result["query_error"]){
        echo $result["query_error"];
        // $this->status = $result["query_error"];
        // return $this->setResponse();
        continue;
      }
      for($i=0;$i<$result["length"];$i++)
        array_push($data,$result[$i]);
    }

    $this->response["data"] = $data;
    return $this->setResponse();
  }

  function setRole($request){
    if(!isset($_SESSION["uid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "user not logged in"
      );
      return $this->setResponse();
    }

    if(!isset($request["username"]) || !isset($request["role"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "provided information is not good"
      );
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
    $uid = $result[0]["uid"];

    $result = $this->db->readSimple("blog_roles","*","role_name",$request["role"]);

    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }else if($result["length"] < 1){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "provided role is incorrect",
        "error" => "role"
      );
      return $this->setResponse();
    }
    $role_id = $result[0]["role_id"];

    $result = $this->db->insertSimple("blog_roles_services_users_map","role_id,user_id,createdBy","'$role_id','".$uid."','".$_SESSION["uid"]."'");                                      
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $this->response["data"] = array(
      "username" => $request["username"],
      "role" => $request["role"]
    );

    return $this->setResponse();
  }

  function setServices($request){
    if(!isset($_SESSION["uid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "user not logged in"
      );
      return $this->setResponse();
    }

    if(!isset($request["username"]) || !isset($request["services"]) || !is_array($request["services"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "provided information is not good"
      );
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
    $uid = $result[0]["uid"];

    // Start here
    $values = array();
    for($i=0;$i<count($request["services"]);$i++){
      $result = $this->db->readSimple("blog_services","*","service_id",$request["services"][$i]);

      if($result["query_error"]){
        $this->status = $result["query_error"];
        return $this->setResponse();
      }else if($result["length"] < 1){
        $this->status = 400;
        $this->response["data"] = array(
          "code" => "auth/incorrect-details",
          "message" => "provided services doesn't exists",
          "error" => "services"
        );
        return $this->setResponse();
      }

      // (service_id,users_id,created_by)
      $values["".$i] = "'".$request["services"][$i]."','$uid','".$_SESSION["uid"]."'";
    }

    $result = $this->db->insertMultipleSets("blog_roles_services_users_map","service_id,user_id,createdby",$values);
    if($result["query_error"]){
      print_r($result);
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $this->response["data"] = array(
      "username" => $request["username"],
      "services" => $request["services"]
    );

    return $this->setResponse();
  }

  function getPriority(){
    if(!isset($_SESSION["uid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "user not logged in"
      );
      return $this->setResponse();
    }

    $result = $this->db->readSimple("blog_roles_services_users_map","role_id","user_id",$_SESSION["uid"]);
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $priority = 0;
    for($i=0;$i<$result["length"];$i++){
      $resultSub = $this->db->readSimple("blog_roles","priority","role_id",$result[$i]["role_id"]);
      if($resultSub["query_error"]){
        // $this->status = $result["query_error"];
        // return $this->setResponse();
        continue;
      }
      if($resultSub["length"] > 0)
      if($resultSub[0]["priority"] > $priority){
        $priority = $resultSub[0]["priority"];
      }
    }

    $_SESSION["priority"] = $priority;
  }

  function createRole($request){
    $id = "";
    if(!isset($_SESSION["uid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "user not logged in"
      );
      return $this->setResponse();
    }

    if(!isset($request["role_name"]) || !isset($request["role_priority"]) || !isset($request["services"]) || !is_array($request["services"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "provided information is not good"
      );
      return $this->setResponse();
    }

    $result = $this->db->readSimple("blog_roles","1","role_name",$request["role_name"]);
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }else if($result["length"] > 0){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/role-exists",
        "message" => "Role already Exists"
      );
      return $this->setResponse();
    }

    $result = $this->db->insertSimple("blog_roles","role_name,priority","'".$request["role_name"]."','".$request["role_priority"]."'");
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }
    $result = $this->db->readSimple("blog_roles","role_id","role_name",$request["role_name"]);
    $id = $result[0]["role_id"];

    for($i=0;$i<count($request["services"]);$i++){
      $result = $this->db->insertSimple("blog_roles_services_map","role_id,service_id","'$id','".$request["services"][$i]."'");
      if($result["query_error"]){
        // $this->status = $result["query_error"];
        // return $this->setResponse();
        continue;
      }
    }

    $this->response["data"] = array(
      "id" => $id,
      "role" => $request["role_name"],
      "services" => $request["services"]
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