<?php

include_once './database/index.php';
include_once './autheticate/index.php';
session_start();
// unset($_SESSION);
class V1{
    function __construct(){

    }

    function handleRoute($route){
      $db = new Database();
      $db->connect();
      // $x = [[
      //   "tablename" => "blog_users_information",
      //   "whereClause" => [
      //     "email" => "admin@developerswork.yt",
      //     "phoneNumber" => "1212121212121"
      //   ]
      // ],[
      //   "tablename" => "blog_users",
      //   "whereClause" => [
      //     "username" => "admin"
      //   ]
      // ]];
      // $result = $db->readMultiples($x);
      // echo json_encode($result);
      // die();

      $auth = new Autheticate($db);

      $response = array();
      $response["data"] = array();
      switch($route){
        case "/login":
          // echo "LOGIN PAGE";
          $auth->login($_POST);
          $response = $auth->getResponse();
          break;
        case "/logout":
          $auth->logout();
          $response = $auth->getResponse();
          break;
        case "/isUserLoggedIn": 
          $response = $auth->isLoggedIn();
          break;
        case "/register":
          $auth->register($_POST);
          $response = $auth->getResponse();
          break;
        case "/changePassword":
          $auth->changePassword($_POST);
          $response = $auth->getResponse();
          break;
        default:
          // echo "400 BAD REQUEST";
          break;
      }

      $response["request"] = array(
        "SERVER_NAME" => $_SERVER["SERVER_NAME"],
        "REQUEST_URL" => $_SERVER["REQUEST_URI"]
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

$api = new V1();
$api->handleRoute($route);

