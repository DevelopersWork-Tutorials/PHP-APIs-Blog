<?php

include_once './database/index.php';
include_once './autheticate/index.php';
include_once './authorise/index.php';
include_once './content/posts/index.php';


session_start();
// unset($_SESSION);
class V1{
    function __construct(){

    }

    function handleRoute($route){

      $db = new Database();
      $db->connect();

      $authenticate = new Autheticate($db);
      $authorise = new Authorise($db);
      $posts = new Posts($db);

      $response = array();
      $response["data"] = array();
      switch($route){
        case "/login":
          // echo "LOGIN PAGE";
          $authenticate->login($_POST);
          $authorise->getPriority();
          $response = $authenticate->getResponse();
          break;
        case "/logout":
          $authenticate->logout();
          $response = $authenticate->getResponse();
          break;
        case "/isuserloggedin": 
          $response = $authenticate->isLoggedIn();
          break;
        case "/register":
          $authenticate->register($_POST);
          $response = $authenticate->getResponse();
          break;
        case "/changepassword":
          $authenticate->changePassword($_POST);
          $response = $authenticate->getResponse();
          break;
        case "/getclaims":
          $authorise->getClaims();
          $response = $authorise->getResponse();
          break;
        case "/setrole":
          $authorise->setRole($_POST);
          $response = $authorise->getResponse();
          break;
        case "/setservices":
          $authorise->setServices($_POST);
          $response = $authorise->getResponse();
          break;
        case "/createrole":
          $authorise->createRole($_POST);
          $response = $authorise->getResponse();
          break;
        case "/unsetclaim":
          $authorise->unsetClaim($_POST);
          $response = $authorise->getResponse();
          break;
        case "/readpost":
          $posts->read($_REQUEST);
          $response = $posts->getResponse();
        break;
        case "/getposts":
          $posts->get($_REQUEST);
          $response = $posts->getResponse();
          break;
        case "/createpost":
          $posts->create($_POST);
          $response = $posts->getResponse();
          break;
        case "/publishpost":
          $posts->publish($_POST);
          $response = $posts->getResponse();
          break;
        default:
          // echo "400 BAD REQUEST";
          break;
      }

      $response["request"] = array(
        "SERVER_NAME" => $_SERVER["SERVER_NAME"],
        "REQUEST_URL" => $_SERVER["REQUEST_URI"],
        "REQUEST_BODY" => $_REQUEST
      );

      $response["developer"] = array(
        "author" => "Developers@Work",
        "website" => "https://developerswork.online",
        "youtube" => "https://youtube.com/developerswork",
        "github" => "https://github.com/developerswork",
        "twitter" => "https://twitter.com/developersworky"
      );

      echo json_encode($response);
    }
}

$route = str_replace("/blog/api/v1","",$_SERVER["REQUEST_URI"]);
$route = explode("?",$route)[0];
$route = strtolower($route);

$api = new V1();
$api->handleRoute($route);

