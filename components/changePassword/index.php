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
<body class="container">
  
  <form name="changePasswordForm" class="container-fluid" action="" method="POST" onsubmit="changePassword();return false;">
    <div class="row form-group">
      <label>Old Password:</label>
      <input class="form-control" type="password" name="password"/></div>
    <div class="row form-group">
      <label>New Password:</label>
      <input class="form-control" type="password" name="new_password"/></div>
    <div class="row form-group">
      <label>Confirm New Password:</label>
      <input class="form-control" type="text" name="confirm_password"/></div>
    <div style="display:none">Username:<input type="text" name="username" value="<?php echo $_SESSION['username']?>"/></div>
    <div><button class="btn btn-outline-primary" type="submit" name="submit">UPDATE PASSWORD</button></div>
  </form>
  <H6 id="response"><H6>
  <!-- <script>login()</script> -->
</body>
</html>