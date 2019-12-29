<?php
  // session_start();
  // print_r($_SESSION);
  // if(isset($_SESSION["uid"])){
    
  //   // echo "loggedIN";
  //   echo "<script>window.top.location='/blog/dashboard'</script>";
  //   die();
  // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>UPDATE PASSWORD - Developers@Work</title>
  <script src="/blog/components/changePassword/script.js"></script>
  <link rel="stylesheet" href="/blog/components/changePassword/style.css">

</head>
<body>
  
  <form name="changePasswordForm" action="" method="POST" onsubmit="changePassword();return false;">
    <div>Old Password:<input type="password" name="password"/></div>
    <div>New Password:<input type="password" name="new_password"/></div>
    <div>Confirm New Password:<input type="text" name="confirm_password"/></div>
    <div style="display:none">Username:<input type="text" name="username" value="<?php echo $_SESSION['username']?>"/></div>
    <div><button type="submit" name="submit">UPDATE PASSWORD</button></div>
  </form>
  <H6 id="response"><H6>
  <!-- <script>login()</script> -->
</body>
</html>