<?php
session_start();
// if(isset($_POST['login'])) {
//     $db=mysqli_connect('localhost','root','','code');
//     if(!$db) {
//         echo "error".mysqli_error($db);
//     }
//    

//     $query="SELECT phone,email FROM register where phone='$phone' and email='$email'";
//     $result=mysqli_query($db,$query);
//     if(!$result) {
//         echo "Error".mysqli_error($result);
//     }
//     if(mysqli_num_rows($result)==1) {
//         header('location:home.php');
//     }
//     else {
//         echo "<h3>Entered Email Id or Phone number Incorrect</h3>";
//     }
// }





if(isset($_POST['sendopt'])) {
    require('textlocal.class.php');
    $db=mysqli_connect('localhost','root','','code');
    $phone=$_SESSION['phone']=$_POST['phone'];
    $email=$_SESSION['email']=$_POST['email'];

    $query="SELECT phone,email FROM register where phone='$phone' and email='$email'";
    $result=mysqli_query($db,$query);
    if(!$result) {echo "Error".mysqli_error($result);}

    if(mysqli_num_rows($result)==1) {
        $row = mysqli_fetch_assoc($result);
        $phoneNO = $row['phone'];
        $emailID = $row['email'];

        // Mobile OTP1 
        $textlocal = new Textlocal(false, false, 'bjr5a8YzsJU-W5RNxuUTD2J8y8TBt1pnWaQfs4VOPO');
        $numbers = array($phoneNO);
        $sender = 'TXTLCL';
        $otp1 = mt_rand(100, 999);
        $message = "Hello LEGACYcart user " . " This is your PART1 OTP is: " . $otp1;

        // Email OTP2
        $header = 'From: mail2surajmahendrakar@gmail.com'."\r\n".'MIME-Version: 1.0'."\r\n".'Content-Type: text/html; charset=utf-8';
        $subject = "Email OTP";
        $toEmail = $emailID;
        $otp2 = mt_rand(100, 999);
        $body = "Hello LEGACYcart user " . " This is your PART2 OTP is: " . $otp2;
        $res = mail($toEmail, $subject, $body, $header);
        try {
            $result = $textlocal->sendSms($numbers, $message, $sender);
            $otp = $otp1.$otp2; 
            setcookie('otp', $otp);
            echo "<h1>OTP sent successfully...</h1>";
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    } else {echo "<h3>Entered Email Id or Phone number Incorrect</h3>";}
}

    if(isset($_POST['verifyotp'])) { 
        $otp = $_POST['otp'];
        if($_COOKIE['otp'] == $otp) {
          echo "<script type='text/javascript'>
          alert('Login Successfully'); location.replace('http://localhost/codef/home.php');
          </script>";
        } else {
            echo "<h1>Please enter correct otp.</h1>";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
    
</head>
<body>
<div class="container">
<h2>LEGACYcart</h2>

  <div class="main">

  <a href="adminlogin.php" class="btn btn-primary admin">Admin</a>
  <form method="POST">
    
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Enter Phone" name="phone">
    </div>

    <div class="form-group">
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <input type="submit" class="btn btn-primary otp" value="Get OTP" name= "sendopt">
  </form>

  <form method="POST">
    <div class="form-group">
      <input type="number" class="form-control"  placeholder="Enter OTP" name="otp">
    </div>
    <div class="submit"></div>
    <input type="submit" class="btn btn-primary login" value="Login" name = "verifyotp">
    <a href="register.php" class="btn btn-primary reg">Register</a>

  </form>
  
  </div>

</div>



</body>
</html>