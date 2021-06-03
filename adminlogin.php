<?php
session_start();
$_SESSION['username']=$username="admin";
$password="myadmin"; 
if(isset($_POST['login'])) {
    $un=$_POST['username'];
    $passwd=$_POST['password'];
    if($un==$username and $passwd==$password) {header('location:adminhome.php');}
    else{echo "<h3>Entered Username or Password is Incorrect</h3>";}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/adminlogin.css">
</head>
<body>
<nav class="navbar navbar-light bg-light">
  <span class="navbar-brand mb-0 h1"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Legacy Cart</span>
  <a class="nav nav-link mr" href="index.php">HOME</a>
</nav>

  <div class="cont">
        <h1>Admin Login</h1>
      <form method="post">
      <div class="form-group">
      <input type="text" class="form-control" placeholder="Username" name="username">
      </div>
      <div class="form-group">
      <input type="password" class="form-control" placeholder="Password" name="password">
      </div>
      <input type="submit" value="Login"  class="btn btn-primary login" name="login">
    </form>
  </div>
</body>
</html>