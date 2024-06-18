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

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 2") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){
if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=4 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$result = $conn->query("SELECT DISTINCT marakez.mname, marakez.ID FROM salary INNER JOIN marakez ON salary.s_markaz = marakez.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' ORDER BY ID ASC") or die($conn->error());
	$result7 =  $conn->query("SELECT SUM(s_every * s_num) as s_monthly FROM salary WHERE s_month='".$_GET['m']."' AND s_year='".$_GET['y']."'") or die($conn->error());
	$result71 =  $conn->query("SELECT * FROM salary WHERE s_month='".$_GET['m']."' AND s_year='".$_GET['y']."'") or die($conn->error());
	$result8 = $conn->query("SELECT * FROM exchange WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."'") or die($conn->error());
	$result81 = $conn->query("SELECT DISTINCT sitems.id FROM salary INNER JOIN sitems ON salary.s_item = sitems.id WHERE s_year='".$_GET['y']."' AND s_month='".$_GET['m']."'") or die($conn->error());


	$num1 = mysqli_num_rows($re1);
	$num2 = mysqli_num_rows($result);
	$num3 = mysqli_num_rows($result71);
	$num4 = mysqli_num_rows($result8);
	$num8 = mysqli_num_rows($result81);
	if ($num8 > 0){
	$wid =  165 / $num8;
	}else{
	$wid = 0;
	}
if ($num1 > 0 and $num2 > 0 and $num3 > 0 and $num4 > 0){

$row7 = $result7->fetch_assoc();
$row8 = $result8->fetch_assoc();

$s_monthly = $row7['s_monthly'];
$exchange = $row8['e_price'];
if ($s_monthly > 0 and $exchange > 0){
$portion = $s_monthly / $exchange;
}else{
$portion = 0;
}

	$tr1 = $t1->fetch_assoc();
	$ro1 = $re1->fetch_assoc();
	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	if($ro1['k_type'] == 1){
		$k_person = $ro1['k_person'];
		$k_email = $ro1['k_email'];
		$k_time = $ro1['k_time'];
	}else{
		$k_person = '';
		$k_email = '';
		$k_time = '';
	}
?>

	<title>تقرير مسير الرواتب</title>

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
	      <li class="nav-item">
	        <a class="nav-link" href="call.php">الدعوة</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($learn == 1){ ?>
	      <li class="nav-item active">
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
<div class="container">
<div style="margin-right: 125px;">
	<p class="right1" style="font-size: 17.5px;">مركز الدعوة الاسلامي</p>
	<p class="right1" style="font-size: 17.5px;">مسير الرواتب</p>
	<p class="right1" style="font-size: 17.5px;"><?php echo $tr1['m_name'].'  '.$ro1['k_year']; ?></p>
</div>
<img src="<?php echo $tp1['p_source']; ?>" width="100" height="100" style="display: block; margin-top: -112.5px; float: right;">
<?php
if($ro1['k_type'] == 1){ 
	$k_type = 'تم الموافقة والاعتماد';
}else{
	$k_type = 'غير معتمد';
}

if($ro1['k_type'] == 1){ 
?>
<div style="display: inline-block; border: 1px solid black; float: right; margin: -100px 450px 40px 0px; padding: 10px 10px 0px 10px;">
	<p class="cen2 small1"><?php echo $k_type; ?></p>
	<p class="cen2 small1"><?php echo $k_person; ?></p>
	<p class="cen2 small1"><?php echo $k_email; ?></p>
	<p class="cen2 small1"><?php echo $k_time; ?></p>
	</div>
	<?php }else{ ?>
	<div style="display: inline-block; float: right; margin: -75px 500px 60px 0px; padding: 10px 10px 0px 10px;">
	<p class="cen2 small1" style="color: red; font-size: 17.5px;"><?php echo $k_type; ?></p>
</div>
<?php } ?>
<div style="display: block; margin-top: -100px; float: left; margin-left: 50px;">
	<p class="right1" style="margin-right: 40px; margin-top: 10px; font-size: 15px;"> اعداد واشراف</p>
	<img src="<?php echo $tp11['p_source']; ?>" width="150" height="50">
</div>
<table class="table">
	<tr>
		<td><?php echo number_format($portion); ?></td>
		<td class="c240">المصروفات بالدولار</td>
		<td><?php echo number_format($exchange); ?></td>
		<td class="c240">سعر الصرف</td>
		<td><?php echo number_format($s_monthly); ?></td>
		<td class="c240">الاجمالي بالشلن</td>
		<td style="background-color: black; color: white;">الحركة الاجمالية الشهرية</td>
	</tr>
</table>
<?php
while ($row = $result->fetch_assoc()){ 
	$result2 = $conn->query("SELECT DISTINCT sitems.i_name FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."' ORDER BY sitems.ID DESC") or die($conn->error());
	$result6 = $conn->query("SELECT SUM(salary.s_every * salary.s_num) as s_monthly, SUM(salary.s_num) as s_num FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."'") or die($conn->error());
	$row6 = $result6->fetch_assoc();
?>
<table class="table">
	<tr>
		<td><?php echo number_format($row6['s_monthly']); ?></td>
		<td class="c230">الاجمالي بالشلن</td>
		<?php if ($exchange > 0){ ?>
			<td><?php echo number_format($row6['s_monthly'] / $exchange); ?></td>
		<?php }else{ ?>
			<td>0</td>
		<?php } ?>
		<td class="c230">الاجمالي بالدولار</td>
		<td><?php echo number_format($row6['s_num']); ?></td>
		<td class="c230">عدد العاملين</td>
		<td colspan="2" style="text-align: right; font-size: 17.5px;"><?php echo $row['mname']; ?></td>
	</tr>
	<tr>
		<?php 
		while ($row2 = $result2->fetch_assoc()){ ?>
			<td><?php echo $row2['i_name']; ?></td>
		<?php } ?>
		<td>البند</td>
	</tr>
	<tr>
		<?php
		$result3 = $conn->query("SELECT salary.s_num FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."' ORDER BY sitems.ID DESC") or die($conn->error());
		while ($row3 = $result3->fetch_assoc()){ ?>
			<td><?php echo number_format($row3['s_num']); ?></td>
		<?php } ?>
		<td class="c230">العدد</td>
	</tr>
	<tr>
		<?php
		$result4 = $conn->query("SELECT salary.s_every FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."' ORDER BY sitems.ID DESC") or die($conn->error());
		while ($row4 = $result4->fetch_assoc()){ ?>
			<td><?php echo number_format($row4['s_every']); ?></td>
		<?php } ?>
		<td class="c230">التكلفة الفردية</td>
	</tr>
	<tr>
		<?php
		$result5 = $conn->query("SELECT salary.s_every,salary.s_num FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."' ORDER BY sitems.ID DESC") or die($conn->error());
		while ($row5 = $result5->fetch_assoc()){ ?>
			<td><?php echo number_format($row5['s_every'] * $row5['s_num']); ?></td>
		<?php } ?>
		<td class="c230">التكلفة الشهرية</td>
	</tr>
</table>
<?php } ?>
<div class="col col-sm-3">
	<div class="form-group">
		<a href="salary_report.php?y=<?php echo $_GET['y']; ?>&m=<?php echo $_GET['m']; ?>" class="cancel" target="_blank">طباعة</a>
		<a href="salary_main.php" class="cancel">رجوع</a>
	</div>
</div>
<br>
</div>
</body>
</html>
<?php 
}}}else{ ?>
<br>
<p style="font-size: 25px; color: red; font-weight: bold; text-align: center;">لاتوجد لديك صلاحية للوصول لهذه الصفحة</p>
<div style="text-align: center;">
<a href="index.php">الصفحة الرئيسية</a>
</div>
<?php }
}else{
	header("Location: login.php");
} ?>