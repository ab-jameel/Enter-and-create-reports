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

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 15") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){
if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=6 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$result10 = $conn->query("SELECT * FROM balances WHERE b_year='".$_GET['y']."' AND b_currency = 'دولار'") or die($conn->error());
	$result20 = $conn->query("SELECT * FROM balances WHERE b_year='".$_GET['y']."' AND b_currency = 'شلن'") or die($conn->error());
	$result11 = $conn->query("SELECT * FROM exchange WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."'") or die($conn->error());
	$result12 = $conn->query("SELECT * FROM expensesm WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."'") or die($conn->error());
	$result13 = $conn->query("SELECT * FROM expensesm INNER JOIN eitems ON e_item = eitems.ID WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."' AND i_name = 'العناية بالمهتدي'") or die($conn->error());
	$result14 = $conn->query("SELECT * FROM expensesr WHERE r_year='".$_GET['y']."' AND r_month='".$_GET['m']."'") or die($conn->error());
	$result15 = $conn->query("SELECT * FROM minfo WHERE m_year='".$_GET['y']."' AND m_month='".$_GET['m']."'") or die($conn->error());



	$num1 = mysqli_num_rows($result10);
	$num2 = mysqli_num_rows($result11);
	$num3 = mysqli_num_rows($result12);
	$num4 = mysqli_num_rows($result13);
	$num5 = mysqli_num_rows($result14);
	$num6 = mysqli_num_rows($result15);
?>
	<title>تقرير الايرادات والمصروفات</title>

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
if ($num1 > 0 and $num2 > 0 and $num3 > 0 and $num4 > 0 and $num5 > 0 and $num6 > 0){

	$row10 = $result10->fetch_assoc();
	$row20 = $result20->fetch_assoc();
	$row11 = $result11->fetch_assoc();
	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	$tr1 = $t1->fetch_assoc();
	$ro1 = $re1->fetch_assoc();
	
	if($ro1['k_type'] == 1){
		$k_person = $ro1['k_person'];
		$k_email = $ro1['k_email'];
		$k_time = $ro1['k_time'];
	}else{
		$k_person = '';
		$k_email = '';
		$k_time = '';
	}


	$result = $conn->query("SELECT SUM(e_amount) as t_general FROM expenses WHERE MONTH(e_date)='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."' AND e_currency = 'شلن'") or die($conn->error());
	$row = $result->fetch_assoc();
	if (empty($row['t_general'])){
	$shil_general = 0;
	}else{
	$shil_general = $row['t_general'];
	}
	$result2 = $conn->query("SELECT SUM(e_amount) as t_general FROM expenses WHERE MONTH(e_date)='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."' AND e_currency = 'دولار'") or die($conn->error());
	$row2 = $result2->fetch_assoc();
	if (empty($row2['t_general'])){
	$dollar_general = 0;
	}else{
	$dollar_general = $row2['t_general'];
	}
	$result3 = $conn->query("SELECT SUM(c_dollar) as t_dollar, SUM(c_dollar * c_exchange) as t_shil FROM cash WHERE MONTH(c_date)='".$_GET['m']."' AND YEAR(c_date)='".$_GET['y']."'") or die($conn->error());
	$row3 = $result3->fetch_assoc();
	if (empty($row3['t_dollar'])){
	$dollar_cash = 0;
	}else{
	$dollar_cash = $row3['t_dollar'];
	}
	if (empty($row3['t_shil'])){
	$shil_cash = 0;
	}else{
	$shil_cash = $row3['t_shil'];
	}
	$result21 = $conn->query("SELECT SUM(salary.s_every * salary.s_num) as s_monthly FROM salary WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."'") or die($conn->error());
	$row21 = $result21->fetch_assoc();
	if (empty($row21['s_monthly'])){
	$salary1 = 0;
	}else{
	$salary1 = $row21['s_monthly'];
	}
	$result22 = $conn->query("SELECT SUM(p_price) as p_monthly FROM portions WHERE p_month='".$_GET['m']."' AND p_year='".$_GET['y']."'") or die($conn->error());
	$row22 = $result22->fetch_assoc();
	if (empty($row22['p_monthly'])){
	$portions1 = 0;
	}else{
	$portions1 = $row22['p_monthly'];
	}
	$result4 = $conn->query("SELECT SUM(e_monthly * e_num) as e_total FROM expensesm INNER JOIN eitems ON eitems.ID = e_item WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."' AND i_type = 1 AND i_name != 'العناية بالمهتدي'") or die($conn->error());
	$result41 = $conn->query("SELECT SUM(e_monthly) as e_total FROM expensesm INNER JOIN eitems ON eitems.ID = e_item WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."' AND i_type = 2 AND i_name != 'العناية بالمهتدي'") or die($conn->error());
	$row4 = $result4->fetch_assoc();
	if (empty($row4['e_total'])){
	$expensesm1 = 0;
	}else{
	$expensesm1 = $row4['e_total'];
	}
	$row41 = $result41->fetch_assoc();
	if (empty($row41['e_total'])){
	$expensesm2 = 0;
	}else{
	$expensesm2 = $row41['e_total'];
	}
	$expensesm = $salary1 + $portions1 + $expensesm1 + $expensesm2;

	$result5 = $conn->query("SELECT SUM(i_amount) as t_income FROM incomes WHERE MONTH(i_date)='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."' AND i_currency = 'دولار'") or die($conn->error());
	$row5 = $result5->fetch_assoc();
	if (empty($row5['t_income'])){
	$dollar_incomes = 0;
	}else{
	$dollar_incomes = $row5['t_income'];
	}
	$result6 = $conn->query("SELECT SUM(i_amount) as t_income FROM incomes WHERE MONTH(i_date)='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."' AND i_currency = 'شلن'") or die($conn->error());
	$row6 = $result6->fetch_assoc();
	if (empty($row6['t_income'])){
	$shil_incomes = 0;
	}else{
	$shil_incomes = $row6['t_income'];
	}
	$result7 =  $conn->query("SELECT SUM(e_monthly * e_num) as e_total FROM expensesm INNER JOIN eitems ON e_item = eitems.ID WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."' AND i_name = 'العناية بالمهتدي'") or die($conn->error());
	$row7 = $result7->fetch_assoc();
	if (empty($row7['e_total'])){
	$care = 0;
	}else{
	$care = $row7['e_total'];
	}
	$result8 = $conn->query("SELECT SUM(r_amount) as r_total FROM expensesr WHERE r_year='".$_GET['y']."' AND r_month='".$_GET['m']."'") or die($conn->error());
	$row8 = $result8->fetch_assoc();
	if (empty($row8['r_total'])){
	$expensesr = 0;
	}else{
	$expensesr = $row8['r_total'];
	}
	$result9 = $conn->query("SELECT SUM(m_num1 * m_coss1) + SUM(m_num2 * m_coss2) + SUM(m_coss3) + SUM(m_coss4) AS total FROM minfo WHERE m_year = '".$_GET['y']."' AND m_month='".$_GET['m']."'") or die($conn->error());
	$row9 = $result9->fetch_assoc();
	if (empty($row9['total'])){
	$minfo = 0;
	}else{
	$minfo = $row9['total'];
	}
	$result16 = $conn->query("SELECT SUM(d_amount) AS d_amount FROM debts WHERE YEAR(d_date) = '".$_GET['y']."' AND MONTH(d_date)='".$_GET['m']."' AND d_currency = 'دولار'") or die($conn->error());
	$row16 = $result16->fetch_assoc();
	if (empty($row16['d_amount'])){
	$dollar_debts = 0;
	}else{
	$dollar_debts = $row16['d_amount'];
	}
	$result17 = $conn->query("SELECT SUM(d_amount) AS d_amount FROM debts WHERE YEAR(d_date) = '".$_GET['y']."' AND MONTH(d_date)='".$_GET['m']."' AND d_currency = 'شلن'") or die($conn->error());
	$row17 = $result17->fetch_assoc();
	if (empty($row17['d_amount'])){
	$shil_debts = 0;
	}else{
	$shil_debts = $row17['d_amount'];
	}

	$expenses_dollar = $dollar_general;
	$expenses_shil = $minfo + $expensesr + $care + $expensesm + $shil_general;



	//*********** totals
	$result = $conn->query("SELECT SUM(e_amount) as t_general FROM expenses WHERE MONTH(e_date)<='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."' AND e_currency = 'شلن'") or die($conn->error());
	$row = $result->fetch_assoc();
	if (empty($row['t_general'])){
	$shil_general_total = 0;
	}else{
	$shil_general_total = $row['t_general'];
	}
	$result2 = $conn->query("SELECT SUM(e_amount) as t_general FROM expenses WHERE MONTH(e_date)<='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."' AND e_currency = 'دولار'") or die($conn->error());
	$row2 = $result2->fetch_assoc();
	if (empty($row2['t_general'])){
	$dollar_general_total = 0;
	}else{
	$dollar_general_total = $row2['t_general'];
	}
	$result3 = $conn->query("SELECT SUM(c_dollar) as t_dollar, SUM(c_dollar * c_exchange) as t_shil FROM cash WHERE MONTH(c_date)<='".$_GET['m']."' AND YEAR(c_date)='".$_GET['y']."'") or die($conn->error());
	$row3 = $result3->fetch_assoc();
	if (empty($row3['t_dollar'])){
	$dollar_cash_total = 0;
	}else{
	$dollar_cash_total = $row3['t_dollar'];
	}
	if (empty($row3['t_shil'])){
	$shil_cash_total = 0;
	}else{
	$shil_cash_total = $row3['t_shil'];
	}
	$result21 = $conn->query("SELECT SUM(s_every * s_num) as s_monthly FROM salary WHERE s_month<='".$_GET['m']."' AND s_year='".$_GET['y']."'") or die($conn->error());
	$row21 = $result21->fetch_assoc();
	if (empty($row21['s_monthly'])){
	$salary1_total = 0;
	}else{
	$salary1_total = $row21['s_monthly'];
	}
	$result22 = $conn->query("SELECT SUM(p_price) as p_monthly FROM portions WHERE p_month<='".$_GET['m']."' AND p_year='".$_GET['y']."'") or die($conn->error());
	$row22 = $result22->fetch_assoc();
	if (empty($row22['p_monthly'])){
	$portions1_total = 0;
	}else{
	$portions1_total = $row22['p_monthly'];
	}
	$result4 = $conn->query("SELECT SUM(e_monthly * e_num) as e_total FROM expensesm INNER JOIN eitems ON e_item = eitems.ID WHERE e_month<='".$_GET['m']."' AND e_year='".$_GET['y']."' AND i_type = 1") or die($conn->error());
	$row4 = $result4->fetch_assoc();
	if (empty($row4['e_total'])){
	$expensesm1_total = 0;
	}else{
	$expensesm1_total = $row4['e_total'];
	}
	$result41 = $conn->query("SELECT SUM(e_monthly) as e_total FROM expensesm INNER JOIN eitems ON e_item = eitems.ID WHERE e_month<='".$_GET['m']."' AND e_year='".$_GET['y']."' AND i_type = 2") or die($conn->error());
	$row41 = $result41->fetch_assoc();
	if (empty($row41['e_total'])){
	$expensesm1_total1 = 0;
	}else{
	$expensesm1_total1 = $row41['e_total'];
	}
	$expensesm_total = $salary1_total + $portions1_total + $expensesm1_total + $expensesm1_total1;

	$result5 = $conn->query("SELECT SUM(i_amount) as t_income FROM incomes WHERE MONTH(i_date)<='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."' AND i_currency = 'دولار'") or die($conn->error());
	$row5 = $result5->fetch_assoc();
	if (empty($row5['t_income'])){
	$dollar_incomes_total = 0;
	}else{
	$dollar_incomes_total = $row5['t_income'];
	}
	$result6 = $conn->query("SELECT SUM(i_amount) as t_income FROM incomes WHERE MONTH(i_date)<='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."' AND i_currency = 'شلن'") or die($conn->error());
	$row6 = $result6->fetch_assoc();
	if (empty($row6['t_income'])){
	$shil_incomes_total = 0;
	}else{
	$shil_incomes_total = $row6['t_income'];
	}
	$result8 = $conn->query("SELECT SUM(r_amount) as r_total FROM expensesr WHERE r_year='".$_GET['y']."' AND r_month<='".$_GET['m']."'") or die($conn->error());
	$row8 = $result8->fetch_assoc();
	if (empty($row8['r_total'])){
	$expensesr_total = 0;
	}else{
	$expensesr_total = $row8['r_total'];
	}
	$result9 = $conn->query("SELECT SUM(m_num1 * m_coss1) + SUM(m_num2 * m_coss2) + SUM(m_coss3) + SUM(m_coss4) AS total FROM minfo WHERE m_year = '".$_GET['y']."' AND m_month<='".$_GET['m']."'") or die($conn->error());
	$row9 = $result9->fetch_assoc();
	if (empty($row9['total'])){
	$minfo_total = 0;
	}else{
	$minfo_total = $row9['total'];
	}
	$result16 = $conn->query("SELECT SUM(d_amount) AS d_amount FROM debts WHERE YEAR(d_date) = '".$_GET['y']."' AND MONTH(d_date)<='".$_GET['m']."' AND d_currency = 'دولار'") or die($conn->error());
	$row16 = $result16->fetch_assoc();
	if (empty($row16['d_amount'])){
	$dollar_debts_total = 0;
	}else{
	$dollar_debts_total = $row16['d_amount'];
	}
	$result17 = $conn->query("SELECT SUM(d_amount) AS d_amount FROM debts WHERE YEAR(d_date) = '".$_GET['y']."' AND MONTH(d_date)<='".$_GET['m']."' AND d_currency = 'شلن'") or die($conn->error());
	$row17 = $result17->fetch_assoc();
	if (empty($row17['d_amount'])){
	$shil_debts_total = 0;
	}else{
	$shil_debts_total = $row17['d_amount'];
	}

	$expenses_dollar_total = $dollar_general_total;
	$expenses_shil_total = $minfo_total + $expensesr_total + $expensesm_total + $shil_general_total;



	$exchange = $row11['e_price'];

	$dollar_balance = $row10['b_amount'];
	$shil_balance = $row20['b_amount'];

	$dollar_total = $dollar_balance + $dollar_incomes_total - $dollar_cash_total - $dollar_general_total - $dollar_debts_total;
	$shil_total = $shil_balance + $shil_incomes_total + $shil_cash_total - $expenses_shil_total - $shil_debts_total;

?>
<div class="container">
<div style="margin-right: 125px;">
	<p class="right1" style="font-size: 17.5px;">مركز الدعوة الاسلامي</p>
	<p class="right1" style="font-size: 17.5px;">تقرير الايرادات والمصروفات</p>
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
<br>
<div class="col col-sm-3">
<table style="display: inline-block;">
	<tr style="border: 1px solid rgb(180,180,180);">
		<td style="width: 100px;"><?php echo number_format($exchange); ?></td>
		<td style="width: 100px;" class="c230">سعر الصرف</td>
	</tr>
</table>
</div>
<br>
<br>
<br>
<table class="table">
	<thead>
	 	<th class="cen2 hst">شلن</th>
	 	<th class="cen2 hst">دولار</th>
		<th class="right1 hst">البند</th>
	</thead>
	<tr>
		<td><?php echo number_format($expenses_shil); ?></td>
		<td><?php echo number_format($expenses_dollar); ?></td>
		<td class="right1">اجمالي المصروفات</td>
	</tr>
	<tr>
		<td><?php echo number_format($minfo); ?></td>
		<td></td>
		<td class="right1">المركز الاسلامي للدعوة</td>
	</tr>
	<tr>
		<td><?php echo number_format($expensesr); ?></td>
		<td></td>
		<td class="right1">المصروفات التشغيلية</td>
	</tr>
	<tr>
		<td><?php echo number_format($care); ?></td>
		<td></td>
		<td class="right1">العناية بالمهتدي</td>
	</tr>
	<tr>
		<td><?php echo number_format($expensesm); ?></td>
		<td></td>
		<td class="right1">مصروفات التأسيسية والمتقدمة</td>
	</tr>
	<tr>
		<td><?php echo number_format($shil_general); ?></td>
		<td><?php echo number_format($dollar_general); ?></td>
		<td class="right1">مصروفات عامة</td>
	</tr>
	<tr>
		<td><?php echo number_format($shil_cash); ?></td>
		<td><?php echo number_format($dollar_cash); ?></td>
		<td class="right1">صرف العملات</td>
	</tr>
	<tr>
		<td><?php echo number_format($shil_incomes); ?></td>
		<td><?php echo number_format($dollar_incomes); ?></td>
		<td class="right1">اجمالي الواردات</td>
	</tr>
	<tr class="th4">
		<td><?php echo number_format($shil_total); ?></td>
		<td><?php echo number_format($dollar_total); ?></td>
		<td class="c240">رصيد الصندوق</td>
	</tr>
</table>
<br>
<div class="row justify-content-center">
	<?php
	$result = $conn->query("SELECT * FROM cash WHERE MONTH(c_date)='".$_GET['m']."' AND YEAR(c_date)='".$_GET['y']."'") or die($conn->error());
	?>
	<div class="col col-sm-4">
		<table class="table">
			<thead class="th4">
				<th class="c230 cen2" colspan="4">خاص بصرف العملة</th>
			</thead>
			<tr>
				<td>المبلغ بالشلن</td>
				<td>سعر الصرف</td>
				<td>المبلغ بالدولار</td>
				<td>رقم الفاتورة</td>
			</tr>
			<?php while ($row = $result->fetch_assoc()){
				$shil = $row['c_exchange'] * $row['c_dollar'];
			?>
			<tr>
				<td><?php echo number_format($shil); ?></td>
				<td><?php echo number_format($row['c_exchange']); ?></td>
				<td><?php echo number_format($row['c_dollar']); ?></td>
				<td><?php echo $row['c_number']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php
	$result = $conn->query("SELECT * FROM incomes WHERE MONTH(i_date)='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."'") or die($conn->error());
	?>
	<div class="col col-sm-4">
		<table class="table">
			<thead class="th4">
				<th class="c230 cen2" colspan="4">خاص بالواردات والايرادات</th>
			</thead>
			<tr>
				<td>المبلغ</td>
				<td>العملة</td>
				<td>رقم السند</td>
			</tr>
			<?php while ($row = $result->fetch_assoc()){ ?>
				<tr>
					<td><?php echo number_format($row['i_amount']); ?></td>
					<td><?php echo $row['i_currency']; ?></td>
					<td><?php echo $row['i_number']; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
	<?php
	$result = $conn->query("SELECT * FROM expensesr INNER JOIN ritems ON expensesr.r_item = ritems.ID WHERE r_month='".$_GET['m']."' AND r_year='".$_GET['y']."'") or die($conn->error());
	?>
	<div class="col col-sm-4">
		<table class="table">
			<thead class="th4">
				<th class="c230 cen2" colspan="4">خاص بالمصروفات التشغيلية</th>
			</thead>
			<tr>
				<td>المبلغ بالشلن</td>
				<td class="right1">النشاط</td>
			</tr>
			<?php while ($row = $result->fetch_assoc()){ ?>
				<tr>
					<td><?php echo number_format($row['r_amount']); ?></td>
					<td class="right1"><?php echo $row['i_name']; ?></td>
				</tr>
			<?php } ?>		
		</table>
	</div>
</div>
	<?php
	$result = $conn->query("SELECT * FROM expenses WHERE MONTH(e_date)='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."'") or die($conn->error());
	?>
	<table class="table">
		<thead class="th4">
			<th class="c230 cen2" colspan="5">مصروفات عامة</th>
		</thead>
		<tr>
			<td>البيان</td>
			<td>التصنيف</td>
			<td>العملة</td>
			<td>القيمة</td>
			<td>التاريخ</td>
		</tr>
		<?php while ($row = $result->fetch_assoc()){ ?>
			<tr>
				<td><?php echo $row['e_notice']; ?></td>
				<td><?php echo $row['e_comparison']; ?></td>
				<td><?php echo $row['e_currency']; ?></td>
				<td><?php echo number_format($row['e_amount']); ?></td>
				<td><?php echo $row['e_date']; ?></td>
			</tr>
		<?php } ?>		
	</table>
<br>
<div class="col col-sm-3">
	<div class="form-group">
		<a href="expensesr_report.php?y=<?php echo $_GET['y']; ?>&m=<?php echo $_GET['m']; ?>" class="cancel" target="_blank">طباعة</a>
		<a href="expensesr_main.php" class="cancel">رجوع</a>
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