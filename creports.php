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
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/jquery-3.5.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/logout.js"></script>
	<script src="https://kit.fontawesome.com/9acd051564.js" crossorigin="anonymous"></script>
	<link rel="icon" type="image/png" href="images/new.bmp"/>

    <style type="text/css">
	.i1{
		font-size: 15px;
	}

	.sel1{
		width: 300px;
		text-align: right;
		margin-top: 15px;
		margin-bottom: 25px;
		font-size: 15px;
	}
    </style>
	<title>تقارير الدعوة</title>
<?php 
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

if ($call == 1 and $creports == 1){

$result2 = $conn->query("SELECT premissions.*, pages.p_name FROM premissions INNER JOIN pages ON premissions.p_page = pages.ID WHERE p_user=$id AND premissions.p_manage = 2") or die($conn->error());
while ($row2 = $result2->fetch_assoc()) {
if ($row2['p_name'] == 'مصروفات الدعوة'){
$minfo = $row2['p_pdf'];
}
if ($row2['p_name'] == 'الحركة الميدانية'){
$rprograms = $row2['p_pdf'];
}
}

?>

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
<br>

<?php 
$result1 = $conn->query("SELECT MAX(k_year) as k_year FROM rok WHERE k_type=1") or die($conn->error());
if (empty($result1)) {
$the_year = '';
$result = $conn->query("SELECT * FROM rok WHERE k_type=1") or die($conn->error());
}else{
$row1 = $result1->fetch_assoc();
$the_year = $row1['k_year'];
$result = $conn->query("SELECT rok.*, treports.t_name, report_months.m_name FROM rok INNER JOIN treports ON rok.r_type = treports.ID INNER JOIN report_months ON k_month = report_months.ID WHERE k_type=1 AND k_year='".$the_year."' AND (r_type = 1 or r_type = 2) ORDER BY k_year ASC, k_month ASC, r_type ASC") or die($conn->error());
} ?>


<div class="container">

<div class="row justify-content-center">

<table class="table right1" id="table1">
	<thead class="thead1">
			<th class="right1">الاجراءات</th>
			<th class="right1">الحالة</th>
			<th class="right1">نوع التقرير</th>
			<th class="right1">الشهر</th>
			<th class="right1">العام</th>
	</thead>
	<?php while ($row = $result->fetch_assoc()) {?>
	<tr class="me">
		<td>
		<?php 
		if ($row['r_type'] == 1 and $rprograms == 1){?>
			<a href="maidan.php?m=<?php echo $row['k_month']; ?>&y=<?php echo $row['k_year']; ?>" target="_blank"><i class="far fa-file-pdf i1"></i></a>
		<?php
		}elseif ($row['r_type'] == 2 and $minfo == 1){?>
			<a href="money.php?m=<?php echo $row['k_month']; ?>&y=<?php echo $row['k_year']; ?>" target="_blank"><i class="far fa-file-pdf i1"></i></a>
		<?php } ?>
		</td>
		<td>معتمد</td>
		<td><?php echo $row['t_name']; ?></td>
		<td><?php echo $row['m_name']; ?></td>
		<td><?php echo $row['k_year']; ?></td>
	</tr>
<?php } ?>
</table>
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