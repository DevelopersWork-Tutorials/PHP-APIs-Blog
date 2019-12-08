<?php

// class V1{
    
// }
include_once './database/index.php';
include_once './autheticate/index.php';
// echo $_SERVER["REQUEST_URI"];

$db = new Database();
$db->connect();

$auth = new Autheticate($db);

$route = str_replace("/blog/api/v1","",$_SERVER["REQUEST_URI"]);
// echo "<br>";
switch($route){
  case "/login":
    // echo "LOGIN PAGE";
    $auth->login($_POST);
    $response = $auth->getResponse();
    echo json_encode($response);
    break;
  case "/register":
    echo "REGISTER PAGE";
    break;
  default:
    echo "400 BAD REQUEST";
    break;
}

// echo "<br>Hello World";