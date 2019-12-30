<?php
  // session_start();
  // print_r($_SESSION);
  if(!isset($_SESSION["uid"])){
    
    // echo "loggedIN";
    echo "<script>window.top.location='/blog/login'</script>";
    die();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dashboard - Developers@Work</title>
  <script src="/blog/components/dashboard/script.js?v=1.1"></script>
  <link rel="stylesheet" href="/blog/components/dashboard/style.css">

</head>
<body>
  
  <h1>Welcome, <?php echo $_SESSION["username"]; ?></h1>

  <a href="/blog/changePassword">
    <button>Change Password</button>
  </a>
  <button type="" onClick="logout()">Logout</button>
  <H6 id="response"><H6>
  <!-- <script>login()</script> -->
</body>
</html>