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

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 3") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){
if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=5 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$result = $conn->query("SELECT DISTINCT marakez.mname, marakez.ID FROM expensesm INNER JOIN marakez ON marakez.ID = expensesm.e_markaz WHERE expensesm.e_month='".$_GET['m']."' AND expensesm.e_year='".$_GET['y']."' ORDER BY ID ASC") or die($conn->error());
	$result7 =  $conn->query("SELECT * FROM expensesm WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."'") or die($conn->error());
	$result8 = $conn->query("SELECT DISTINCT eitems.id, eitems.i_name FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND eitems.i_type=1 ORDER BY expensesm.ID DESC") or die($conn->error());
	$result81 = $conn->query("SELECT DISTINCT eitems.id, eitems.i_name FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."' AND eitems.i_type = 2 ORDER BY expensesm.ID DESC") or die($conn->error());
	$result3 = $conn->query("SELECT * FROM countc WHERE c_year='".$_GET['y']."' AND c_month='".$_GET['m']."'") or die($conn->error());
	$result15 = $conn->query("SELECT c_amount FROM comparison WHERE c_year='".$_GET['y']."' AND c_program = 'الدورات التأسيسية والمتقدمة' AND c_axis = 'تعليم المهتدين'") or die($conn->error());
	$result16 = $conn->query("SELECT c_amount FROM comparison WHERE c_year='".$_GET['y']."' AND c_program = 'العناية بالمهتدي' AND c_axis = 'تعليم المهتدين'") or die($conn->error());
	$result17 = $conn->query("SELECT * FROM exchange WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."'") or die($conn->error());



	$num1 = mysqli_num_rows($re1);
	$num2 = mysqli_num_rows($result);
	$num3 = mysqli_num_rows($result7);
	$num4 = mysqli_num_rows($result3);
	$num5 = mysqli_num_rows($result15);
	$num6 = mysqli_num_rows($result16);
	$num7 = mysqli_num_rows($result17);
	$num8 = mysqli_num_rows($result8);
	$num81 = mysqli_num_rows($result81);
?>

	<title>تقرير مصروفات التأسيسية</title>

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
if ($num1 > 0 and $num2 > 0 and $num3 > 0 and $num4 > 0 and $num5 > 0 and $num6 > 0 and $num7 > 0){

	$num88 = $num8 / 2;
	$num88 = number_format($num88);
	$num9 = $num88 + $num81;
	if ($num9 > 0){
	$wid =  110 / $num9;
	}else{
	$wid = 0;
	}

	$result20 = $conn->query("SELECT SUM(e_monthly * e_num) as s_total FROM expensesm INNER JOIN eitems ON eitems.ID = expensesm.e_item WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."' AND i_type = 1") or die($conn->error());
	$result30 = $conn->query("SELECT SUM(e_monthly) as s_total FROM expensesm INNER JOIN eitems ON eitems.ID = expensesm.e_item WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."' AND i_type = 2") or die($conn->error());
	$result21 = $conn->query("SELECT SUM(salary.s_every * salary.s_num) as s_monthly, SUM(salary.s_num) as s_num FROM salary WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."'") or die($conn->error());
	$result22 = $conn->query("SELECT SUM(portions.p_price) as p_monthly FROM portions WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."'") or die($conn->error());
	$result23 = $conn->query("SELECT SUM(c_amount) as c_amount FROM comparison WHERE c_year='".$_GET['y']."' AND c_program = 'الدورات التأسيسية والمتقدمة' AND c_axis = 'تعليم المهتدين'") or die($conn->error());
	$result24 = $conn->query("SELECT SUM(c_amount) as c_amount FROM comparison WHERE c_year='".$_GET['y']."' AND c_program = 'العناية بالمهتدي' AND c_axis = 'تعليم المهتدين'") or die($conn->error());


	$tr1 = $t1->fetch_assoc();
	$ro1 = $re1->fetch_assoc();
	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	$row17 = $result17->fetch_assoc();
	$row20 = $result20->fetch_assoc();
	$row30 = $result30->fetch_assoc();
	$row21 = $result21->fetch_assoc();
	$row22 = $result22->fetch_assoc();
	$row23 = $result23->fetch_assoc();
	$row24 = $result24->fetch_assoc();
	if($ro1['k_type'] == 1){
		$k_person = $ro1['k_person'];
		$k_email = $ro1['k_email'];
		$k_time = $ro1['k_time'];
	}else{
		$k_person = '';
		$k_email = '';
		$k_time = '';
	}

	$exchange = $row17['e_price'];
	$e_total = $row20['s_total'] + $row30['s_total'] + $row21['s_monthly'] + $row22['p_monthly'];
	$real = $e_total / $exchange;
	$t_com = $row23['c_amount'] + $row24['c_amount'];
	$t_com = $t_com / 12;
	$dif = $t_com - $real;
	$perc = $real / $t_com;
	$perc = $perc * 100;
?>
<div class="container">
<div style="margin-right: 125px;">
	<p class="right1" style="font-size: 17.5px;">مركز الدعوة الاسلامي</p>
	<p class="right1" style="font-size: 17.5px;">تقرير مصروفات التأسيسية</p>
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
		<td class="hst" style="border-left-color: black;">الحركة</td>
		<td class="hst">نسبة الصرف</td>
		<td class="hst">الفرق</td>
		<td class="hst">الموازنة الشهرية</td>
		<td class="hst">الصرف الفعلي بالدولار</td>
		<td class="hst">سعر الصرف</td>
		<td class="hst">المجموع بالشلن</td>
		<td class="hst" rowspan="2" style="vertical-align: middle; border-bottom-color: black;">الحركة الشهرية</td>
	</tr>
	<tr>
		<?php if($perc >= 100){ $text = "فوق الموازنة"; ?>
				<td class="dst" style="background-color: rgb(255,180,185);">
		<?php }else{ $text = "تحت الموازنة"; ?>
				<td class="dst" style="background-color: rgb(185,255,185);">
		<?php } echo $text; ?>
		</td>
		<td class="dst"><?php echo number_format($perc).' %'; ?></td>
		<td class="dst"><?php echo number_format($dif); ?></td>
		<td class="dst"><?php echo number_format($t_com); ?></td>
		<td class="dst"><?php echo number_format($real); ?></td>
		<td class="dst"><?php echo number_format($exchange); ?></td>
		<td class="dst"><?php echo number_format($e_total); ?></td>
	</tr>
</table>

<?php
while ($row = $result->fetch_assoc()){

	$result12 = $conn->query("SELECT SUM(e_monthly * e_num) as s_total FROM expensesm INNER JOIN eitems ON eitems.ID = expensesm.e_item WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."' AND e_markaz='".$row['ID']."' AND i_type = 1") or die($conn->error());
	$result13 = $conn->query("SELECT SUM(e_monthly) as s_total FROM expensesm INNER JOIN eitems ON eitems.ID = expensesm.e_item WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."' AND e_markaz='".$row['ID']."' AND i_type = 2") or die($conn->error());
	$result7 = $conn->query("SELECT SUM(salary.s_every * salary.s_num) as s_monthly, SUM(salary.s_num) as s_num FROM salary WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."'") or die($conn->error());
	$result11 = $conn->query("SELECT SUM(portions.p_price) as p_monthly FROM portions WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."'") or die($conn->error());
	$result5 = $conn->query("SELECT c_learn + c_dev as total FROM countc WHERE c_month='".$_GET['m']."' AND c_year='".$_GET['y']."' AND c_markaz='".$row['ID']."'") or die($conn->error());
	$row5 = $result5->fetch_assoc();
	$row7 = $result7->fetch_assoc();
	$row11 = $result11->fetch_assoc();
	$row12 = $result12->fetch_assoc();
	$row13 = $result13->fetch_assoc();

	if (empty($row5['total'])) {
		$row5['total'] = 0;
	}

	$f_total = $row12['s_total'] + $row13['s_total'] + $row7['s_monthly'] + $row11['p_monthly'];

	$d_total = $f_total / $exchange;

	$result82 = $conn->query("SELECT DISTINCT eitems.id, eitems.i_name, eitems.i_type FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=1 ORDER BY expensesm.ID DESC LIMIT ".$num88) or die($conn->error());

	$result83 = $conn->query("SELECT DISTINCT eitems.id, eitems.i_name, eitems.i_type FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());

	$result84 = $conn->query("SELECT c_amount FROM comparison WHERE c_year='".$_GET['y']."' AND c_markaz='".$row['ID']."' AND c_program = 'الدورات التأسيسية والمتقدمة' AND c_axis = 'تعليم المهتدين'") or die($conn->error());
	$result85 = $conn->query("SELECT c_amount FROM comparison WHERE c_year='".$_GET['y']."' AND c_markaz='".$row['ID']."' AND c_program = 'العناية بالمهتدي' AND c_axis = 'تعليم المهتدين'") or die($conn->error());
	$row84 = $result84->fetch_assoc();
	$row85 = $result85->fetch_assoc();
	$num84 = mysqli_num_rows($result84);
	$num85 = mysqli_num_rows($result85);
	if ($num84 > 0 and $num85 > 0){
	$com = $row84['c_amount'] + $row85['c_amount'];
	}elseif ($num84 > 0){
	$com = $row84['c_amount'];
	}else { 
	$com = $row85['c_amount'];
	}
	$com = $com / 12;

	$result2 = $conn->query("SELECT expensesm.e_num FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());
	$result6 = $conn->query("SELECT expensesm.e_monthly FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.ID WHERE expensesm.e_month='".$_GET['m']."' AND expensesm.e_year='".$_GET['y']."' AND expensesm.e_markaz='".$row['ID']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=1 ORDER BY expensesm.ID DESC LIMIT ".$num88) or die($conn->error());
?>
<br>
<table class="table">
	<thead class="th5">
		<th class="cen2 c240">المجموع</th>
		<?php while ($row82 = $result82->fetch_assoc()){ ?>
			<th class="cen2"><?php echo $row82['i_name']; ?></th>
		<?php } ?>
		<th class="cen2">عدد العاملين</th>
		<?php while ($row83 = $result83->fetch_assoc()){ ?>
			<th class="cen2"><?php echo $row83['i_name']; ?></th>
		<?php } ?>
		<th class="cen2">التغذية</th>
		<th class="cen2">البند</th>
		<th class="cen2">المركز</th>
	</thead>
	<tr>
		<td class="c240"><?php echo number_format($row5['total']); ?></td>
		<?php while ($row6 = $result6->fetch_assoc()){ ?>
			<td><?php echo number_format($row6['e_monthly']); ?></td>
		<?php } ?>
		<td><?php echo number_format($row7['s_num']); ?></td>
		<?php while ($row2 = $result2->fetch_assoc()){ ?>
			<td><?php echo number_format($row2['e_num']); ?></td>
		<?php } ?>
		<td><?php echo number_format($row5['total']); ?></td>
		<td>العدد</td>
		<td rowspan="3" style="vertical-align: middle;"><?php echo $row['mname']; ?></td>
	</tr>
	<?php
	$result6 = $conn->query("SELECT DISTINCT eitems.id, eitems.i_name FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=1 ORDER BY expensesm.ID DESC LIMIT ".$num88." OFFSET ".$num88) or die($conn->error());
	$result2 = $conn->query("SELECT expensesm.e_monthly / expensesm.e_num as every FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());
	$result10 = $conn->query("SELECT expensesm.e_monthly / expensesm.e_num as every FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());

	$sp1 = number_format($num88/2);
	if (($num8 % 2) != 0){
	$num100 = $num88 - 1;
	$rep = $wid / $num100;
	$wid2 = $wid + $rep;
	$cs = 2;
	}else{
	$wid2 = $wid;
	$cs = 1;
	}
	?>
	<tr>
		<td class="c240"><?php if ($row5['total'] > 0){ echo number_format($f_total / $row5['total']); }else{ echo 0;} ?></td>
		<?php while ($row6 = $result6->fetch_assoc()){ ?>
			<td><?php echo $row6['i_name']; ?></td>
		<?php } ?>
		<?php if($cs == 2){ ?>
			<td></td>
		<?php } ?>
		<td>اجمالي الرواتب</td>
		<?php while ($row2 = $result2->fetch_assoc()){ ?>
			<td><?php echo number_format($row2['every']); ?></td>
		<?php } ?>
		<td><?php if ($row5['total'] > 0){ echo number_format($row11['p_monthly'] / $row5['total']); }else{ echo 0;} ?></td>
		<td>التكلفة الفردية</td>
	</tr>
	<?php
	$result2 = $conn->query("SELECT expensesm.e_monthly FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());
	$result6 = $conn->query("SELECT expensesm.e_monthly FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.ID WHERE expensesm.e_month='".$_GET['m']."' AND expensesm.e_year='".$_GET['y']."' AND expensesm.e_markaz='".$row['ID']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=1 ORDER BY expensesm.ID DESC LIMIT ".$num88." OFFSET ".$num88) or die($conn->error());


	if ($com > 0){
	$percent = $d_total / $com;
	}else{
	$percent = 0;
	}
	$percent = $percent * 100;
	?>
	<tr>
		<td class="c240"><?php echo number_format($f_total); ?></td>
		<?php while ($row6 = $result6->fetch_assoc()){ ?>
			<td><?php echo number_format($row6['e_monthly']); ?></td>
		<?php } ?>
		<?php if($cs == 2){ ?>
			<td></td>
		<?php } ?>
		<td><?php echo number_format($row7['s_monthly']); ?></td>
		<?php while ($row2 = $result2->fetch_assoc()){ ?>
			<td><?php echo number_format($row2['e_monthly']); ?></td>
		<?php } ?>
		<td><?php echo number_format($row11['p_monthly']); ?></td>
		<td>التكلفة الشهرية</td>
	</tr>
	<tr class="th5">
		<?php if($percent >= 100){ $text = "فوق الموازنة"; ?>
				<td class="" style="background-color: rgb(255,180,185);">
		<?php }else{ $text = "تحت الموازنة"; ?>
				<td class="" style="background-color: rgb(185,255,185);">
		<?php } echo $text; ?>
		</td>
		<td class="c240">الحركة</td>
		<?php if($percent >= 100){ ?>
				<td class="" style="color: rgb(150,0,0);">
		<?php }else{ ?>
				<td class="" style="color: rgb(0,80,0);">
		<?php } echo number_format($percent).' %'; ?>
		</td>
		<td class="c240">نسبة الصرف</td>
		<td><?php echo number_format($d_total).' $'; ?></td>
		<td class="c240">الاجمالي بالدولار</td>
		<td colspan="<?php echo $sp1; ?>"><?php echo number_format($com).' $'; ?></td>
		<td class="c240" colspan="<?php echo $sp1 + 1; ?>">الموازنة المحددة</td>
	</tr>
</table>
<?php } ?>
<div class="col col-sm-3">
	<div class="form-group">
		<a href="expensesm_report.php?y=<?php echo $_GET['y']; ?>&m=<?php echo $_GET['m']; ?>" class="cancel" target="_blank">طباعة</a>
		<a href="expensesm_main.php" class="cancel">رجوع</a>
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