<?php
session_start();
if(isset($_POST['submit'])) {

    // code for check server side validation
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
        $msg="<span style='color:red'>The Validation code does not match!</span>";// Captcha verification is incorrect.		
        // Captcha verification is incorrect.		
	}else{// Captcha verification is Correct. Final Code Execute here!		
        $db=mysqli_connect('localhost','root','','code');
        if(!$db) {
            echo "error".mysqli_error($db);
        }
        $name=$_SESSION['name']=$_POST['name'];
        $email=$_SESSION['email']=$_POST['email'];
        $phone=$_POST['phone'];
        $address=$_POST['address'];
        $query="INSERT INTO register(name,email,phone,address) VALUES('$name','$email','$phone','$address')";
        $result=mysqli_query($db,$query);
        if($result) {
        echo "<script type='text/javascript'>
        alert('Registration done Successfully'); location.replace('http://localhost/codef/index.php');
        </script>";
        }   else {
            echo "Registration Failed!".mysqli_error($result);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Here</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/register.css">

    <script type='text/javascript'>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>


</head>
<body>
    <div class="cont">
        <h2 >Register here</h2>
    <form class="main" method="POST">
        <?php if(isset($msg)) {
            echo $msg;
        } ?>
		<div class="form-group">
		<input type="text" class="form-control" placeholder="Full Name" name="name" id ="name" required>
		</div>
		
		<div class="form-group">
		<input type="email" class="form-control" id="email" placeholder="Email Address" name ="email" required>
		</div>

		<div class="form-group">
		<input type="number" class="form-control" id="phone" placeholder="Phone number" maxlength="10" name="phone" required>
		</div>

		<div class="form-group">
		<textarea class="form-control" rows="2" id="comment" placeholder="Divalery Address" name="address" required></textarea>
		</div>
        <div class="flex">

        <img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br>
        <input id="captcha_code" name="captcha_code" placeholder="Enter the above captcha" type="text" >


        </div>
        
        <a href='javascript: refreshCaptcha();' class="ref"><i class="fa fa-refresh"></i></a> 
    </tr>
		<input type="submit" onclick="return validate();" class="btn btn-primary reg" value="Register" name ="submit">
	</form>


    </div>
	

</body>
</html>