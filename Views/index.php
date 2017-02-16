<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,inital-scale=1.0">
  <style type="text/css">
    <?php echo str_replace('../', asset(''), require_once 'parts/font.php'); ?>
  </style>
  <link rel="stylesheet" type="text/css" href="<?php echo asset('css/app.css'); ?>">
</head>
<body class="home">
  <?php include_once 'parts/message.php'; ?>
  <div>
    <form class="block-form" id="login-form" action="user/login" method="POST">
      <img id="form-logo" src="<?php echo asset('img/logo.png'); ?>" />
      <div style="height: 2px; background-color: #efefef; margin: 16px 0;"></div>
      <fieldset>
       <label for="username">Username</label>
       <input type="text" name="username" value="" placeholder="se201412" />
     </fieldset>
     <fieldset>
       <label for="password">Password</label>
       <input type="password" name="password" value="" />
     </fieldset>
     <input style="margin-top: 8px;" class="btn btn-default" type="submit" value="Login" />
   </form>
 </div>
</body>
</html>