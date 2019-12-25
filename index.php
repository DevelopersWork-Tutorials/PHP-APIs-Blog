<script src="/blog/includes/jquery-3.4.1.min.js"></script>
<link rel="stylesheet" href="/blog/style.css">

<script async src="/blog/script.js"></script>

<?php 
    session_start();
    $route = str_replace("/blog","",$_SERVER["REQUEST_URI"]);
    switch($route){
        case "/":
            // echo "Home Page";
            include_once "./components/home/index.php";
            break;
        case "/login/":
          // echo "LOGIN PAGE";
          include_once "./components/login/index.php";
          break;
        default:
          echo "404 BAD REQUEST";
          break;
      }

?>