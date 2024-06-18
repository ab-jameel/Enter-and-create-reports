<!DOCTYPE html>
<html>
<head>
	<title>تسجيل الدخول</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/new.bmp"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="https://kit.fontawesome.com/9acd051564.js" crossorigin="anonymous"></script>
	<style type="text/css">
		.right1{
			text-align: right;
		}

		html,body{
			margin: 0;
			height: 100%;
			overflow: hidden;
		}
	</style>
</head>
<body class="right1">
<?php 
require_once 'php/loginuser.php';
if (isset($_SESSION['message'])):
?>
<div class="alert alert-<?=$_SESSION['msg_type']?>" style="margin-bottom: -5px;">
	<?php 
echo $_SESSION['message'];
unset($_SESSION['message']);
if ($_SESSION['msg_type'] == "danger"){	?>
<i class="fas fa-exclamation" style="margin-left: 10px;"></i>
<?php } endif;?>
</div>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-5 p-b-50">
				<form action="php/loginuser.php" method="POST" class="login100-form validate-form">
					<span class="login100-form-title p-b-70">
						مرحبا
					</span>
					<span class="login100-form-avatar" style="width: 150px;height: 150px;margin-top: -30px;">
						<img src="images/new.bmp" alt="AVATAR" style="padding: 10px;">
					</span>

					<div class="wrap-input100 m-t-20 m-b-35">
						<input class="input100 right1" type="text" name="kusername" autocomplete="off" id="kuser1">
						<span class="focus-input100 right1" data-placeholder="اسم المستخدم"></span>
					</div>

					<div class="wrap-input100 m-b-50">
						<input class="input100 right1" type="password" name="kpassword" autocomplete="off">
						<span class="focus-input100 right1" data-placeholder="كلمة المرور"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" style="font-size: 20px; font-family: arial; font-weight: bold;">
							دخول
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<script src="js/main.js"></script>

</body>
<script type="text/javascript">
	document.getElementById('kuser1').focus();
</script>
</html>