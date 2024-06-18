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
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 9") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){
if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=2 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$c1 = mysqli_num_rows($re1);
?>

	<title>التقرير المالي للمراكز الدعوية</title>

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
	if ($c1 > 0){
	$result = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM minfo INNER JOIN marakez ON minfo.m_markaz = marakez.ID WHERE minfo.m_year='".$_GET['y']."' AND minfo.m_month='".$_GET['m']."' ORDER BY ID ASC") or die($conn->error());
$result7 =  $conn->query("SELECT SUM(m_num1) as m_num1, SUM(m_coss1) as m_coss1, SUM(m_coss11) as m_coss11, SUM(m_num2) as m_num2, SUM(m_coss2) as m_coss2, SUM(m_coss22) as m_coss22, SUM(m_num3) as m_num3, SUM(m_coss3) as m_coss3, SUM(m_coss33) as m_coss33, SUM(m_num4) as m_num4, SUM(m_coss4) as m_coss4 FROM minfo WHERE m_month='".$_GET['m']."' AND m_year='".$_GET['y']."'") or die($conn->error());

$result6 = $conn->query("SELECT SUM(c_amount) as c_amount FROM comparison WHERE c_year='".$_GET['y']."' AND c_program LIKE 'المناظرات والمحاضرات' AND c_axis LIKE 'التعريف بالاسلام'") or die($conn->error());

$result8 = $conn->query("SELECT * FROM exchange WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."'") or die($conn->error());

$result12 = $conn->query("SELECT * FROM groups WHERE the_year=".$_GET['y']) or die($conn->error());

$resul2 = $conn->query("SELECT * FROM groups WHERE the_year=".$_GET['y']) or die($conn->error());

$row7 = $result7->fetch_assoc();
$row6 = $result6->fetch_assoc();
$row8 = $result8->fetch_assoc();
$num1 = mysqli_num_rows($result12);
$num2 = mysqli_num_rows($result);
$num3 = mysqli_num_rows($resul2);
if ($num2 > 0 and $num3 > 0){
if ($row7['m_coss4'] > 0){
	$m_num4 = 1;
}else{
	$m_num4 = 0;
}

$m_coss3 = $row7['m_coss3'];
if ($row7['m_num3'] > 0){
$sum5 = $row7['m_coss3'] / $row7['m_num3'];
}else{
$sum5 = 0;
}
$sum1 = $row7['m_num1'] + $row7['m_num2'];
if ($row7['m_num1'] > 0){
$sum3 = $row7['m_coss11'] / $row7['m_num1'];
}else{
$sum3 = 0;
}
if ($row7['m_num2'] > 0){
$sum4 = $row7['m_coss22'] / $row7['m_num2'];
}else{
$sum4 = 0;
}
$sum2 = $row7['m_coss11'] + $row7['m_coss22'] + $row7['m_coss3'] + $row7['m_coss4'];
$sum6 = $m_num4 * $row7['m_coss4'];
if ($sum1 > 0){
$sum7 = $sum2 / $sum1;
}else{
$sum7 = 0;
}
if ($row8['e_price'] > 0){
$real = $sum2 / $row8['e_price'];
}else{
$real = 0;
}

$m_num1 = number_format($row7['m_num1']);
$m_num2 = number_format($row7['m_num2']);
$m_num3 = number_format($row7['m_num3']);
$m_coss4 = number_format($row7['m_coss4']);

$real2 = number_format($real, 0, '.', ',');
$dif = $row6['c_amount']/12;
if ($num1 > 0){
$egroup = $dif / $num1;
}else{
$egroup = 0;
}
if ($dif > 0){
$final = $real / $dif;
}else{
$final = 0;
}
$final = $final * 100;
$final3 = $final / 2;
if ($real > 0){
$dif2 = $dif / $real;
}else{
$dif2 = 0;
}
$dif2 = $dif2 * 100;
$dif2 = $dif2 / 2;
$final2 = number_format($final, 0, '.', '');

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
	<p class="right1" style="font-size: 17.5px;">التقرير المالي</p>
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
<br>

    <script type="text/javascript">
	    google.charts.load("current", {packages:["corechart"]});
	    google.charts.setOnLoadCallback(drawChart);
	    function drawChart() {
	        var data = google.visualization.arrayToDataTable([
	        ['المقارنة', 'النسبة '],
	        ['الصرف الفعلي بالدولار', <?php echo $final3; ?>],
	        ['الموازنة الشهرية', <?php echo $dif2; ?>]
        ]);

        var options = {
          title: 'مقارنة الصرف الفعلي بالموازنة',
          pieHole: 0.4,
          pieSliceText: 'none',
          chartArea: {width:'100%'},
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>

<?php if ($final3 > 0){ ?>
<div style="width: 50%;">
	<div id="donutchart" align="center"></div>
</div>
<?php } ?>
<?php
	if ($final >= 100){
	$text = "فوق الموازنة";
	}else{
	$text = "تحت الموازنة";
	}
?>
<table class="table">
	<tr>
		<td class="hst" style="border-left-color: black;">الحركة</td>
		<td class="hst">نسبة الصرف</td>
		<td class="hst">الموازنة الشهرية</td>
		<td class="hst">الصرف الفعلي بالدولار</td>
		<td class="hst">سعر الصرف</td>
		<td class="hst">المجموع بالشلن</td>
		<td class="hst">موازنة الفرقة</td>
		<td class="hst" rowspan="2" style="vertical-align: middle; border-bottom-color: black;">الحركة الشهرية</td>
	</tr>
	<tr>
		<?php if ($final >= 100){ ?>
			<td class="dst" style="background-color: rgb(255,180,185);">
		<?php }else{ ?>
			<td class="dst" style="background-color: rgb(185,255,185);">
		<?php } ?>
		<?php echo $text; ?></td>
		<td class="dst"><?php echo $final2.' %'; ?></td>
		<td class="dst"><?php echo number_format($dif); ?></td>
		<td class="dst"><?php echo $real2; ?></td>
		<td class="dst"><?php echo number_format($row8['e_price']); ?></td>
		<td class="dst"><?php echo number_format($sum2); ?></td>
		<td class="dst"><?php echo number_format($egroup); ?></td>
	</tr>
</table>

<table class="table">
	<thead>
		<th><?php echo 'عدد الفرق '.$num1; ?></th>
		<th class="right1" colspan="5" style="font-size: 17.5px;">الاجمالي</th>
	</thead>
	<thead class="th5">
		<th class="cen2">المجموع الكلي</th>
		<th class="cen2">ميكروفونات وصيانة</th>
		<th class="cen2">تغذية الدعاة وتنقلهم</th>
		<th class="cen2">دعاة 2</th>
		<th class="cen2">دعاة 1</th>
		<th class="cen2">البند</th>
	</thead>
	<tr>
		<td><?php echo number_format($sum1); ?></td>
		<td><?php echo $m_num4; ?></td>
		<td><?php echo $m_num3; ?></td>
		<td><?php echo $m_num2; ?></td>
		<td><?php echo $m_num1; ?></td>
		<td class="c240">العدد</td>
	</tr>
	<tr>
		<td><?php echo number_format($sum7); ?></td>
		<td><?php echo number_format($sum6); ?></td>
		<td><?php echo number_format($sum5); ?></td>
		<td><?php echo number_format($sum4); ?></td>
		<td><?php echo number_format($sum3); ?></td>
		<td class="c240">التكلفة الفردية</td>
	</tr>
	<tr style="border-bottom: 2px solid black;">
		<td><?php echo number_format($sum2); ?></td>
		<td><?php echo $m_coss4; ?></td>
		<td><?php echo number_format($m_coss3); ?></td>
		<td><?php echo number_format($row7['m_coss22']); ?></td>
		<td><?php echo number_format($row7['m_coss11']); ?></td>
		<td class="c240">التكلفة الشهرية</td>
	</tr>
</table>

<?php
while ($row = $result->fetch_assoc()){
$result2 = $conn->query("SELECT * FROM minfo WHERE m_month='".$_GET['m']."' AND m_year='".$_GET['y']."' AND m_markaz='".$row['ID']."'") or die($conn->error());
$result15 = $conn->query("SELECT * FROM groups WHERE the_year='".$_GET['y']."' AND markaz_name='".$row['ID']."'") or die($conn->error());
$result20 = $conn->query("SELECT * FROM comparison WHERE c_year='".$_GET['y']."' AND c_program LIKE 'المناظرات والمحاضرات' AND c_axis LIKE 'التعريف بالاسلام' AND c_markaz='".$row['ID']."'");
$num4 = mysqli_num_rows($result15);
$row2 = $result2->fetch_assoc();
$row20 = $result20->fetch_assoc();

$m_num11 = number_format($row2['m_num1']);
$m_num21 = number_format($row2['m_num2']);
$m_num31 = number_format($row2['m_num3']);
$m_coss11 = number_format($row2['m_coss1']);
$m_coss21 = number_format($row2['m_coss2']);
$m_coss31 = $row2['m_coss3'];
$m_num41 = number_format($row2['m_num4']);
$m_coss41 = number_format($row2['m_coss4']);

if ($row2['m_num3'] > 0){
$sum51 = $row2['m_coss3'] / $row2['m_num3'];
}else{
$sum51 = 0;
}
$sum11 = $row2['m_num1'] + $row2['m_num2'];
$sum31 = $row2['m_num1'] * $row2['m_coss1'];
$sum41 = $row2['m_num2'] * $row2['m_coss2'];
$sum61 = $m_num41 * $row2['m_coss4'];
$sum71 = $sum31 + $sum41 + $m_coss31 + $sum61;
if ($sum11 > 0){
$sum21 = $sum71 / $sum11;
}else{
$sum21 = 0;
}
if ($row8['e_price'] > 0){
$real1 = $sum71 / $row8['e_price'];
}else{
$real1 = 0;
}
$real21 = number_format($real1, 0, '.', ',');
if (mysqli_num_rows($result20) > 0){
$dif1 = $row20['c_amount'] / 12;
}else{
$dif1 = 0;
}
if ($dif1 > 0){
$final1 = $real1 / $dif1;
}else{
$final1 = 0;
}
$final1 = $final1 * 100;
$final21 = number_format($final1, 0, '.', '');
?>
<table class="table">
	<thead>
		<th><?php echo 'عدد الفرق '.$num4; ?></th>
		<th class="right1" colspan="7" style="font-size: 17.5px;"><?php echo $row['mname']; ?></th>
	</thead>
	<thead class="th5">
		<th colspan="2" class="cen2">المجموع الكلي</th>
		<th class="cen2">ميكروفونات وصيانة</th>
		<th class="cen2">تغذية الدعاة وتنقلهم</th>
		<th class="cen2">دعاة 2</th>
		<th class="cen2">دعاة 1</th>
		<th colspan="2" class="cen2">البند</th>
	</thead>
	<tr>
		<td colspan="2"><?php echo number_format($sum11); ?></td>
		<td><?php echo $m_num41; ?></td>
		<td><?php echo $m_num31; ?></td>
		<td><?php echo $m_num21; ?></td>
		<td><?php echo $m_num11; ?></td>
		<td colspan="2" class="c240">العدد</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo number_format($sum21); ?></td>
		<td><?php echo $m_coss41; ?></td>
		<td><?php echo number_format($sum51); ?></td>
		<td><?php echo $m_coss21; ?></td>
		<td><?php echo $m_coss11; ?></td>
		<td colspan="2" class="c240">التكلفة الفردية</td>
	</tr>
	<tr style="border-bottom: 2px solid black;">
		<td colspan="2"><?php echo number_format($sum71); ?></td>
		<td><?php echo number_format($sum61); ?></td>
		<td><?php echo number_format($m_coss31); ?></td>
		<td><?php echo number_format($sum41); ?></td>
		<td><?php echo number_format($sum31); ?></td>
		<td colspan="2" class="c240">التكلفة الشهرية</td>
	</tr>
	<?php
	if ($final1 >= 100){
	$text = "فوق الموازنة";
	}else{
	$text = "تحت الموازنة";
	}
	?>
	<tr class="th4">
		<?php if ($final1 >= 100){ ?>
			<td style="background-color: rgb(255,180,185);">
		<?php }else{ ?>
			<td style="background-color: rgb(185,255,185);">
		<?php }	?>
		<?php echo $text; ?></td>
		<td class="c240">الحركة</td>
		<td><?php echo $final21.' %'; ?></td>
		<td class="c240">نسبة الصرف</td>
		<td><?php echo '$ '.$real21; ?></td>
		<td class="c240">المصروف بالدولار</td>
		<td><?php echo '$ '.number_format($dif1); ?></td>
		<td class="c240">الموازنة الشهرية</td>
	</tr>
</table>
<?php } ?>
<div class="col col-sm-3">
	<div class="form-group">
		<a href="money.php?y=<?php echo $_GET['y']; ?>&m=<?php echo $_GET['m']; ?>" class="cancel" target="_blank">طباعة</a>
		<a href="minfo_main.php" class="cancel">رجوع</a>
	</div>
</div>
<br>
<br>
</div>
</body>
</html>
<?php }}else{ ?>
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