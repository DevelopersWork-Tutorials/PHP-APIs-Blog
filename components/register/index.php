<?php
  // session_start();
  // print_r($_SESSION);
  if(isset($_SESSION["uid"])){
    
    // echo "loggedIN";
    echo "<script>window.top.location='/blog/dashboard'</script>";
    die();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register - Developers@Work</title>
  <script src="/blog/components/register/script.js"></script>
  <link rel="stylesheet" href="/blog/components/register/style.css">

</head>
<body>
  
  <form name="registerForm" action="" method="POST" onsubmit="register();return false;">
    <div>Username:<input type="text" name="username"/></div>
    <div>Password:<input type="password" name="password"/></div>
    <div>Email:<input type="text" name="email"/></div>
    <div><button type="submit" name="submit">REGISTER</button></div>
  </form>
  <H6 id="response"><H6>
  <!-- <script>login()</script> -->
</body>
</html>