<?php
    include 'config.php';
    $msg = "";
    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));
        
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
        } else {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$name}', '{$email}', '{$password}', '{$code}')";
                $result = mysqli_query($conn, $sql);
                $msg = "<div class='alert alert-info'>Registration Succsessfull!!!</div>";
            
                
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";  
            }
        }
    }
// ?>

 <?php
//     include 'config.php';
//     $msg = "";
    if (isset($_POST['submit1'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
			$_SESSION['user_id']=$row['id'];
            header("Location: download.php");
        } else {
            $msg ="<div class='alert alert-danger'>Email or password do not match.</div>";
        }
    }
?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login & Registration</title>
	<link rel="stylesheet" href="style5.css">
</head>
<body>
	<div class="container" style="background: #081b29;">
		<div id="LoginAndRegistrationForm" style="background: #ededed;">
			<h1 id="formTitle">Login</h1>
			<div id="formSwitchBtn">
				<button onclick="ShowLoginForm()"  id="ShowLoginBtn" class="active">Login</button>
				<button onclick="ShowRegistrationForm()"  id="ShowRegistrationBtn">Registration</button>
			</div>
			<div id="LoginFrom">
            <form action="" method="post">
					<div class="center">
						<input id="LoginEmail" class="input-text" name="email" type="text" placeholder="Email Address" autocomplete="off"> 
						<input id="LoginPassword" class="mt-10 input-text" name="password" type="password" placeholder="Password" autocomplete="off">
					</div>
					
					<div class="forgot-pass-remember-me mt-10">
						<div class="forgot-pass">
							<a id="ForgotPassword" href="JavaScript:void(0);" onclick="ShowForgotPasswordForm()" >Forgot Password?</a>
						</div>
						<div class="remember-me">
							<input id="rememberMe" type="checkbox">
							<label for="rememberMe">Remember Me</label>
						</div>
					</div>

					<div class="center mt-20">
						<input onclick="return ValidateLoginForm();"  class="Submit-Btn" type="submit" name="submit1" value="Login" id="LoginBtn">
					</div>
				</form>
				<p class="center mt-20 dont-have-account">
					Don't have an account? 
					<a href="JavaScript:void(0);" onclick="ShowRegistrationForm()">Registration now</a>
				</p>
			</div>
			<div id="RegistrationFrom">
            <?php echo $msg; ?>
                <form action="" method="post">
					<div class="center">
						<input id="RegiName" class="input-text" type="text" placeholder="Full Name" name="name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>">
						<input id="RegiEmailAddres" class="input-text mt-10" type="email" placeholder="Email Address" name="email"value="<?php if (isset($_POST['submit'])) { echo $email; } ?>">
						<input id="RegiPassword" class="mt-10 input-text" type="password" placeholder="Password" name="password">
						<input id="RegiConfirmPassword" class="mt-10 input-text" type="password" placeholder="Confirm Password" name="confirm-password">
					</div>
					<div class="center mt-20">
						<input onclick="return ValidateRegistrationForm();" class="Submit-Btn" type="submit" value="Registration" name="submit" id="RegistrationitBtn">
					</div>
				</form>
				<p class="center mt-20 already-have-account">
					Already have an account? 
					<a href="#" onclick="ShowLoginForm()">Login now</a>
				</p>
			</div>
			<div id="ForgotPasswordForm">
				<form action="">
					<div class="center mt-20">
						<input class="input-text " type="email" id="forgotPassEmail" placeholder="Email Address">
					</div>
					<div class="center mt-20">
						<input onclick="return ValidateForgotPasswordForm();" class="Submit-Btn" type="submit" value="Reset Password" id="PasswordResetBtn" >
					</div>
				</form>
				<p class="center mt-20 already-have-account">
					Back to the 
					<a href="JavaScript:void(0);" onclick="ShowLoginForm()">Login page</a> | <a href="JavaScript:void(0);" onclick="ShowRegistrationForm()">Registration page</a>
				</p>
			</div>
		</div>
	</div>

	<script src="main.js" type="text/javascript"></script>
	<script src="validation.js" type="text/javascript"></script>
    <script type="text/javascript" src="script.js"></script>

<script src="jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>
</body>
</html>