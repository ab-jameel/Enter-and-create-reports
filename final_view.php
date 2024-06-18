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
	<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

	<?php
	session_start();
	if (isset($_SESSION['id'])){
	$username1 = $_SESSION['kusername'];
	$email1 = $_SESSION['kemail'];
	$id = $_SESSION['id'];
	require_once'connect.php';
	require_once'php/premissions.php';

	if (isset($_GET['y'])){
		$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
		$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
		$result2 = $conn->query("SELECT * FROM balances WHERE b_year='".$_GET['y']."'") or die($conn->error());
	    $result3 = $conn->query("SELECT * FROM exchange WHERE e_month = 1 AND e_year='".$_GET['y']."'") or die($conn->error());

	$num22 = mysqli_num_rows($result2);
	$num33 = mysqli_num_rows($result3);
	?>

	<title>الملخص المالي السنوي</title>

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
if ($num22 > 1 and $num33 > 0){

	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
    $row3 = $result3->fetch_assoc();


    $exchange1 = $row3['e_price'];
	$t_shil = 0;
	$total = 0;


    $dollar_total_expenses_t = 0;
    $dollar_debts_t = 0;
    $dollar_expenses_t = 0;
    $dollar_cash_t = 0;
    $dollar_incomes_t = 0;

    $shil_total_expenses_t = 0;
    $shil_debts_t = 0;
    $shil_expenses_t = 0;
    $shil_cash_t = 0;
    $shil_incomes_t = 0;
    $shil_expensesr_t = 0;
    $shil_expensesm_t = 0;
    $shil_minfo_t = 0;
    $shil_total_expenses_t1 = 0;

?>
<div class="container">
<div style="margin-right: 125px;">
	<p class="right1" style="font-size: 17.5px;">مركز الدعوة الاسلامي</p>
	<p class="right1" style="font-size: 17.5px;">الملخص المالي السنوي</p>
	<p class="right1" style="font-size: 17.5px;">لعام <?php echo $_GET['y']; ?></p>
</div>
<img src="<?php echo $tp1['p_source']; ?>" width="100" height="100" style="display: block; margin-top: -112.5px; float: right;">
<div style="display: block; margin-top: -100px; float: left; margin-left: 50px;">
	<p class="right1" style="margin-right: 40px; margin-top: 10px; font-size: 15px;"> اعداد واشراف</p>
	<img src="<?php echo $tp11['p_source']; ?>" width="150" height="50">
</div>
<br>
<div id="chartContainer" style="width: 100%; height: 300px;"></div>
<?php
$result1 =  $conn->query("SELECT * FROM months ORDER BY ID ASC") or die($conn->error());
?>

<table class="table" style="margin-top: 250px;">
	<tr class="th4">
		<td class="c230">سعر الصرف</td>
		<td class="c230">مجموع المصروفات</td>
		<td class="c230">سداد ديون</td>
		<td class="c230">مصروفات عامة</td>
		<td class="c230">الدعوة</td>
		<td class="c230">التعليم</td>
		<td class="c230">التشغيلية</td>
		<td class="c230">صرف عملة</td>
		<td class="c230">واردات</td>
		<td class="c230">العملة</td>
		<td class="c230">الشهر</td>
	</tr>
	<?php
	while ($row = $result1->fetch_assoc()){
	    $r1 = $conn->query("SELECT * FROM rok WHERE k_month = '".$row['ID']."' AND k_year = '".$_GET['y']."' AND k_type = 1") or die($conn->error());
	    $num1 = mysqli_num_rows($r1);

	    if ($num1 > 0){

	    $r2 = $conn->query("SELECT * FROM exchange WHERE e_month = '".$row['ID']."' AND e_year = '".$_GET['y']."'") or die($conn->error());
	    $ro2 = $r2->fetch_assoc();
	    $exchange = $ro2['e_price'];
	    $result4 = $conn->query("SELECT SUM(d_amount) as d_amount FROM debts WHERE MONTH(d_date) = '".$row['ID']."' AND YEAR(d_date) = '".$_GET['y']."' AND d_currency = 'دولار'") or die($conn->error());
	    $row4 = $result4->fetch_assoc();
	    if (empty($row4['d_amount'])){
	    $dollar_debts = 0;
	    }else{
	    $dollar_debts = $row4['d_amount'];
	    }

	    $result5 = $conn->query("SELECT SUM(e_amount) as e_amount FROM expenses WHERE MONTH(e_date) = '".$row['ID']."' AND YEAR(e_date) = '".$_GET['y']."' AND e_currency = 'دولار'") or die($conn->error());
	    $row5 = $result5->fetch_assoc();
	    if (empty($row5['e_amount'])){
	    $dollar_expenses = 0;
	    }else{
	    $dollar_expenses = $row5['e_amount'];
	    }

	    $result6 = $conn->query("SELECT SUM(c_dollar) as c_dollar FROM cash WHERE MONTH(c_date) = '".$row['ID']."' AND YEAR(c_date) = '".$_GET['y']."'") or die($conn->error());
	    $row6 = $result6->fetch_assoc();
	    if (empty($row6['c_dollar'])){
	    $dollar_cash = 0;
	    }else{
	    $dollar_cash = $row6['c_dollar'];
	    }

	    $result7 = $conn->query("SELECT SUM(i_amount) as i_amount FROM incomes WHERE MONTH(i_date) = '".$row['ID']."' AND YEAR(i_date) = '".$_GET['y']."' AND i_currency = 'دولار'") or die($conn->error());
	    $row7 = $result7->fetch_assoc();
	    if (empty($row7['i_amount'])){
	    $dollar_incomes = 0;
	    }else{
	    $dollar_incomes = $row7['i_amount'];
	    }

	    $dollar_total_expenses = $dollar_expenses + $dollar_debts;

	    $result8 = $conn->query("SELECT SUM(d_amount) as d_amount FROM debts WHERE MONTH(d_date) = '".$row['ID']."' AND YEAR(d_date) = '".$_GET['y']."' AND d_currency = 'شلن'") or die($conn->error());
	    $row8 = $result8->fetch_assoc();
	    if (empty($row8['d_amount'])){
	    $shil_debts = 0;
	    }else{
	    $shil_debts = $row8['d_amount'];
	    }

	    $result9 = $conn->query("SELECT SUM(e_amount) as e_amount FROM expenses WHERE MONTH(e_date) = '".$row['ID']."' AND YEAR(e_date) = '".$_GET['y']."' AND e_currency = 'شلن'") or die($conn->error());
	    $row9 = $result9->fetch_assoc();
	    if (empty($row9['e_amount'])){
	    $shil_expenses = 0;
	    }else{
	    $shil_expenses = $row9['e_amount'];
	    }

	    $r2 = $conn->query("SELECT * FROM rok WHERE k_month = '".$row['ID']."' AND k_year = '".$_GET['y']."' AND r_type = 6") or die($conn->error());
	    $num2 = mysqli_num_rows($r2);
	    if ($num2 > 0){
	    $rr2 = $r2->fetch_assoc();
	    if ($rr2['k_type'] > 0){
	    $result10 = $conn->query("SELECT SUM(r_amount) as r_amount FROM expensesr WHERE r_month = '".$row['ID']."' AND r_year = '".$_GET['y']."'") or die($conn->error());
	    $row10 = $result10->fetch_assoc();
	    $shil_expensesr = $row10['r_amount'];
	    }else{
	    $shil_expensesr = "غير معتمد";
	    }
	    }else{
	    $shil_expensesr = "غير مدخل";
	    }

	    $r2 = $conn->query("SELECT * FROM rok WHERE k_month = '".$row['ID']."' AND k_year = '".$_GET['y']."' AND r_type = 2") or die($conn->error());
	    $num2 = mysqli_num_rows($r2);
	    if ($num2 > 0){
	    $rr2 = $r2->fetch_assoc();
	    if ($rr2['k_type'] > 0){
	    $result7 =  $conn->query("SELECT SUM(m_num1) as m_num1, SUM(m_coss1) as m_coss1, SUM(m_coss11) as m_coss11, SUM(m_num2) as m_num2, SUM(m_coss2) as m_coss2, SUM(m_coss22) as m_coss22, SUM(m_num3) as m_num3, SUM(m_coss3) as m_coss3, SUM(m_coss33) as m_coss33, SUM(m_num4) as m_num4, SUM(m_coss4) as m_coss4 FROM minfo WHERE m_month='".$row['ID']."' AND m_year='".$_GET['y']."'") or die($conn->error());
	    $row7 = $result7->fetch_assoc();
	    $shil_minfo = $row7['m_coss11'] + $row7['m_coss22'] + $row7['m_coss3'] + $row7['m_coss4'];
	    }else{
	    $shil_minfo = "غير معتمد";
	    }
	    }else{
	    $shil_minfo = "غير مدخل";
	    }

	    $r2 = $conn->query("SELECT * FROM rok WHERE k_month = '".$row['ID']."' AND k_year = '".$_GET['y']."' AND r_type = 5") or die($conn->error());
	    $num2 = mysqli_num_rows($r2);
	    if ($num2 > 0){
	    $rr2 = $r2->fetch_assoc();
	    if ($rr2['k_type'] > 0){
		$result20 = $conn->query("SELECT SUM(e_monthly * e_num) as s_total FROM expensesm INNER JOIN eitems ON eitems.ID = expensesm.e_item WHERE e_year='".$_GET['y']."' AND e_month='".$row['ID']."' AND i_type = 1") or die($conn->error());
		$result30 = $conn->query("SELECT SUM(e_monthly) as s_total FROM expensesm INNER JOIN eitems ON eitems.ID = expensesm.e_item WHERE e_year='".$_GET['y']."' AND e_month='".$row['ID']."' AND i_type = 2") or die($conn->error());
		$result21 = $conn->query("SELECT SUM(s_every * s_num) as s_monthly, SUM(s_num) as s_num FROM salary WHERE s_month='".$row['ID']."' AND s_year='".$_GET['y']."'") or die($conn->error());
		$result22 = $conn->query("SELECT SUM(p_price) as p_monthly FROM portions WHERE p_month='".$row['ID']."' AND p_year='".$_GET['y']."'") or die($conn->error());
		$row20 = $result20->fetch_assoc();
		$row30 = $result30->fetch_assoc();
		$row21 = $result21->fetch_assoc();
		$row22 = $result22->fetch_assoc();

		$shil_expensesm = $row20['s_total'] + $row30['s_total'] + $row21['s_monthly'] + $row22['p_monthly'];
	    }else{
	    $shil_expensesm = "غير معتمد";
	    }
	    }else{
	    $shil_expensesm = "غير مدخل";
	    }

	    $result13 = $conn->query("SELECT SUM(c_dollar * c_exchange) as c_shil FROM cash WHERE MONTH(c_date) = '".$row['ID']."' AND YEAR(c_date) = '".$_GET['y']."'") or die($conn->error());
	    $row13 = $result13->fetch_assoc();
	    if (empty($row13['c_shil'])){
	    $shil_cash = 0;
	    }else{
	    $shil_cash = $row13['c_shil'];
	    }

	    $result14 = $conn->query("SELECT SUM(i_amount) as i_amount FROM incomes WHERE MONTH(i_date) = '".$row['ID']."' AND YEAR(i_date) = '".$_GET['y']."' AND i_currency = 'شلن'") or die($conn->error());
	    $row14 = $result14->fetch_assoc();
	    if (empty($row14['i_amount'])){
	    $shil_incomes = 0;
	    }else{
	    $shil_incomes = $row14['i_amount'];
	    }

	    if (is_numeric($shil_expensesr)){
	        $expensesr1 = $shil_expensesr;
	    }else{
	        $expensesr1 = 0;
	    }

	    if (is_numeric($shil_minfo)){
	        $minfo1 = $shil_minfo;
	    }else{
	        $minfo1 = 0;
	    }

	    if (is_numeric($shil_expensesm)){
	        $expensesm1 = $shil_expensesm;
	    }else{
	        $expensesm1 = 0;
	    }

	    $shil_total_expenses = $shil_expenses + $shil_debts + $expensesr1 + $minfo1 + $expensesm1;

	    $shil_total_expenses1 = $shil_expenses + $expensesr1 + $minfo1 + $expensesm1;

		$dollar_total_expenses_t = $dollar_total_expenses_t + $dollar_total_expenses;
	    $dollar_debts_t = $dollar_debts_t + $dollar_debts;
	    $dollar_expenses_t = $dollar_expenses_t + $dollar_expenses;
	    $dollar_cash_t = $dollar_cash_t + $dollar_cash;
	    $dollar_incomes_t = $dollar_incomes_t + $dollar_incomes;


	    $shil_total_expenses_t = $shil_total_expenses_t + $shil_total_expenses;
	    $shil_total_expenses_t1 = $shil_total_expenses_t1 + $shil_total_expenses1;
	    $shil_debts_t = $shil_debts_t + $shil_debts;
	    $shil_expenses_t = $shil_expenses_t + $shil_expenses;
	    $shil_cash_t = $shil_cash_t + $shil_cash;
	    $shil_incomes_t = $shil_incomes_t + $shil_incomes;
	    $shil_expensesr_t = $shil_expensesr_t + $expensesr1;
	    $shil_expensesm_t = $shil_expensesm_t + $expensesm1;
	    $shil_minfo_t = $shil_minfo_t + $minfo1;


	?>
		<tr>
			<td rowspan="2" style="vertical-align: middle; border-bottom: 2px solid black;"><?php echo number_format($exchange); ?></td>
			<td><?php echo number_format($dollar_total_expenses); ?></td>
			<td><?php echo number_format($dollar_debts); ?></td>
			<td><?php echo number_format($dollar_expenses); ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo number_format($dollar_cash); ?></td>
			<td><?php echo number_format($dollar_incomes); ?></td>
			<td>دولار</td>
			<td rowspan="2" style="vertical-align: middle; border-bottom: 2px solid black;"><?php echo $row['m_name']; ?></td>
		</tr>
		<tr style="border-bottom: 2px solid black;">
			<td><?php echo number_format($shil_total_expenses); ?></td>
			<td><?php echo number_format($shil_debts); ?></td>
			<td><?php echo number_format($shil_expenses); ?></td>
		    <?php if (is_numeric($shil_minfo)){ ?>
		    	<td><?php echo number_format($shil_minfo); ?></td>
		    <?php }else{ ?>
		    	<td style="color: rgb(150,0,0);"><?php echo $shil_minfo; ?></td>
		    <?php } ?>
		    <?php if (is_numeric($shil_expensesm)){ ?>
		    	<td><?php echo number_format($shil_expensesm); ?></td>
		    <?php }else{ ?>
		    	<td style="color: rgb(150,0,0);"><?php echo $shil_expensesm; ?></td>
		    <?php } ?>
		    <?php if (is_numeric($shil_expensesr)){ ?>
		    	<td><?php echo number_format($shil_expensesr); ?></td>
		    <?php }else{ ?>
		    	<td style="color: rgb(150,0,0);"><?php echo $shil_expensesr; ?></td>
		    <?php } ?>
			<td><?php echo number_format($shil_cash); ?></td>
			<td><?php echo number_format($shil_incomes); ?></td>
			<td>شلن</td>
		</tr>
	<?php }} ?>
		<tr>
			<td></td>
			<td><?php echo number_format($dollar_total_expenses_t); ?></td>
			<td><?php echo number_format($dollar_debts_t); ?></td>
			<td><?php echo number_format($dollar_expenses_t); ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo number_format($dollar_cash_t); ?></td>
			<td><?php echo number_format($dollar_incomes_t); ?></td>
			<td>دولار</td>
			<td rowspan="2" style="vertical-align: middle; border-bottom: 2px solid black;">الاجمالي</td>
		</tr>
		<tr style="border-bottom: 2px solid black;">
			<td></td>
			<td><?php echo number_format($shil_total_expenses_t); ?></td>
			<td><?php echo number_format($shil_debts_t); ?></td>
			<td><?php echo number_format($shil_expenses_t); ?></td>
			<td><?php echo number_format($shil_minfo_t); ?></td>
			<td><?php echo number_format($shil_expensesm_t); ?></td>
			<td><?php echo number_format($shil_expensesr_t); ?></td>
			<td><?php echo number_format($shil_cash_t); ?></td>
			<td><?php echo number_format($shil_incomes_t); ?></td>
			<td>شلن</td>
		</tr>
</table>
<?php
$result100 = $conn->query("SELECT * FROM balances WHERE b_currency = 'دولار' AND b_year = '".$_GET['y']."'") or die($conn->error());
$row100 = $result100->fetch_assoc();
$result200 = $conn->query("SELECT * FROM balances WHERE b_currency = 'شلن' AND b_year = '".$_GET['y']."'") or die($conn->error());
$row200 = $result200->fetch_assoc();

$dollar_beggin = $row100['b_amount'];
$shil_beggin = $row200['b_amount'];

$dollar_final = $dollar_beggin + $dollar_incomes_t - $dollar_cash_t - $dollar_total_expenses_t;
$shil_final = $shil_beggin + $shil_incomes_t + $shil_cash_t - $shil_total_expenses_t;

$shil_beggin_dollar = $shil_beggin / $exchange1;
$beggin = $shil_beggin_dollar + $dollar_beggin;

$shil_incomes_dollar = $shil_incomes_t / $exchange1;

$incomes_final = $dollar_incomes_t + $shil_incomes_dollar;

$shil_expenses_final = $shil_total_expenses_t1 / $exchange1;

$expenses_final = $dollar_expenses_t + $shil_expenses_final;

if ($beggin > 0){
    $plus1 = $beggin;
    $minus1 = 0;
}else{
    $plus1 = 0;
    $minus1 = abs($beggin);
    $minus2 = number_format($minus1,'0','','');
    $minus1 = $minus2;
}

?>
<table class="table" style="position: absolute; top: 0; display: relative; width: 1107.5px; margin-top: 550px;">
	<thead>
		<th colspan="6" class="right1" style="font-size: 20px;">التقرير الاجمالي السنوي</th>
	</thead>
	<thead>
		<th class="hst cen2">الرصيد الحالي</th>
		<th class="hst cen2">اجمالي المصروفات</th>
		<th class="hst cen2">اجمالي صرف العملات</th>
		<th class="hst cen2">اجمالي الواردات</th>
		<th class="hst cen2">الرصيد المدور</th>
		<th class="hst right1">العملة</th>
	</thead>
	<tr>
		<?php if ($dollar_final < 0){ ?>
			<td style="background-color: rgb(255,185,185);">
		<?php }else{ ?>
			<td style="background-color: rgb(185,255,185);">
		<?php } ?>
		<?php echo number_format($dollar_final); ?></td>
		<td><?php echo number_format($dollar_total_expenses_t); ?></td>
		<td><?php echo number_format($dollar_cash_t); ?></td>
		<td><?php echo number_format($dollar_incomes_t); ?></td>
		<td><?php echo number_format($dollar_beggin); ?></td>
		<td class="right1">دولار</td>
	</tr>
	<tr>
		<?php if ($shil_final < 0){ ?>
			<td style="background-color: rgb(255,185,185);">
		<?php }else{ ?>
			<td style="background-color: rgb(185,255,185);">
		<?php } ?>
		<?php echo number_format($shil_final); ?></td>
		<td><?php echo number_format($shil_total_expenses_t); ?></td>
		<td><?php echo number_format($shil_cash_t); ?></td>
		<td><?php echo number_format($shil_incomes_t); ?></td>
		<td><?php echo number_format($shil_beggin); ?></td>
		<td class="right1">شلن</td>
	</tr>
</table>
<script type="text/javascript">
    window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
      text: "الايرادات والمصروفات بالدولار"
      },
        data: [
      {
        type: "stackedColumn",
        dataPoints: [
        {  y: 111338 , label: "ايرادات"},
        {  y: 49088, label: "مصروفات" },
        ]
      },  {
        type: "stackedColumn",
         dataPoints: [
        {  y: <?php echo $plus1; ?> , label: "الرصيد المدور"},
        {  y: <?php echo $minus1; ?>, label: "الرصيد المدور" },
        ]
      },  {
        type: "stackedColumn",
         dataPoints: [
        {  y: 0 , label: "ايرادات "},
        {  y: 0, label: "مصروفات" },
        ]
      }
      ]
    });

    chart.render();
  }
</script>
<div class="col col-sm-3">
	<div class="form-group">
		<a href="final_report.php?y=<?php echo $_GET['y']; ?>" class="cancel" target="_blank">طباعة</a>
		<a href="reports.php" class="cancel">رجوع</a>
	</div>
</div>
<br>
<br>
</div>
</body>
</html>
<?php }else{ ?>
<p style="font-size: 25px; color: red; font-weight: bold; text-align: center;">الرجاء اكمال بيانات التقرير</p>
<?php }}else{ ?>
<br>
<p style="font-size: 25px; color: red; font-weight: bold; text-align: center;">لاتوجد لديك صلاحية للوصول لهذه الصفحة</p>
<div style="text-align: center;">
<a href="index.php">الصفحة الرئيسية</a>
</div>
<?php }
}else{
	header("Location: login.php");
} ?>