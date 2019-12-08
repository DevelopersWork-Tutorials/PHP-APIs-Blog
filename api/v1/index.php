<?php

// class V1{
    
// }
echo $_SERVER["REQUEST_URI"];

$route = str_replace("/blog/api/v1","",$_SERVER["REQUEST_URI"]);
echo "<br>";
switch($route){
  case "/login":
    echo "LOGIN PAGE";
    break;
  case "/register":
    echo "REGISTER PAGE";
    break;
  default:
    echo "400 BAD REQUEST";
    break;
}

// echo "<br>Hello World";