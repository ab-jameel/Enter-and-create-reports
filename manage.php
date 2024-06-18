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
			width: 150px;
			text-align: center;
		}

		.a1{
			font-size: 20px;
			margin-right: 60px;
			margin-bottom: 10px;
		}

		.margin2{
			margin-top: 15px;
		}
	</style>

	<title>الادارة العامة</title>
<?php 
session_start();
if (isset($_SESSION['id'])){
require_once'connect.php';
require_once'php/premissions.php';
if ($manage == 1){
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
<body>
<div class="container">
<div class="row justify-content-end a1">
<p>الادارة</p>
</div>
<div class="row justify-content-center">
	<?php if ($balances == 1){ ?>
	<a class="btn btn-success margin" href="balances.php">الارصدة الافتتاحية</a>
	<?php } ?>
	<?php if ($comparison == 1){ ?>
	<a class="btn btn-success margin" href="comparison.php">الموازنات</a>
	<?php } ?>
	<?php if ($groups == 1){ ?>
	<a class="btn btn-success margin" href="groups.php">الفرق</a>
	<?php } ?>
	<?php if ($marakez == 1){ ?>
	<a class="btn btn-success margin" href="marakez.php">المراكز</a>
	<?php } ?>
	<?php if ($exchange == 1){ ?>
	<a class="btn btn-success margin" href="exchange.php">اسعار الصرف</a>
	<?php } ?>
	<?php if ($logos == 1){ ?>
	<a class="btn btn-success margin" href="logos.php">شعارات التقارير</a>
	<?php } ?>
</div>
<br>
<div class="row justify-content-center">
	<?php if ($users == 1){ ?>
	<a class="btn btn-success margin" href="users.php">المستخدمين</a>
	<?php } ?>
	<?php if ($eitems == 1){ ?>
	<a class="btn btn-success margin" href="eitems.php">بنود مصروفات المراكز</a>
	<?php } ?>
	<?php if ($ritems == 1){ ?>
	<a class="btn btn-success margin" href="ritems.php">بنود المصروفات التشغيلية</a>
	<?php } ?>
	<?php if ($sitems == 1){ ?>
	<a class="btn btn-success margin" href="sitems.php">بنود الرواتب</a>
	<?php } ?>
	<?php if ($info == 1){ ?>
	<a class="btn btn-success margin" href="info.php">بيانات الموازنات</a>
	<?php } ?>
	<?php if ($items == 1){ ?>
	<a class="btn btn-success margin" href="items.php">مواد نصيب الفرد</a>
	<?php } ?>
</div>
<br>
<br>
<br>
<br>
<div class="row justify-content-center">
<?php if ($rok == 1 or $reports == 1){ ?>
<div class="col">
<div class="right1">
	<p class="a1" style="margin-bottom: 0;">التقارير</p>
	<?php if ($rok == 1){ ?>
	<a class="btn btn-success margin margin2" href="rok.php">اعتماد التقارير</a>
	<br>
	<?php } ?>
	<?php if ($reports == 1){ ?>
	<a class="btn btn-success margin margin2" href="reports.php">التقارير</a>
	<br>
	<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($money == 1){ ?>
<div class="col">
<div class="right1">
	<a href="finance.php" class="a1">المالية</a>
	<br>
	<?php if ($incomes == 1){ ?>
	<a class="btn btn-success margin margin2" href="incomes.php">ادخال الواردات والايرادات</a>
	<br>
	<?php } ?>
	<?php if ($debts == 1){ ?>
	<a class="btn btn-success margin margin2" href="debts.php">ادخال سداد المديونيات</a>
	<br>
	<?php } ?>
	<?php if ($cash == 1){ ?>
	<a class="btn btn-success margin margin2" href="cash.php">ادخال صرف العملة</a>
	<br>
	<?php } ?>
	<?php if ($expensesr == 1){ ?>
	<a class="btn btn-success margin margin2" href="expensesr.php">ادخال المصروفات التشغيلية</a>
	<br>
	<?php } ?>
	<?php if ($expenses == 1){ ?>
	<a class="btn btn-success margin margin2" href="expenses.php">ادخال المصروفات العامة</a>
	<br>
	<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($call == 1){ ?>
<div class="col">
<div class="right1">
	<a href="call.php" class="a1">الدعوة</a>
	<br>
	<?php if ($minfo == 1){ ?>
	<a class="btn btn-success margin margin2" href="minfo.php">ادخال المصروفات للدعوة</a>
	<br>
	<?php } ?>
	<?php if ($rprograms == 1){ ?>
	<a class="btn btn-success margin margin2" href="rprograms.php">ادخال الحركة الميدانية</a>
	<br>
	<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($learn == 1){ ?>
<div class="col">
<div class="right1">
	<a href="learn.php" class="a1">التعليم</a>
	<br>
	<?php if ($countc == 1){ ?>
	<a class="btn btn-success margin margin2" href="countc.php">ادخال اعداد المهتدين</a>
	<br>
	<?php } ?>
	<?php if ($salary == 1){ ?>
	<a class="btn btn-success margin margin2" href="salary.php">ادخال مسيرات الرواتب</a>
	<br>
	<?php } ?>
	<?php if ($expensesm == 1){ ?>
	<a class="btn btn-success margin margin2" href="expensesm.php">ادخال مصروفات المراكز</a>
	<br>
	<?php } ?>
	<?php if ($portion == 1){ ?>
	<a class="btn btn-success margin margin2" href="portion.php">ادخال نصيب الفرد</a>
	<br>
	<?php } ?>
</div>
</div>
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