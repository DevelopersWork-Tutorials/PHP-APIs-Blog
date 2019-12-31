<script src="/blog/includes/jquery-3.4.1.min.js"></script>
<link rel="stylesheet" href="/blog/style.css?v=1">

<script async src="/blog/script.js"></script>

<?php 
    session_start();
    $route = str_replace("/blog","",$_SERVER["REQUEST_URI"]);
    switch($route){
        case "/":
            // echo "Home Page";
          include_once "./components/home/index.php";
          break;
        case "/login":case "/signin":case "/signin/":case "/login/":
          // echo "LOGIN PAGE";
          include_once "./components/login/index.php";
          break;
        case "/register":case "/signup":case "/signup/":case "/register/":
          // echo "LOGIN PAGE";
          include_once "./components/register/index.php";
          break;
        case "/changePassword":case "/updatePassword":case "/changePassword/":case "/updatePassword/":
          // echo "LOGIN PAGE";
          include_once "./components/changePassword/index.php";
          break;
        case "/dashboard":case "/dashboard/":
          // echo "LOGIN PAGE";
          include_once "./components/dashboard/index.php";
          break;
        default:
          echo "404 BAD REQUEST";
          break;
      }

?>
