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

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 4") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){
if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=3 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$result = $conn->query("SELECT DISTINCT marakez.mname, marakez.ID FROM portions INNER JOIN marakez ON marakez.ID = portions.p_markaz WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY ID ASC") or die($conn->error());
	$result7 =  $conn->query("SELECT * FROM portions WHERE p_month='".$_GET['m']."' AND p_year='".$_GET['y']."'") or die($conn->error());
	$result8 = $conn->query("SELECT DISTINCT items.id, items.i_name FROM portions INNER JOIN items ON portions.p_item = items.id WHERE p_year='".$_GET['y']."' AND p_month='".$_GET['m']."' ORDER BY portions.ID DESC") or die($conn->error());
	$result3 = $conn->query("SELECT * FROM countc WHERE c_year='".$_GET['y']."' AND c_month='".$_GET['m']."'") or die($conn->error());


	$num1 = mysqli_num_rows($re1);
	$num2 = mysqli_num_rows($result);
	$num3 = mysqli_num_rows($result7);
	$num4 = mysqli_num_rows($result3);
	$num8 = mysqli_num_rows($result8);
	if ($num8 > 0){
	$wid =  130 / $num8;
	}else{
	$wid = 0;
	}
?>

	<title>تقرير نصيب الفرد</title>

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
<?php
if ($num1 > 0 and $num2 > 0 and $num3 > 0 and $num4 > 0){

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
<div class="container">
<div style="margin-right: 125px;">
	<p class="right1" style="font-size: 17.5px;">مركز الدعوة الاسلامي</p>
	<p class="right1" style="font-size: 17.5px;">تقرير نصيب الفرد</p>
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
	<thead class="th5">
		<th class="cen2 c240">المجموع</th>
		<?php while ($row8 = $result8->fetch_assoc()){ ?>
			<th class="cen2"><?php echo $row8['i_name']; ?></th>
		<?php } ?>
		<th class="cen2">البند</th>
		<th class="cen2">المركز</th>
	</thead>
	<?php while ($row = $result->fetch_assoc()){
		$result6 = $conn->query("SELECT portions.p_quantity FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	?>
	<tr style="border-top: 2px solid black;">
		<td class="c240"></td>
		<?php while ($row6 = $result6->fetch_assoc()){ ?>
			<td><?php echo number_format($row6['p_quantity']); ?></td>
		<?php } ?>
		<td>الكمية</td>
		<td class="c240" rowspan="3" style="vertical-align: middle;"><?php echo $row['mname']; ?></td>
	</tr>
	<?php
	$result6 = $conn->query("SELECT p_price / p_quantity as p_average FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	?>
	<tr>
		<td class="c240"></td>
		<?php while ($row6 = $result6->fetch_assoc()){ ?>
			<td><?php echo number_format($row6['p_average']); ?></td>
		<?php } ?>
		<td>سعر الوحدة</td>
	</tr>
	<?php
	$result6 = $conn->query("SELECT p_price FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	$result9 = $conn->query("SELECT SUM(p_price) as price2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	$row9 = $result9->fetch_assoc();
	?>
	<tr>
		<td class="c240"><?php echo number_format($row9['price2']); ?></td>
		<?php while ($row6 = $result6->fetch_assoc()){ ?>
			<td><?php echo number_format($row6['p_price']); ?></td>
		<?php } ?>
		<td>السعر الكامل</td>		
	</tr>
	<?php
	$result5 = $conn->query("SELECT c_learn + c_dev as total FROM countc WHERE c_month='".$_GET['m']."' AND c_year='".$_GET['y']."' AND c_markaz='".$row['ID']."'") or die($conn->error());
	$row5 = $result5->fetch_assoc();
	$result6 = $conn->query("SELECT p_quantity / '".$row5['total']."' as portion2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	?>
	<tr>
		<td class="c240"></td>
		<?php while ($row6 = $result6->fetch_assoc()){ ?>
			<td><?php if ($row6['portion2'] != ''){ echo number_format($row6['portion2'],1); }else{ echo 0; } ?></td>
		<?php } ?>
		<td>نصيب الفرد</td>		
		<td>عدد المستفيدين</td>
	</tr>
	<tr>
		<?php
		if ($row5['total'] > 0){
		$result6 = $conn->query("SELECT p_price / '".$row5['total']."' as portion2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error()); ?>
		<td class="c240"><?php echo number_format($row9['price2'] / $row5['total']); ?></td>
		<?php }else{
		$result6 = $conn->query("SELECT 0 as portion2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error()); ?>
		<td class="c240">0</td>
		<?php } ?>
		<?php while ($row6 = $result6->fetch_assoc()){ ?>
			<td><?php echo number_format($row6['portion2']); ?></td>
		<?php } ?>
		<td>تكلفة الفرد</td>
		<td><?php echo $row5['total']; ?></td>
	</tr>
	<?php } ?>


	<!-- sum table -->
	<?php
	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	?>
	<tr style="border-top: 2px solid black;">
		<td class="c240"></td>
		<?php while ($row6 = $result6->fetch_assoc()){
			$result4 = $conn->query("SELECT SUM(p_quantity) as t_quantity FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
			$row4 = $result4->fetch_assoc();
		?>
			<td><?php echo number_format($row4['t_quantity']); ?></td>
		<?php } ?>
		<td>الكمية</td>
		<td class="c240" rowspan="3" style="vertical-align: middle;">إحصائية جميع المراكز</td>
	</tr>
	<?php
	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	?>
	<tr>
		<td class="c240"></td>
		<?php while ($row6 = $result6->fetch_assoc()){
			$result4 = $conn->query("SELECT SUM(p_price) / SUM(p_quantity) as t_average FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
			$row4 = $result4->fetch_assoc();
		?>
			<td><?php echo number_format($row4['t_average']); ?></td>
		<?php } ?>
		<td>متوسط سعر الوحدة</td>
	</tr>
	<?php
	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$result9 = $conn->query("SELECT SUM(p_price) as t_price2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$row9 = $result9->fetch_assoc();
	?>
	<tr>
		<td class="c240"><?php echo number_format($row9['t_price2']); ?></td>
		<?php while ($row6 = $result6->fetch_assoc()){
			$result4 = $conn->query("SELECT SUM(p_price) as t_price FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
			$row4 = $result4->fetch_assoc();
		?>
			<td><?php echo number_format($row4['t_price']); ?></td>
		<?php } ?>
		<td>السعر الكامل</td>		
	</tr>
	<?php
	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$result5 = $conn->query("SELECT SUM(c_learn + c_dev) as t_total FROM countc WHERE c_month='".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row5 = $result5->fetch_assoc();
	?>
	<tr>
		<td class="c240"></td>
		<?php while ($row6 = $result6->fetch_assoc()){
			$result4 = $conn->query("SELECT SUM(p_quantity) / '".$row5['t_total']."' as t_portion2 FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
			$row4 = $result4->fetch_assoc();
		?>
			<td><?php if ($row4['t_portion2'] != ''){ echo number_format($row4['t_portion2'],1); }else{ echo 0; } ?></td>
		<?php } ?>
		<td>متوسط نصيب الفرد</td>		
		<td>عدد المستفيدين</td>
	</tr>
	<?php
	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	?>
	<tr style="border-bottom: 2px solid black;">
		<?php
		if ($row5['t_total'] > 0){ ?>
		<td class="c240"><?php echo number_format($row9['t_price2'] / $row5['t_total']); ?></td>
		<?php }else{ ?>
		<td class="c240">0</td>
		<?php } ?>
		<?php while ($row6 = $result6->fetch_assoc()){
			$result4 = $conn->query("SELECT SUM(p_price) / '".$row5['t_total']."' as t_portion2 FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
			$row4 = $result4->fetch_assoc();
		?>
			<td><?php echo number_format($row4['t_portion2']); ?></td>
		<?php } ?>
		<td>متوسط تكلفة الفرد</td>
		<td><?php echo $row5['t_total']; ?></td>
	</tr>
</table>
<div class="col col-sm-3">
	<div class="form-group">
		<a href="portion_report.php?y=<?php echo $_GET['y']; ?>&m=<?php echo $_GET['m']; ?>" class="cancel" target="_blank">طباعة</a>
		<a href="portion_main.php" class="cancel">رجوع</a>
	</div>
</div>
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