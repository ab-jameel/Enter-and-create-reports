<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap3.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="css/key.css">
	<script src="js/jquery-3.4.1.slim.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/logout.js"></script>
	<script src="https://kit.fontawesome.com/9acd051564.js" crossorigin="anonymous"></script>
	<link rel="icon" type="image/png" href="images/new.bmp"/>

	<title>اعتماد تقارير الدعوة</title>
<?php 
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

if ($call == 1 and $crok == 1){
if (isset($_GET['update'])){
	$id = $_GET['update'];
	$username11 = $_GET['username11'];
	$email11 = $_GET['email11'];
	date_default_timezone_set("Asia/Riyadh");
	$time11 = date("Y-m-d H:i:s"); 
	$conn->query("UPDATE rok SET k_type=1, k_person='".$username11."', k_email='".$email11."', k_time='".$time11."' WHERE ID=$id") or die($conn->error());
	header('Location:http://localhost/khma/crok.php');
} ?>
<style type="text/css">
	.save{
		padding: 5px;
		padding-left: 15px;
		margin-right: 10px;
	}

	.save:hover{
		text-decoration: none;
	}
</style>

	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
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
	      	<button class="saveout" onclick="logout();" style="margin-top: 7.5px;">تسجيل الخروج <i class="fas fa-sign-out-alt"></i></button>
	      </li>
	      <?php if ($manage == 1){ ?>
	      <li class="nav-item">
	        <a class="nav-link" href="manage.php">الادارة العامة</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($money == 1){ ?>
	      <li class="nav-item">
	        <a class="nav-link" href="finance.php">المالية</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($call == 1){ ?>
	      <li class="nav-item active">
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
<?php
if (isset($_SESSION['message'])):
?>
<div class="alert alert-<?=$_SESSION['msg_type']?>">
<?php 
echo $_SESSION['message'];
unset($_SESSION['message']);
if ($_SESSION['msg_type'] == "success"){
?>
<i class="fas fa-check i2"></i>
<?php } endif ?>
</div>
<?php
$result = $conn->query("SELECT rok.*, treports.ID as ID2, treports.t_name as t_name FROM rok INNER JOIN treports ON rok.r_type = treports.ID WHERE k_type=0 AND (r_type = 1 or r_type = 2) ORDER BY k_year ASC, r_type ASC, k_month ASC") or die($conn->error());
?>
<br>
<form action="rok.php" method="POST">
<div class="container">
<div class="row justify-content-center">
<table class="table right1">
		<thead class="thead1">
		<tr>
		<th class="right1">اجراءات</th>
		<th class="right1">الحالة</th>
		<th class="right1">نوع التقرير</th>
		<th class="right1">الشهر</th>
		<th class="right1">السنة</th>
		</tr>
	</thead>
		<?php while ($row = $result->fetch_array()) { 
			  $result2 = $conn->query("SELECT * FROM months WHERE ID=".$row['k_month']) or die($conn->error());
			  $row2 = $result2->fetch_assoc();?>
	<tr>
		<td>
		<?php 
		if ($row['r_type'] == 1){?>
		<a href="rprograms.php?edit=<?php echo $row['k_year']; ?>&edit2=<?php echo $row['k_month']; ?>&r=0"><i class="fas fa-pencil-alt i1"></i></a>
		<?php }elseif ($row['r_type'] == 2){?>
		<a href="minfo.php?edit=<?php echo $row['k_year']; ?>&edit2=<?php echo $row['k_month']; ?>&r=0"><i class="fas fa-pencil-alt i1"></i></a>
		<?php } ?>
		</td>
		<td>غير معتمد</td>
		<td><?php echo $row['t_name'] ?></td>
		<td><?php echo $row2['m_name']; ?></td>
		<td><?php echo $row['k_year']; ?></td>
	</tr>
<?php } ?>
</table>
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