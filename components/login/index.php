<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login - Developers@Work</title>
  <script src="/blog/components/login/script.js"></script>
  <link rel="stylesheet" href="/blog/components/login/style.css">

</head>
<body>
  
  <form name="loginForm" action="" method="POST" onsubmit="login();return false;">
    <div><input type="text" name="username"/></div>
    <div><input type="password" name="password"/></div>
    <div><button type="submit" name="submit">LOGIN</button></div>
  </form>
  <H6 id="response"><H6>
  <!-- <script>login()</script> -->
</body>
</html>