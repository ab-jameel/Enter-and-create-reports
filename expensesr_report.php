<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 15") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){

include('tcpdf/tcpdf.php');

$pdf = new TCPDF('P','mm','A4');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetTitle('تقرير الايرادات والمصروفات');


if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=6 AND k_type=1 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
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
if ($num1 > 0 and $num2 > 0 and $num3 > 0 and $num4 > 0 and $num5 > 0 and $num6 > 0){

	$row10 = $result10->fetch_assoc();
	$row20 = $result20->fetch_assoc();
	$row11 = $result11->fetch_assoc();
	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	$tr1 = $t1->fetch_assoc();
	$ro1 = $re1->fetch_assoc();
	

	$result = $conn->query("SELECT SUM(e_amount) as t_general FROM expenses WHERE MONTH(e_date)='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."' AND e_currency = 'شلن'") or die($conn->error());
	if (empty($result)){
	$shil_general = 0;
	}else{
	$row = $result->fetch_assoc();
	$shil_general = $row['t_general'];
	}
	$result2 = $conn->query("SELECT SUM(e_amount) as t_general FROM expenses WHERE MONTH(e_date)='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."' AND e_currency = 'دولار'") or die($conn->error());
	if (empty($result2)){
	$dollar_general = 0;
	}else{
	$row2 = $result2->fetch_assoc();
	$dollar_general = $row2['t_general'];
	}
	$result3 = $conn->query("SELECT SUM(c_dollar) as t_dollar, SUM(c_dollar * c_exchange) as t_shil FROM cash WHERE MONTH(c_date)='".$_GET['m']."' AND YEAR(c_date)='".$_GET['y']."'") or die($conn->error());
	if (empty($result3)){
	$dollar_cash = 0;
	$shil_cash = 0;
	}else{
	$row3 = $result3->fetch_assoc();
	$dollar_cash = $row3['t_dollar'];
	$shil_cash = $row3['t_shil'];
	}
	$result4 = $conn->query("SELECT SUM(e_monthly * e_num) as e_total FROM expensesm INNER JOIN eitems ON e_item = eitems.ID WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."' AND i_name != 'العناية بالمهتدي'") or die($conn->error());
	if (empty($result4)){
	$expensesm = 0;
	}else{
	$row4 = $result4->fetch_assoc();
	$expensesm = $row4['e_total'];
	}
	$result5 = $conn->query("SELECT SUM(i_amount) as t_income FROM incomes WHERE MONTH(i_date)='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."' AND i_currency = 'دولار'") or die($conn->error());
	if (empty($result5)){
	$dollar_incomes = 0;
	}else{
	$row5 = $result5->fetch_assoc();
	$dollar_incomes = $row5['t_income'];
	}
	$result6 = $conn->query("SELECT SUM(i_amount) as t_income FROM incomes WHERE MONTH(i_date)='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."' AND i_currency = 'شلن'") or die($conn->error());
	if (empty($result6)){
	$shil_incomes = 0;
	}else{
	$row6 = $result6->fetch_assoc();
	$shil_incomes = $row6['t_income'];
	}
	$result7 =  $conn->query("SELECT SUM(e_monthly * e_num) as e_total FROM expensesm INNER JOIN eitems ON e_item = eitems.ID WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."' AND i_name = 'العناية بالمهتدي'") or die($conn->error());
	if (empty($result7)){
	$care = 0;
	}else{
	$row7 = $result7->fetch_assoc();
	$care = $row7['e_total'];
	}
	$result8 = $conn->query("SELECT SUM(r_amount) as r_total FROM expensesr WHERE r_year='".$_GET['y']."' AND r_month='".$_GET['m']."'") or die($conn->error());
	if (empty($result8)){
	$expensesr = 0;
	}else{
	$row8 = $result8->fetch_assoc();
	$expensesr = $row8['r_total'];
	}
	$result9 = $conn->query("SELECT SUM(m_num1 * m_coss1) + SUM(m_num2 * m_coss2) + SUM(m_coss3) + SUM(m_coss4) AS total FROM minfo WHERE m_year = '".$_GET['y']."' AND m_month='".$_GET['m']."'") or die($conn->error());
	if (empty($result9)){
	$minfo = 0;
	}else{
	$row9 = $result9->fetch_assoc();
	$minfo = $row9['total'];
	}
	$result16 = $conn->query("SELECT SUM(d_amount) AS d_amount FROM debts WHERE YEAR(d_date) = '".$_GET['y']."' AND MONTH(d_date)='".$_GET['m']."' AND d_currency = 'دولار'") or die($conn->error());
	if (empty($result16)){
	$dollar_debts = 0;
	}else{
	$row16 = $result16->fetch_assoc();
	$dollar_debts = $row16['d_amount'];
	}
	$result17 = $conn->query("SELECT SUM(d_amount) AS d_amount FROM debts WHERE YEAR(d_date) = '".$_GET['y']."' AND MONTH(d_date)='".$_GET['m']."' AND d_currency = 'شلن'") or die($conn->error());
	if (empty($result17)){
	$shil_debts = 0;
	}else{
	$row17 = $result17->fetch_assoc();
	$shil_debts = $row17['d_amount'];
	}

	$expenses_dollar = $dollar_general;
	$expenses_shil = $minfo + $expensesr + $care + $expensesm + $shil_general;



	//*********** totals
	$result = $conn->query("SELECT SUM(e_amount) as t_general FROM expenses WHERE MONTH(e_date)<='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."' AND e_currency = 'شلن'") or die($conn->error());
	if (empty($result)){
	$shil_general_total = 0;
	}else{
	$row = $result->fetch_assoc();
	$shil_general_total = $row['t_general'];
	}
	$result2 = $conn->query("SELECT SUM(e_amount) as t_general FROM expenses WHERE MONTH(e_date)<='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."' AND e_currency = 'دولار'") or die($conn->error());
	if (empty($result2)){
	$dollar_general_total = 0;
	}else{
	$row2 = $result2->fetch_assoc();
	$dollar_general_total = $row2['t_general'];
	}
	$result3 = $conn->query("SELECT SUM(c_dollar) as t_dollar, SUM(c_dollar * c_exchange) as t_shil FROM cash WHERE MONTH(c_date)<='".$_GET['m']."' AND YEAR(c_date)='".$_GET['y']."'") or die($conn->error());
	if (empty($result3)){
	$dollar_cash_total = 0;
	$shil_cash_total = 0;
	}else{
	$row3 = $result3->fetch_assoc();
	$dollar_cash_total = $row3['t_dollar'];
	$shil_cash_total = $row3['t_shil'];
	}
	$result4 = $conn->query("SELECT SUM(e_monthly * e_num) as e_total FROM expensesm WHERE e_month<='".$_GET['m']."' AND e_year='".$_GET['y']."'") or die($conn->error());
	if (empty($result4)){
	$expensesm_total = 0;
	}else{
	$row4 = $result4->fetch_assoc();
	$expensesm_total = $row4['e_total'];
	}
	$result5 = $conn->query("SELECT SUM(i_amount) as t_income FROM incomes WHERE MONTH(i_date)<='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."' AND i_currency = 'دولار'") or die($conn->error());
	if (empty($result5)){
	$dollar_incomes_total = 0;
	}else{
	$row5 = $result5->fetch_assoc();
	$dollar_incomes_total = $row5['t_income'];
	}
	$result6 = $conn->query("SELECT SUM(i_amount) as t_income FROM incomes WHERE MONTH(i_date)<='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."' AND i_currency = 'شلن'") or die($conn->error());
	if (empty($result6)){
	$shil_incomes_total = 0;
	}else{
	$row6 = $result6->fetch_assoc();
	$shil_incomes_total = $row6['t_income'];
	}
	$result8 = $conn->query("SELECT SUM(r_amount) as r_total FROM expensesr WHERE r_year='".$_GET['y']."' AND r_month<='".$_GET['m']."'") or die($conn->error());
	if (empty($result8)){
	$expensesr_total = 0;
	}else{
	$row8 = $result8->fetch_assoc();
	$expensesr_total = $row8['r_total'];
	}
	$result9 = $conn->query("SELECT SUM(m_num1 * m_coss1) + SUM(m_num2 * m_coss2) + SUM(m_coss3) + SUM(m_coss4) AS total FROM minfo WHERE m_year = '".$_GET['y']."' AND m_month<='".$_GET['m']."'") or die($conn->error());
	if (empty($result9)){
	$minfo_total = 0;
	}else{
	$row9 = $result9->fetch_assoc();
	$minfo_total = $row9['total'];
	}
	$result16 = $conn->query("SELECT SUM(d_amount) AS d_amount FROM debts WHERE YEAR(d_date) = '".$_GET['y']."' AND MONTH(d_date)<='".$_GET['m']."' AND d_currency = 'دولار'") or die($conn->error());
	if (empty($result16)){
	$dollar_debts_total = 0;
	}else{
	$row16 = $result16->fetch_assoc();
	$dollar_debts_total = $row16['d_amount'];
	}
	$result17 = $conn->query("SELECT SUM(d_amount) AS d_amount FROM debts WHERE YEAR(d_date) = '".$_GET['y']."' AND MONTH(d_date)<='".$_GET['m']."' AND d_currency = 'شلن'") or die($conn->error());
	if (empty($result17)){
	$shil_debts_total = 0;
	}else{
	$row17 = $result17->fetch_assoc();
	$shil_debts_total = $row17['d_amount'];
	}

	$expenses_dollar_total = $dollar_general_total;
	$expenses_shil_total = $minfo_total + $expensesr_total + $expensesm_total + $shil_general_total;



	$exchange = $row11['e_price'];

	$dollar_balance = $row10['b_amount'];
	$shil_balance = $row20['b_amount'];

	$dollar_total = $dollar_balance + $dollar_incomes_total - $dollar_cash_total - $dollar_general_total - $dollar_debts_total;
	$shil_total = $shil_balance + $shil_incomes_total + $shil_cash_total - $expenses_shil_total - $shil_debts_total;


	$pdf->Image($tp1['p_source'],'185','11.5',12.5,12.5);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(0,0,'                   مركز الدعوة الاسلامي',0,1,'R');
	$pdf->Ln(-1.25);
	$pdf->Cell(0,8,'                   تقرير الايرادات والمصروفات',0,1,'R');
	$pdf->SetXY(161,20.5);
	$pdf->Cell(10,5,$tr1['m_name'],0,0,'R');
	$pdf->SetTextColor(150,0,0);
	$pdf->Cell(10,5,$ro1['k_year'],0,1,'R');
	$pdf->SetXY(45,17);
	$pdf->SetFont('aealarabiya','',12);
	$pdf->SetTextColor(0,80,0);
	$pdf->Cell(5,5,'معتمد',0,0,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'حالة التقرير :',0,1,'C');
	$pdf->SetXY(20,10);
	$pdf->SetFont('aealarabiya','',9);
	$pdf->Cell(10,0,' اعداد واشراف',0,1,'C');
	$pdf->Image($tp11['p_source'],'10','14',30,10);

	$pdf->Ln(20);

	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetDrawColor(180,180,180);
	$pdf->Cell(20,5,number_format($exchange),'BTL',0,'C',1,0);
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(20,5,'سعر الصرف','BTR',1,'C',1,0);

	$pdf->Ln();
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetDrawColor(255,255,255);
	$pdf->SetFont('aealarabiya','',9);
	$pdf->Cell(70,5,'شلن',0,0,'C',1,0);
	$pdf->Cell(70,5,'دولار','L',0,'C',1,0);
	$pdf->Cell(50,5,'البند','L',1,'R',1,0);

	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(180,180,180);
	$pdf->SetFillColor(255,255,255);

	$pdf->Cell(70,5,number_format($expenses_shil),'B',0,'C',1,0);
	$pdf->Cell(70,5,number_format($expenses_dollar),'B',0,'C',1,0);
	$pdf->Cell(50,5,'اجمالي المصروفات','B',1,'R',1,0);
	$pdf->Ln(0.5);

	$pdf->Cell(70,5,number_format($minfo),'B',0,'C',1,0);
	$pdf->Cell(70,5,'','B',0,'C',1,0);
	$pdf->Cell(50,5,'المركز الاسلامي للدعوة','B',1,'R',1,0);
	$pdf->Ln(0.5);

	$pdf->Cell(70,5,number_format($expensesr),'B',0,'C',1,0);
	$pdf->Cell(70,5,'','B',0,'C',1,0);
	$pdf->Cell(50,5,'المصروفات التشغيلية','B',1,'R',1,0);
	$pdf->Ln(0.5);

	$pdf->Cell(70,5,number_format($care),'B',0,'C',1,0);
	$pdf->Cell(70,5,'','B',0,'C',1,0);
	$pdf->Cell(50,5,'العناية بالمهتدي','B',1,'R',1,0);
	$pdf->Ln(0.5);

	$pdf->Cell(70,5,number_format($expensesm),'B',0,'C',1,0);
	$pdf->Cell(70,5,'','B',0,'C',1,0);
	$pdf->Cell(50,5,'مصروفات التأسيسية والمتقدمة','B',1,'R',1,0);
	$pdf->Ln(0.5);

	$pdf->Cell(70,5,number_format($shil_general),'B',0,'C',1,0);
	$pdf->Cell(70,5,number_format($dollar_general),'B',0,'C',1,0);
	$pdf->Cell(50,5,'مصروفات عامة','B',1,'R',1,0);
	$pdf->Ln(0.5);

	$pdf->Cell(70,5,number_format($shil_cash),'B',0,'C',1,0);
	$pdf->Cell(70,5,number_format($dollar_cash),'B',0,'C',1,0);
	$pdf->Cell(50,5,'صرف العملات','B',1,'R',1,0);
	$pdf->Ln(0.5);

	$pdf->Cell(70,5,number_format($shil_incomes),0,0,'C',1,0);
	$pdf->Cell(70,5,number_format($dollar_incomes),0,0,'C',1,0);
	$pdf->Cell(50,5,'اجمالي الواردات',0,1,'R',1,0);
	$pdf->Ln(0.5);


	$pdf->SetLineStyle(array('width' => 0.35, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

	$pdf->Cell(70,5,number_format($shil_total),'BT',0,'C',1,0);
	$pdf->Cell(70,5,number_format($dollar_total),'BT',0,'C',1,0);
	$pdf->SetFillColor(235,235,235);
	$pdf->Cell(50,5,'رصيد الصندوق','BT',1,'C',1,0);
	$pdf->Ln(0.5);



	$pdf->SetTextColor(0,0,0);

	$result = $conn->query("SELECT * FROM cash WHERE MONTH(c_date)='".$_GET['m']."' AND YEAR(c_date)='".$_GET['y']."'") or die($conn->error());

	$num100 = mysqli_num_rows($result);

	$pdf->SetXY(10,115);

	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetFillColor(235,235,235);
	$pdf->Cell(80,5,'خاص بصرف العملة','BT',1,'C',1,0);
	$pdf->Ln(0.5);


	$pdf->SetFillColor(255,255,255);
	$pdf->SetLineStyle(array('width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(180, 180, 180)));

	$pdf->SetFont('aealarabiya','',9);
	$pdf->Cell(20,5,'المبلغ بالشلن','B',0,'C',1,0);
	$pdf->Cell(20,5,'سعر الصرف','B',0,'C',1,0);
	$pdf->Cell(20,5,'المبلغ بالدولار','B',0,'C',1,0);
	$pdf->Cell(20,5,'رقم الفاتورة','B',1,'C',1,0);
	$pdf->Ln(0.5);

	$pdf->SetFont('aealarabiya','',8);
while ($row = $result->fetch_assoc()){
	$shil = $row['c_exchange'] * $row['c_dollar'];
	$pdf->Cell(20,5,number_format($shil),'B',0,'C',1,0);
	$pdf->Cell(20,5,number_format($row['c_exchange']),'B',0,'C',1,0);
	$pdf->Cell(20,5,number_format($row['c_dollar']),'B',0,'C',1,0);
	$pdf->Cell(20,5,$row['c_number'],'B',1,'C',1,0);
	$pdf->Ln(0.5);

}

	$result = $conn->query("SELECT * FROM incomes WHERE MONTH(i_date)='".$_GET['m']."' AND YEAR(i_date)='".$_GET['y']."'") or die($conn->error());

	$num101 = mysqli_num_rows($result);

	$pdf->SetXY(95,115);

	$pdf->SetFillColor(235,235,235);
	$pdf->SetLineStyle(array('width' => 0.35, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(60,5,'خاص بالواردات والايرادات','BT',1,'C',1,0);

	$pdf->SetFillColor(255,255,255);
	$pdf->SetLineStyle(array('width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(180, 180, 180)));

	$pdf->SetFont('aealarabiya','',9);
	$pdf->SetXY(95,120.5);
	$pdf->Cell(20,5,'المبلغ','B',0,'C',1,0);
	$pdf->Cell(20,5,'العملة','B',0,'C',1,0);
	$pdf->Cell(20,5,'رقم السند','B',0,'C',1,0);

	$y = 126;

	$pdf->SetFont('aealarabiya','',8);
while ($row = $result->fetch_assoc()){
	$pdf->SetXY(95,$y);
	$pdf->Cell(20,5,number_format($row['i_amount']),'B',0,'C',1,0);
	$pdf->Cell(20,5,$row['i_currency'],'B',0,'C',1,0);
	$pdf->Cell(20,5,$row['i_number'],'B',1,'C',1,0);

	$y = $y + 5.5;
}

	$result = $conn->query("SELECT * FROM expensesr INNER JOIN ritems ON expensesr.r_item = ritems.ID WHERE r_month='".$_GET['m']."' AND r_year='".$_GET['y']."'") or die($conn->error());

	$num102 = mysqli_num_rows($result);

	$pdf->SetXY(160,115);

	$pdf->SetFillColor(235,235,235);
	$pdf->SetLineStyle(array('width' => 0.35, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(40,5,'خاص بالمصروفات التشغيلية','BT',1,'C',1,0);

	$pdf->SetFillColor(255,255,255);
	$pdf->SetLineStyle(array('width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(180, 180, 180)));

	$pdf->SetFont('aealarabiya','',9);
	$pdf->SetXY(160,120.5);
	$pdf->Cell(20,5,'المبلغ بالشلن','B',0,'C',1,0);
	$pdf->Cell(20,5,'النشاط','B',1,'R',1,0);

	$pdf->SetFont('aealarabiya','',8);
	$y = 126;
while ($row = $result->fetch_assoc()){
	$pdf->SetXY(160,$y);
	$pdf->Cell(20,5,number_format($row['r_amount']),'B',0,'C',1,0);
	$pdf->Cell(20,5,$row['i_name'],'B',1,'R',1,0);
	$y = $y + 5.5;
}

$nums = array($num100, $num101, $num102);

$max1 = max($nums);

$max2 = $max1 * 5;

	$pdf->Ln($max2);

	$result = $conn->query("SELECT * FROM expenses WHERE MONTH(e_date)='".$_GET['m']."' AND YEAR(e_date)='".$_GET['y']."'") or die($conn->error());


	$pdf->SetFillColor(235,235,235);
	$pdf->SetLineStyle(array('width' => 0.35, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(190,5,'مصروفات عامة','BT',1,'C',1,0);
	$pdf->Ln(0.5);

	$pdf->SetFillColor(255,255,255);
	$pdf->SetLineStyle(array('width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(180, 180, 180)));

	$pdf->SetFont('aealarabiya','',9);
	$pdf->Cell(70,5,'البيان','B',0,'C',1,0);
	$pdf->Cell(35,5,'التصنيف','B',0,'C',1,0);
	$pdf->Cell(25,5,'العملة','B',0,'C',1,0);
	$pdf->Cell(35,5,'القيمة','B',0,'C',1,0);
	$pdf->Cell(25,5,'التاريخ','B',1,'C',1,0);
	$pdf->Ln(0.5);

	$pdf->SetFont('aealarabiya','',8);
while ($row = $result->fetch_assoc()){
	$pdf->Cell(70,5,$row['e_notice'],'B',0,'C',1,0);
	$pdf->Cell(35,5,$row['e_comparison'],'B',0,'C',1,0);
	$pdf->Cell(25,5,$row['e_currency'],'B',0,'C',1,0);
	$pdf->Cell(35,5,number_format($row['e_amount']),'B',0,'C',1,0);
	$pdf->Cell(25,5,$row['e_date'],'B',1,'C',1,0);
	$pdf->Ln(0.5);
}


}else{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',40);
	$pdf->SetTextColor(200,0,0);
	$pdf->Cell(190,15,'الرجاء اكمال بيانات التقرير',0,1,'C',1,0);
}
}
$pdf->output('expensesr_report_'.$_GET['m'].'_'.$_GET['y'].'.pdf');
}else{
echo '<link rel="icon" type="image/png" href="images/new.bmp"/>';
echo '<title>تقرير الايرادات والمصروفات</title>';
echo '<br>';
echo '<p style="font-size: 25px; color: red; font-weight: bold; text-align: center;">لاتوجد لديك صلاحية للوصول لهذه الصفحة</p>';
echo '<div style="text-align: center;">';
echo '<a href="index.php">الصفحة الرئيسية</a>';
echo '</div>';
}
}else{
	header("Location: login.php");
}
?>