<!DOCTYPE html>
<html>
<head>
	<title>Send SMS from PHP using textlocal</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container">
<h1 class="text-center">Sending OTP SMS in PHP from localhost using textlocal</h1>
<hr>
	<div class="row">
	<div class="col-md-9 col-md-offset-2">
		<?php
			if(isset($_POST['sendopt'])) {
                require('textlocal.class.php');
                
                // Mobile OTP1 
				// $textlocal = new Textlocal(false, false, 'UEtn75yNCJ8-IoFwGsLPUwRiSVYw1aRkJGO7i4LWfs');
                $numbers = array($_POST['mobile']);
				$sender = 'TXTLCL';
				$otp1 = mt_rand(100, 999);
                $message = "Hello LEGACYcart user " . " This is your PART1 OTP is: " . $otp1;

                // Email OTP2
                $header = 'From: mail2surajmahendrakar@gmail.com'."\r\n".'MIME-Version: 1.0'."\r\n".'Content-Type: text/html; charset=utf-8';
                $subject = "Email OTP";
                $toEmail = $_POST['email'];
                $otp2 = mt_rand(100, 999);
                $body = "Hello LEGACYcart user " . " This is your PART2 OTP is: " . $otp2;
                $res = mail($toEmail, $subject, $body, $header);
                
                try {
                    $result = $textlocal->sendSms($numbers, $message, $sender);
                    $otp = $otp1.$otp2; 
				    setcookie('otp', $otp);
				    echo "OTP successfully send..";
				} catch (Exception $e) {
				    die('Error: ' . $e->getMessage());
				}
            }

			if(isset($_POST['verifyotp'])) { 
				$otp = $_POST['otp'];
				if($_COOKIE['otp'] == $otp) {
					echo "Congratulation, Your mobile is verified.";
				} else {
					echo "Please enter correct otp.";
				}
			}
		?>
	</div>
    <div class="col-md-9 col-md-offset-2">
        <form role="form" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-9 form-group">
                    <label for="uname">Email</label>
                    <input type="text" class="form-control" id="uname" name="email" value="" placeholder="Enter your email" required="">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9 form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="" maxlength="10" placeholder="Enter valid mobile number" required="">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9 form-group">
                    <button type="submit" name="sendopt" class="btn btn-lg btn-success btn-block">Send OTP</button>
                </div>
            </div>
            </form>
            <form method="POST" action="">
            <div class="row">
                <div class="col-sm-9 form-group">
                    <label for="otp">OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" maxlength="6" required="">
                </div>
            </div>
             <div class="row">
                <div class="col-sm-9 form-group">
                    <button type="submit" name="verifyotp" class="btn btn-lg btn-info btn-block">Verify</button>
                </div>
            </div>
        </form>
	</div>
</div>
</body>
</html>