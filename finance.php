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

	<style type="text/css">
		.margin{
			margin-left: 20px;
		}
	</style>

	<title>المالية</title>
<?php 
session_start();
if (isset($_SESSION['id'])){
require_once'connect.php';
require_once'php/premissions.php';
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];

if ($money == 1){
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
	      	<button class="saveout" onclick="logout();" style="margin-top: 7.5px;">تسجيل الخروج <i class="fas fa-sign-out-alt"></i></button>
	      </li>
	      <?php if ($manage == 1){ ?>
	      <li class="nav-item">
	        <a class="nav-link" href="manage.php">الادارة العامة</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($money == 1){ ?>
	      <li class="nav-item active">
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
<body>
<div class="container">
<div class="row justify-content-center">
	<?php if ($freports == 1){ ?>
	<a class="btn btn-success" href="freports.php">التقارير</a>
	<?php } ?>
	<?php if ($frok == 1){ ?>
	<a class="btn btn-success margin" href="frok.php">اعتماد التقارير</a>
	<?php } ?>
	<?php if ($incomes == 1){ ?>
	<a class="btn btn-success margin" href="incomes.php">ادخال الواردات والايرادات</a>
	<?php } ?>
	<?php if ($debts == 1){ ?>
	<a class="btn btn-success margin" href="debts.php">ادخال سداد المديونيات</a>
	<?php } ?>
	<?php if ($cash == 1){ ?>
	<a class="btn btn-success margin" href="cash.php">ادخال صرف العملة</a>
	<?php } ?>
	<?php if ($expensesr == 1){ ?>
	<a class="btn btn-success margin" href="expensesr.php">ادخال المصروفات التشغيلية</a>
	<?php } ?>
	<?php if ($expenses == 1){ ?>
	<a class="btn btn-success margin" href="expenses.php">ادخال المصروفات العامة</a>
	<?php } ?>
</div>
</div>
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