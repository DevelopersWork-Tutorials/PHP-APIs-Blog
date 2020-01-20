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

  function create($request){
    if(!isset($_SESSION["uid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "user not logged in"
      );
      return $this->setResponse();
    }
    if(!isset($request["title"]) || !isset($request["content"]) || !isset($request["category"]) ){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "post/incorrect-details",
        "message" => "post title or category or content doesn't exist",
        "error" => "parameters"
      );
      return $this->setResponse();
    }
    $author = $_SESSION["uid"];
    if(isset($request["author"])){
      $author = $request["author"];
    }
    $content = str_split($request["content"],9000);
    // print_r($content);
    $title = $request["title"];
    $result = $this->db->insertSimple("blog_posts","post_title,post_author_id","'".$request["title"]."','$author'");
    if($result["query_error"]){
      echo $result["query_error"];
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $result = $this->db->query("select post_id from blog_posts where post_title='$title' and post_author_id='$author';");
    if($result["query_error"]){
      
      // echo $result["query_error"];
      $this->status = $result["query_error"];
      return $this->setResponse();
    }

    $id = $result[0]["post_id"];
    $category = $request["category"];
    $result = $this->db->insertSimple("blog_posts_metadata","post_id,category,revision_id","'$id','$category',-1");
    if($result["query_error"]){
      
      // echo $result["query_error"];
      $this->status = $result["query_error"];
      return $this->setResponse();
    }
    
    $status = array();
    for($i=0;$i < count($content) ; $i++){
      $string = str_replace("'","\"",$content[$i]);
      // echo $string;
      $result = $this->db->insertSimple("blog_posts_content","post_id,post_part,post_content,post_revision","'$id','$i','$string',0");
      if($result["query_error"]){
        // echo $result["query_error"];

        // $this->status = $result["query_error"];
        array_push($status,$result["query_error"]);
        // return $this->setResponse();
      }
    }

    if(count($status) > 0){
      $this->status = $status;
      return $this->setResponse();
    }
    $this->status = 200;
    $this->response["data"] = array( "status" => true );
    return $this->setResponse();
  }

  function publish($request){
    if(!isset($_SESSION["uid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "auth/incorrect-details",
        "message" => "user not logged in"
      );
      return $this->setResponse();
    }

    if(!isset($request["postid"]) || !isset($request["revisionid"])){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "post/incorrect-details",
        "message" => "post id or revision id doesn't exist",
        "error" => "parameters"
      );
      return $this->setResponse();
    }
    $postid = $request["postid"];
    $revisionid = $request["revisionid"];

    // Start code here
    $result = $this->db->readSimpleAND("blog_posts_content","map_id",array("post_id","post_revision"),array($postid,$revisionid));
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }if($result["length"] < 1){
      $this->status = 400;
      $this->response["data"] = array(
        "code" => "post/incorrect-details",
        "message" => "post id or revision id doesn't exist",
        "error" => "parameters"
      );
      return $this->setResponse();
    }

    $result = $this->db->updateSimple("blog_posts_metadata","revision_id",$revisionid,"post_id",$postid);
    if($result["query_error"]){
      $this->status = $result["query_error"];
      return $this->setResponse();
    }
    
    $this->status = 200;
    $this->response["data"] = array( "status" => true );
    return $this->setResponse();
  }

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
    $this->response["data"] = array( "content" => $response );
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
    $this->response["data"] = array ( "posts" => $response);
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