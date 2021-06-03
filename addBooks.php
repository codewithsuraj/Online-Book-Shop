<?php
session_start();
if($_SESSION['username']) {
    if(isset($_POST['submit'])) {
        $db=mysqli_connect('localhost','root','','code');
        if(!$db) {echo "error".mysqli_error($db);}

        $name=$_POST['name'];
        $description=$_POST['description'];
        $quantity=$_POST['quantity'];
        $price=$_POST['price'];

        $filename = $_FILES['myfile']['name'];
        $destination = 'product-images/' . $filename;

        $extension = pathinfo($filename, PATHINFO_BASENAME);

        $file = $_FILES['myfile']['tmp_name'];
        $size = $_FILES['myfile']['size'];

        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO book (bname,filename , bdescription, bquantity, bprice) VALUES('$name','$filename','$description',$quantity, $price)";
            if (!mysqli_query($db, $sql)) "Error";
        }
    }
} else{
    echo "<script>alert('Session Expired! Login again.');</script>";
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
    <link rel="stylesheet" href="css/index.css">
    <title>Add Books</title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
  <span class="navbar-brand mb-0 h1">Legacy Cart</span>
  <a class="nav nav-link mr" href="adminhome.php">HOME</a>
</nav>
    <h1>Add Books</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Book Name"><br>
        <input type="text" name="description" placeholder="Book Description"><br>
        <input type="number" name="quantity" placeholder="Total number of Books"><br>
        <input type="number" name="price" placeholder="Price of single book"><br>
        <input type="file" name="myfile">
        <input type="submit" value="Add Book" name="submit">
    </form>

</body>
</html>