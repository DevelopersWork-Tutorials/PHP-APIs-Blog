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

  function read($request){
    if(!isset($request["postid"]) || !isset($request["revisionid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "post/incorrect-details",
        "message" => "post id or revision id doesn't exist",
        "error" => "parameters"
      );
      return $this->setResponse();
    }
    $post_id = $request["postid"];
    $revision_id = $request["revisionid"];

    $query = "SELECT post_content FROM `blog_posts_content` WHERE post_id=$post_id and post_revision=$revision_id order by post_part";

    $result = $this->db->query($query);
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $response = array();
    for($i=0;$i<$result["length"];$i++){
      array_push($response,$result[$i]["post_content"]);
    }

    $this->status = 200;
    $this->response["data"] = $response;
    return $this->setResponse();

  }

  function get($request){
    // print_r($request);
    $limit = 20;
    $offset = 0;
    $category = "'*' or 1 = 1";
    $post_id = "'*' or 1 = 1";
    if(isset($request["offset"]))
      $offset = $request["offset"];
    if(isset($request["limit"]))
      $limit = $request["limit"];
    if(isset($request["category"]))
      $category = "'".$request["category"]."'";
    if(isset($request["postid"]))
      $post_id = "'".$request["postid"]."'";
    
    $query = "SELECT post_id,category,revision_id,publishedOn FROM `blog_posts_metadata` WHERE (category=$category) and (post_id=$post_id) order by publishedOn DESC limit $limit OFFSET $offset";

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