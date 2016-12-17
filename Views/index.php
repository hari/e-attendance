<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="<?php echo asset('css/app.css'); ?>">
</head>
<body class="home">
<?php include_once 'parts/message.php'; ?>
 <div>
  <form class="block-form" id="login-form" action="user/login" method="POST">
    <img id="form-logo" src="<?php echo asset('img/logo.png'); ?>" />
    <fieldset>
     <label for="username">Username</label>
     <input type="text" name="username" value="" placeholder="se201412" />
   </fieldset>
   <fieldset>
     <label for="password">Password</label>
     <input type="password" name="password" value="" />
   </fieldset>
   <input class="btn btn-default" type="submit" value="Login" />
 </form>
</div>
</body>
</html>