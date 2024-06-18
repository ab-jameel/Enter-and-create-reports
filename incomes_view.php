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

	<?php
	session_start();
	if (isset($_SESSION['id'])){
	$username1 = $_SESSION['kusername'];
	$email1 = $_SESSION['kemail'];
	$id = $_SESSION['id'];
	require_once'connect.php';
	require_once'php/premissions.php';

	$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 19") or die($conn->error());
	$row1 = $result1->fetch_assoc();
	$report = $row1['p_pdf'];

	if ($report == 1){
	if (isset($_GET['y'])){
		$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
		$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
		$result1 =  $conn->query("SELECT SUM(i_amount) as d_total FROM incomes WHERE YEAR(i_date)='".$_GET['y']."' AND i_currency = 'دولار'") or die($conn->error());
		$result2 = $conn->query("SELECT SUM(i_amount) as s_total FROM incomes WHERE YEAR(i_date)='".$_GET['y']."' AND i_currency = 'شلن'") or die($conn->error());
		$result3 = $conn->query("SELECT * FROM exchange WHERE e_month=1 AND e_year='".$_GET['y']."'") or die($conn->error());

	$num3 = mysqli_num_rows($result3);
	?>


	<title>تقرير الايرادات</title>

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

<style type="text/css">
	*{
		text-align: center;
		font-weight: bold;
	}

	tr {
		border-bottom: 1px solid lightgray;
	}
</style>

</head>
<body>
<?php
if ($num3 > 0){

$row1 = $result1->fetch_assoc();
if (empty($row1['d_total'])){
	$dollar_total = 0;
}else{
	$dollar_total = $row1['d_total'];
}


$row2 = $result2->fetch_assoc();
if (empty($row2['s_total'])){
	$shil_total = 0;
}else{
	$shil_total = $row2['s_total'];
}

	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	$row3 = $result3->fetch_assoc();

	$exchange = $row3['e_price'];
	$t_shil = $shil_total / $exchange;
	$total = $t_shil + $dollar_total;

?>
<div class="container">
<div style="margin-right: 125px;">
	<p class="right1" style="font-size: 17.5px;">مركز الدعوة الاسلامي</p>
	<p class="right1" style="font-size: 17.5px;">تقرير الايرادات</p>
	<p class="right1" style="font-size: 17.5px;">لعام <?php echo $_GET['y']; ?></p>
</div>
<img src="<?php echo $tp1['p_source']; ?>" width="100" height="100" style="display: block; margin-top: -112.5px; float: right;">
<div style="display: block; margin-top: -100px; float: left; margin-left: 50px;">
	<p class="right1" style="margin-right: 40px; margin-top: 10px; font-size: 15px;"> اعداد واشراف</p>
	<img src="<?php echo $tp11['p_source']; ?>" width="150" height="50">
</div>
<br>

<table class="table">
	<tr>
		<td class="hst" style="border-left-color: black;">المجموع بالدولار</td>
		<td class="hst">شلن</td>
		<td class="hst">دولار</td>
		<td class="hst">سعر الصرف</td>
		<td class="hst" rowspan="2" style="border-bottom-color: black; vertical-align: middle;">حركة الايرادات</td>
	</tr>
	<tr>
		<td class="dst"><?php echo number_format($total); ?></td>
		<td class="dst"><?php echo number_format($shil_total); ?></td>
		<td class="dst"><?php echo number_format($dollar_total); ?></td>
		<td class="dst"><?php echo number_format($exchange); ?></td>
	</tr>
</table>
<br>
<?php
$result1 =  $conn->query("SELECT * FROM incomes WHERE YEAR(i_date)='".$_GET['y']."' ORDER BY i_date ASC") or die($conn->error());
$n = 1;
?>
<table class="table">
	<tr class="th4">
		<td class="c230">رقم سند القبض</td>
		<td class="c230">ما يعادل بالدولار</td>
		<td class="c230">مبلغ الايراد</td>
		<td class="c230">العملة</td>
		<td class="c230">البيان</td>
		<td class="c230">التاريخ</td>
		<td class="c230">الرقم</td>
	</tr>
	<?php while ($row = $result1->fetch_assoc()){ ?>
		<tr>
			<td><?php echo $row['i_number']; ?></td>
			<?php if ($row['i_currency'] == 'شلن'){ ?>
				<td><?php echo number_format($row['i_amount'] / $exchange); ?></td>
			<?php }else{ ?>
				<td></td>
			<?php } ?>
			<td><?php echo number_format($row['i_amount']); ?></td>
			<td><?php echo $row['i_currency']; ?></td>
			<td>دفعة مستلمة</td>
			<td><?php echo $row['i_date']; ?></td>
			<td><?php echo $n; ?></td>
		</tr>
	<?php $n = $n + 1; } ?>
</table>

<div class="col col-sm-3">
	<div class="form-group">
		<a href="incomes_report.php?y=<?php echo $_GET['y']; ?>" class="cancel" target="_blank">طباعة</a>
		<a href="freports.php" class="cancel">رجوع</a>
	</div>
</div>
<br>
<br>
</div>
</body>
</html>
<?php }else{ ?>
<p style="font-size: 25px; color: red; font-weight: bold; text-align: center;">الرجاء اكمال بيانات التقرير</p>
<?php }}}else{ ?>
<br>
<p style="font-size: 25px; color: red; font-weight: bold; text-align: center;">لاتوجد لديك صلاحية للوصول لهذه الصفحة</p>
<div style="text-align: center;">
<a href="index.php">الصفحة الرئيسية</a>
</div>
<?php }
}else{
	header("Location: login.php");
} ?>