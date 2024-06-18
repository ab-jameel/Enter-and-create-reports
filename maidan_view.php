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

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 10") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){
if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=1 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$re2 = $conn->query("SELECT * FROM rprograms WHERE b_year='".$_GET['y']."' AND b_month='".$_GET['m']."'") or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$c1 = mysqli_num_rows($re1);
	$c2 = mysqli_num_rows($re2);
?>

	<title>التقرير الميداني</title>

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
if ($c1 > 0 and $c2 > 0){

$result = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM rprograms INNER JOIN marakez ON rprograms.b_markaz = marakez.ID WHERE rprograms.b_year='".$_GET['y']."' AND rprograms.b_month='".$_GET['m']."' ORDER BY ID ASC") or die($conn->error());
$result4 = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM rprograms INNER JOIN marakez ON rprograms.b_markaz = marakez.ID WHERE rprograms.b_year='".$_GET['y']."' AND rprograms.b_month='".$_GET['m']."' ORDER BY ID ASC") or die($conn->error());
$num4 = mysqli_num_rows($result4);
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

	$attend = 0;
?>

<div class="container">
<div style="margin-right: 125px;">
	<p class="right1" style="font-size: 17.5px;">مركز الدعوة الاسلامي</p>
	<p class="right1" style="font-size: 17.5px;">التقرير الميداني</p>
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
	        ['المركز', 'نسبة المهتدين'],
	        <?php 
		$result10 = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM rprograms INNER JOIN marakez ON rprograms.b_markaz = marakez.ID WHERE rprograms.b_year='".$_GET['y']."' AND rprograms.b_month='".$_GET['m']."'") or die($conn->error());
		while ($row10 = $result10->fetch_assoc()) {
			$result111 =  $conn->query("SELECT SUM(b_attend) as b_attend, SUM(b_countm) as b_countm FROM rprograms WHERE b_markaz='".$row10['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
			$row111 = $result111->fetch_assoc();
			if(empty($row111['b_attend'])){
				$row111['b_attend'] = 0;
			}
			if(empty($row111['b_countm'])){
				$row111[ 'b_countm'] = 0;
			}
			if ($row111['b_attend'] > 0){
			$n1 = $row111['b_countm'];
			$n2 = $row111['b_attend'];
			$n3 = $n1/$n2;
			$attend = $attend + $n2;
			echo "['".$row10['mname']."',".$n3."],";
			}else{
			echo "['".$row10['mname']."',0],";
			}}
          ?>
        ]);

        var options = {
          title: 'نسبة المهتدين',
          pieHole: 0.4,
          pieSliceText: 'none',
          chartArea: {width:'100%'},
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
		  var loadDaysLeadGraphData = [
		  ['اعداد المهتدين', 'عدد المهتدين'],
          <?php 
			$result10 = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM rprograms INNER JOIN marakez ON rprograms.b_markaz = marakez.ID WHERE rprograms.b_year='".$_GET['y']."' AND rprograms.b_month='".$_GET['m']."'") or die($conn->error());
			while ($row10 = $result10->fetch_array()) {
			$result11 =  $conn->query("SELECT SUM(b_countm) as b_countm FROM rprograms WHERE b_markaz= '".$row10['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
			$row11 = $result11->fetch_assoc();
           echo "['".$row10['mname']."',".$row11['b_countm']."],";
	 	}     
         ?>
  ];

  var data = google.visualization.arrayToDataTable(loadDaysLeadGraphData);
   var options = {
   	title: '',
     hAxis: {
       title: "",
       textPosition: 'out',
       slantedText: false,
    },
    width: '100%',
    vAxis: {
      title: 'اعداد المهتدين',
      titleTextStyle:{
      	bold: true
      },
      minValue: 0,
      viewWindow: { min: 0 },
      format: '0',
    },
    bar:{
    	groupWidth: '42%'
    },
    legend: {
    	position: 'none'
    },
    theme: 'material'
  };
  var chart = new google.visualization.ColumnChart(document.getElementById('top_x_div'));
  chart.draw(data, options);
}
    </script>
<?php if ($attend > 0){ ?>
<div style="float: right; width: 50%;">
	<div id="top_x_div" align="right"></div>
</div>
<div style="float: left; width: 50%;">
	<div id="donutchart" align="left"></div>
</div>
<?php } ?>
<table class="table">
	<thead>
		<th colspan="6" class="right1" style="font-size: 17.5px;">الاجماليات</th>
	</thead>
	<thead>
		<th class="hst cen2">البرامج الاذاعية</th>
		<th class="hst cen2">الخطب</th>
		<th class="hst cen2">المهتدين</th>
		<th class="hst cen2">الحضور التقريبي</th>
		<th class="hst cen2">المناظرات</th>
		<th class="hst right1">المركز</th>
	</thead>
	<?php
	$result7 =  $conn->query("SELECT SUM(b_countr) as b_countr, SUM(b_attend) as b_attend, SUM(b_countm) as b_countm, SUM(b_countk) as b_countk, SUM(b_countt) as b_countt FROM rprograms WHERE b_month='".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());

	while ($row4 = $result4->fetch_assoc()) {
		$res = $conn->query("SELECT * FROM rprograms WHERE b_markaz= '".$row4['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
		if (mysqli_num_rows($res) > 0){
		$result6 =  $conn->query("SELECT SUM(b_countr) as b_countr, SUM(b_attend) as b_attend, SUM(b_countm) as b_countm, SUM(b_countk) as b_countk, SUM(b_countt) as b_countt FROM rprograms WHERE b_markaz= '".$row4['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
		$row6 = $result6->fetch_assoc();
	?>
		<tr>
			<td><?php echo number_format($row6['b_countt']); ?></td>
			<td><?php echo number_format($row6['b_countk']); ?></td>
			<td><?php echo number_format($row6['b_countm']); ?></td>
			<td><?php echo number_format($row6['b_attend']); ?></td>
			<td><?php echo number_format($row6['b_countr']); ?></td>
			<td class="right1"><?php echo $row4['mname']; ?></td>
		</tr>
	<?php }} $row7 = $result7->fetch_assoc(); ?>
	<tr class="th4">
		<td style="font-size: 17px;"><?php echo number_format($row7['b_countt']); ?></td>
		<td style="font-size: 17px;"><?php echo number_format($row7['b_countk']); ?></td>
		<td style="font-size: 17px;"><?php echo number_format($row7['b_countm']); ?></td>
		<td style="font-size: 17px;"><?php echo number_format($row7['b_attend']); ?></td>
		<td style="font-size: 17px;"><?php echo number_format($row7['b_countr']); ?></td>
		<td style="font-size: 17px;">الاجمالي</td>
	</tr>
</table>
<?php while ($row = $result->fetch_assoc()){
	$result2 =  $conn->query("SELECT * FROM rprograms WHERE b_markaz= '".$row['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
	if (mysqli_num_rows($result2) > 0){
?>
<table class="table">
	<thead>
		<th colspan="6" class="right1" style="font-size: 17.5px;"><?php echo $row['mname']; ?></th>
	</thead>
	<thead>
		<th class="cen2 c230">البرامج الاذاعية</th>
		<th class="cen2 c230">الخطب</th>
		<th class="cen2 c230">المهتدين</th>
		<th class="cen2 c230">الحضور التقريبي</th>
		<th class="cen2 c230">المناظرات</th>
		<th class="right1 c230">الفرقة</th>
	</thead>
	<?php
	while ($row2 = $result2->fetch_assoc()) {
		$result3 = $conn->query("SELECT * from groups WHERE ID=".$row2['b_group']) or die($conn->error());
		while ($row3 = $result3->fetch_assoc()) {
	?>
	<tr>
		<td><?php echo number_format($row2['b_countt']); ?></td>
		<td><?php echo number_format($row2['b_countk']); ?></td>
		<td><?php echo number_format($row2['b_countm']); ?></td>
		<td><?php echo number_format($row2['b_attend']); ?></td>
		<td><?php echo number_format($row2['b_countr']); ?></td>
		<td class="right1"><?php echo $row3['group_name']; ?></td>
	</tr>
	<?php }}}} ?>
</table>
<br>
<div class="col col-sm-3">
	<div class="form-group">
		<a href="maidan.php?y=<?php echo $_GET['y']; ?>&m=<?php echo $_GET['m']; ?>" class="cancel" target="_blank">طباعة</a>
		<a href="rprograms_main.php" class="cancel">رجوع</a>
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