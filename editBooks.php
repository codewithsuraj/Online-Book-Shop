<?php
session_start();
if($_SESSION['username']) {
    $db=mysqli_connect('localhost','root','','code');
        if(!$db) { echo "error".mysqli_error($db);}
   } else {echo "Session Expired";die();}

    $q = "SELECT * FROM book";
    $r = mysqli_query($db, $q);
    $files = mysqli_fetch_all($r, MYSQLI_ASSOC);


    if(isset($_POST['submit'])) {
      $db=mysqli_connect('localhost','root','','code');
      if(!$db) {echo "error".mysqli_error($db);}

      $id=$_POST['id'];
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
          $sql = "UPDATE book SET bname = '$name',  filename = '$filename' , bdescription = '$description', bquantity = $quantity , bprice = $price WHERE bid = $id";
          if (!mysqli_query($db, $sql)) "Error";
      }
      header('location:editBooks.php');
  }
  if(isset($_POST['delete'])) {
    $id= $_POST['id'];
    $q = "DELETE FROM book WHERE bid = $id";
    $r = mysqli_query($db, $q);
    if($r) header('location:editBooks.php');
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
    <script src="https://cdnjs.c,loudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>Admin-Edit Book</title>
    <link rel="stylesheet" href="css/editBooks.css">
    <link href="https://fonts.googleapis.com/css?family=McLaren|Permanent+Marker&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-light bg-light">
  <span class="navbar-brand mb-0 h1">Legacy Cart</span>
  <a class="nav nav-link mr" href="adminhome.php">HOME</a>
</nav>
  

   <h1>Edit Book</h1>

   <div class="row">
      <?php 
            foreach ($files as $file){
              $bid = "bid".$file['bid'];
              $hbid = "hbid".$file['bid'];
      ?>
        <div id="<?php echo $bid;?>" class="card col-md-4" style="width: 18rem" >
          <img class="card-img-top" src="<?php echo 'product-images/'.$file['filename'];?>" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title"><?php echo "Name :".$file['bname']; ?></h5>
            <p class="card-text"><?php echo "Description :".$file['bdescription']; ?></p>
            <p class="card-text"><?php echo "Quantity :".$file['bquantity']; ?></p>
            <p class="card-text"><?php echo "Price :".$file['bprice']; ?></p>
            <button type="submit" class="btn btn-primary edit">Edit</button>
          </div>
        </div>

        <div id="<?php echo $hbid;?>" class="card col-md-6" style="width: 200px; height: 500px;" >
          <form method="POST" enctype="multipart/form-data">
              <p class="card-text"><input type="hidden" name="id" value = "<?php echo $file['bid'];?>"></p>
              <p class="card-text"><input type="file" name="myfile"      value="<?php echo $file['filename'];?>"></p>
              <p class="card-text"><input type="text" name="name"        value="<?php echo $file['bname'];?>" placeholder="Book Name"></p>
              <p class="card-text"><input type="text" name="description" value="<?php echo $file['bdescription'];?>" placeholder="Book Description"></p>
              <p class="card-text"><input type="number" name="quantity"  value="<?php echo $file['bquantity'];?>" placeholder="Total number of Books"></p>
              <p class="card-text"><input type="number" name="price"     value="<?php echo $file['bprice'];?>" placeholder="Price of single book"></p>
              <p class="card-text"><input type="submit" value="Edit Value" class="edit" name="submit"></p>
              <p class="card-text"><input type="submit" value="Delete Book" class="delete" name="delete"></p>
          </form>
            </div>
    <?php }?>
   </div>

   

   <script>
        $(document).ready(function(){
          $("[id^=hbid]").hide();
          $(".edit").click(function () {
            $("[id^=hbid]").show();
            $("[id^=bid]").hide();
          });
    });
      
   </script>
    
</body>
</html>