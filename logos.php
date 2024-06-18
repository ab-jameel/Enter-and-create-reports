<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="css/key.css">
	<script src="js/jquery-3.4.1.slim.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/logout.js"></script>
	<script src="https://kit.fontawesome.com/9acd051564.js" crossorigin="anonymous"></script>
	<link rel="icon" type="image/png" href="images/new.bmp"/>

  <style type="text/css">
	.div1:hover {background-color: #ddd;}
	.div2:hover {background-color: #ddd;}

	*{
		font-family: arial;
	}

	.img1{
		background-color: white;
		margin-top: 10px;
		padding: 25PX;
		border: 1px solid white;
     	box-shadow: gray 0 0 10px;
		width: 250px; 
		height: 250px;
	}

	.div1{
		float: right;
		text-align: center;
		width: 50%;
	}

	.div2{
		text-align: center;
		width: 50%;
	}

	.bt11{
		font-size: 20px;
		margin-top: 30px;
		width: 90%;
		margin-bottom: 20px;
	}

	.save{
		float: left;
	}

	@media screen and (max-width: 669px) {
		.div1{
			width: 95%;
		}

		.div2{
			width: 95%;
		}
	}

  </style>
	<title>شعار التقرير</title>

<?php 
require_once 'php/logos_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 23") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];

if ($manage == 1 and $logos == 1){
?>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div style="order: 3;">
	  <a class="navbar-brand" href="index.php">
	    مؤسسة المدينة للتنمية
	    <img src="images/new.bmp" width="45" height="45" class="d-inline-block align-top" alt="" style="margin-top: -12.5px;">
	  </a>
	</div>
  	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
	      <li class="nav-item">
	      	<button class="saveout" onclick="logout();" style="margin-top: 7.5px; width: 120px; margin-top: 0;">تسجيل الخروج <i class="fas fa-sign-out-alt"></i></button>
	      </li>
	      <?php if ($manage == 1){ ?>
	      <li class="nav-item active">
	        <a class="nav-link" href="manage.php">الادارة العامة</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($money == 1){ ?>
	      <li class="nav-item">
	        <a class="nav-link" href="finance.php">المالية</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($call == 1){ ?>
	      <li class="nav-item">
	        <a class="nav-link" href="call.php">الدعوة</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($learn == 1){ ?>
	      <li class="nav-item">
	        <a class="nav-link" href="learn.php">التعليم</a>
	      </li>
	  	  <?php } ?>
	  	  <li class="nav-item">
	        <a class="nav-link" href="index.php">الصفحة الرئيسية <span class="sr-only">(current)</span></a>
	      </li>
	    </ul>
	  </div>
	</nav>

</head>
<body class="right1">
<?php if (isset($_SESSION['message'])):
?>
<div class="alert alert-<?=$_SESSION['msg_type']?>">
	<?php 
echo $_SESSION['message'];
unset($_SESSION['message']);
if ($_SESSION['msg_type'] == "success"){
	?>
<i class="fas fa-check i2"></i>
<?php }else{?>
	<i class="fas fa-exclamation i2"></i>
<?php } endif ?>
</div>
<br>
<?php
	$result = $conn->query("SELECT * FROM pictures WHERE ID=1") or die($conn->error());
	$result1 = $conn->query("SELECT * FROM pictures WHERE ID=2") or die($conn->error());
?>

<div class="container">
<div class="row justify-content-center">
	<?php  $row = $result->fetch_assoc();
	 $row1 = $result1->fetch_assoc();?>
	 	<div class="div1">
		<img src="<?php echo $row['p_source']; ?>" class="img1">
		<br>
		<?php if ($edit == 1){ ?>
		<button data-toggle="modal" data-target="#mymodel" class="btn btn-info bt11">تغيير الشعار</button>
		<?php } ?>
		</div>
		<div class="div2">
		<img src="<?php echo $row1['p_source']; ?>" class="img1">
		<br>
		<?php if ($edit == 1){ ?>
		<button data-toggle="modal" data-target="#mymodel1" class="btn btn-info bt11">تغيير الشعار</button>
		<?php } ?>
		</div>

</div>
		<br>
		<p style="font-size: 20px; color: red;">: تنويه</p>
		<p style="font-size: 20px; color: red;">.png لابد ان ان يكون رابط الصورة ينهي بامتداد الصور على سبيل المثال </p>
</div>
<form action="php/logos_proccess.php" method="POST">
<div id="mymodel1" class="modal fade right1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="justify-content-between">
				<button type="button" class="close" data-dismiss="modal" style="float: left;">&times;</button>
				</div>
				<h3 class="modal-title">تغيير شعار التقرير</h3>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id" value="2">
				<input type="text" name="newurl" autocomplete="off"> :رابط الصورة  
				<br>
			</div>
			<div class="modal-footer justify-content-between">
			<button type="submit" class="save" name="update">تحديث  <i class="fas fa-sync-alt save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>
</form>
<form action="php/logos_proccess.php" method="POST">
<div id="mymodel" class="modal fade right1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="justify-content-between">
				<button type="button" class="close" data-dismiss="modal" style="float: left;">&times;</button>
				</div>
				<h3 class="modal-title">تغيير شعار التقرير</h3>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id" value="1">
				<input type="text" name="newurl" autocomplete="off"> :رابط الصورة  
				<br>
			</div>
			<div class="modal-footer justify-content-between">
			<button type="submit" class="save" name="update">تحديث  <i class="fas fa-sync-alt save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>
</form>
</body>
</html>
<?php 
}else{ ?>
<br>
<p style="font-size: 25px; color: red; font-weight: bold; text-align: center;">لاتوجد لديك صلاحية للوصول لهذه الصفحة</p>
<div style="text-align: center;">
<a href="index.php">الصفحة الرئيسية</a>
</div>
<?php }
}else{
	header("Location: login.php");
} ?>