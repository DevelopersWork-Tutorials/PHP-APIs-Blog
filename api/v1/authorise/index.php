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
      $result = $this->db->readSimpleOR("blog_services","service_id,service_name,service_parent","service_id",$key,"service_parent",$key);
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