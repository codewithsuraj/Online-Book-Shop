<?php 
session_start();
if($_SESSION['username']) {

}
if(isset($_POST['logout'])) {
    session_abort();
    header('location:adminlogin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>Admin-Legacy Cart</title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
  <span class="navbar-brand mb-0 h1">Legacy Cart</span>
  <a class="nav nav-link mr" href="adminhome.php">HOME</a>
</nav>
    <h1>Welcome <?php echo $_SESSION['username']; ?></h1>
    <form method="post">
        <input class="btn btn-primary" type="submit" name="logout" value="Logout"><br><br>
    </form>
    <a class="btn btn-primary" href="addBooks.php">Add Books</a>
    <a class="btn btn-primary" href="editBooks.php">Edit Books</a>
</body>
</html>