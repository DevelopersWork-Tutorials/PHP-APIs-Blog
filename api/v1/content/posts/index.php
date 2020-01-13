<?php
class Posts{

  private $db;
  private $status;
  private $response;

  function __construct($db){
    $this->db = $db;
    $this->status = 200;
    $this->response = array();
  }

  function create(){}

  function update(){}

  function delete(){}

  function read(){}

  function get($request){
    $limit = 20;
    $offset = 0;
    if(isset($request["offset"]))
      $offset = $request["offset"];
    if(isset($request["limit"]))
      $limit = $request["limit"];
    
    $query = "SELECT post_id,category,revision_id,publishedOn FROM `blog_posts_metadata` WHERE 1 order by publishedOn DESC limit $limit OFFSET $offset";

    $result = $this->db->query($query);
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $response = array();
    for($i=0;$i<$result["length"];$i++){
      array_push($response,$result[$i]);
    }

    $this->status = 200;
    $this->response["data"] = $response;
    return $this->setResponse();

  }


  function setResponse(){
    // echo $this->status;
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