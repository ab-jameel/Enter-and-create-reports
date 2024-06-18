<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

include('tcpdf/tcpdf.php');

$pdf = new TCPDF('P','mm','A4');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetTitle('تقرير الانجازات الشهرية');


if (isset($_GET['m']) and isset($_GET['y'])){
	require_once 'connect.php';
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=10 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());

	$result1 =  $conn->query("SELECT SUM(b_countm) as b_countm FROM rprograms WHERE b_month='".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
	$row1 = $result1->fetch_assoc();
	$countm_m = $row1['b_countm'];

	$result2 =  $conn->query("SELECT SUM(b_countm) as b_countm FROM rprograms WHERE b_month<='".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
	$row2 = $result2->fetch_assoc();
	$countm_y = $row2['b_countm'];

	$result4 =  $conn->query("SELECT SUM(c_dev) as c_dev FROM countc WHERE c_month='".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row4 = $result4->fetch_assoc();
	$count_dev = $row4['c_dev'];

	if($_GET['m'] <= 4){
	$result9 =  $conn->query("SELECT SUM(c_dev) as c_dev FROM countc WHERE c_month<='".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row9 = $result9->fetch_assoc();
	$count_dev_t = $row9['c_dev'] / $_GET['m'];
	}elseif ($_GET['m'] > 4 && $_GET['m'] <= 8) {
	$result9 =  $conn->query("SELECT SUM(c_dev) as c_dev FROM countc WHERE c_month BETWEEN 5 AND '".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row9 = $result9->fetch_assoc();
	$month1 = $_GET['m'] - 4;
	$count_dev_t = $row9['c_dev'] / $month1;	
	}elseif ($_GET['m'] > 8) {
	$result9 =  $conn->query("SELECT SUM(c_dev) as c_dev FROM countc WHERE c_month BETWEEN 9 AND '".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row9 = $result9->fetch_assoc();
	$month2 = $_GET['m'] - 8;
	$count_dev_t = $row9['c_dev'] / $month2;	
	}
	
	$result5 =  $conn->query("SELECT SUM(c_student) as c_student FROM countc WHERE c_month='".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row5 = $result5->fetch_assoc();
	$count_student = $row5['c_student'];

	$result6 =  $conn->query("SELECT AVG(c_student) as c_student FROM countc WHERE c_month<='".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row6 = $result6->fetch_assoc();
	$count_student_a = number_format($row6['c_student'],0,'','');

	$result7 =  $conn->query("SELECT SUM(c_learn) as c_learn FROM countc WHERE c_month='".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row7 = $result7->fetch_assoc();
	$count_learn = $row7['c_learn'];

	$result8 =  $conn->query("SELECT SUM(c_learn) as c_learn FROM countc WHERE c_month<='".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row8 = $result8->fetch_assoc();
	$count_learn_t = $row8['c_learn'];


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


	$exchange = $row17['e_price'];
	$e_total = $row20['s_total'] + $row30['s_total'] + $row21['s_monthly'] + $row22['p_monthly'];
	$real = $e_total / $exchange;
	if(empty($row23['c_amount'])){
		$row23['c_amount'] = 0;
	}
	if(empty($row24['c_amount'])){
		$row24['c_amount'] = 0;
	}
	$t_com = $row23['c_amount'] + $row24['c_amount'];
	$t_com = $t_com / 12;
	$dif = $t_com - $real;
	if($t_com > 0){
	$perc = $real / $t_com;
	}else{
	$perc = 0;
	}
	$perc = $perc * 100;

	$pdf->Image($tp1['p_source'],'175','',20,20);
	$pdf->SetFont('aealarabiya','',14);
	$pdf->SetX(145);
	$pdf->Cell(25,0,'مركز الدعوة الاسلامي',0,1,'R');
	$pdf->SetX(145);
	$pdf->Cell(25,8,'التقرير الميداني',0,1,'R');
	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetX(145);
	$pdf->Cell(15,6,$tr1['m_name'],0,0,'R');
	$pdf->Cell(10,7,$ro1['k_year'],0,1,'R');
	$pdf->Ln(3);
	if($ro1['k_type'] == 1){
	$pdf->Rect(75,10,45,23,'D');
	$pdf->SetXY(75,10.5);
	$k_type = 'تم الموافقة والاعتماد';
	}else{
	$pdf->SetXY(75,18.5);
	$k_type = 'غير معتمد';
	$pdf->SetTextColor(200,0,0);
	}
	$pdf->SetFont('aealarabiya','',12);
	$pdf->Cell(45,5,$k_type,0,1,'C');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetXY(75,16.5);
	$pdf->Cell(45,5,$k_person,0,1,'C');
	$pdf->SetFont('aealarabiya','',12);
	$pdf->SetXY(15,11.5);
	$pdf->Cell(35,0,' اعداد واشراف',0,1,'C');
	$pdf->Image($tp11['p_source'],'15.5','17.5',35,15);
	$pdf->SetXY(75,21.5);
	$pdf->SetFont('aealarabiya','',5);
	$pdf->Cell(45,5,$k_email,0,1,'C');
	$pdf->SetXY(75,26.5);
	$pdf->Cell(45,5,$k_time,0,1,'C');

	$pdf->Ln(17.5);
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetDrawColor(255,255,255);
	$pdf->SetFont('aealarabiya','',9);
	$pdf->Cell(25,5,'الحركة',0,0,'C',1,0);
	$pdf->Cell(20,5,'نسبة الصرف','L',0,'C',1,0);
	$pdf->Cell(20,5,'الفرق','L',0,'C',1,0);
	$pdf->Cell(20,5,'الموازنة الشهرية','L',0,'C',1,0);
	$pdf->Cell(30,5,'الصرف الفعلي بالدولار','L',0,'C',1,0);
	$pdf->Cell(20,5,'سعر الصرف','L',0,'C',1,0);
	$pdf->Cell(25,5,'المجموع بالشلن','L',1,'C',1,0);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(180,180,180);
	if ($perc >= 100){
	$pdf->SetFillColor(255,180,185);
	$text = "فوق الموازنة";
	}else{
	$pdf->SetFillColor(185,255,185);
	$text = "تحت الموازنة";
	}
	$pdf->Cell(25,5,$text,'LB',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(20,5,number_format($perc).' %','LB',0,'C',1,0);
	$pdf->Cell(20,5,number_format($dif),'LB',0,'C',1,0);
	$pdf->Cell(20,5,number_format($t_com),'LB',0,'C',1,0);
	$pdf->Cell(30,5,number_format($real),'LB',0,'C',1,0);
	$pdf->Cell(20,5,number_format($exchange),'LB',0,'C',1,0);
	$pdf->Cell(25,5,number_format($e_total),'LB',0,'C',1,0);
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetDrawColor(255,255,255);
	$pdf->Cell(30,10,'الحركة الشهرية','L',1,'C',1,0, 0, false, 'C');


	$border = array(
	'L' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)),
	'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));


	$border2 = array(
	'L' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)),
	'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)),
	'B' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

	$border3 = array(
	'T' => array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)),
	'B' => array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

	$pdf->Ln(6);
	$pdf->SetTextColor(0,0,0);
while ($row = $result->fetch_assoc()){

	$result12 = $conn->query("SELECT SUM(e_monthly * e_num) as s_total FROM expensesm INNER JOIN eitems ON eitems.ID = expensesm.e_item WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."' AND e_markaz='".$row['ID']."' AND i_type = 1") or die($conn->error());
	$result13 = $conn->query("SELECT SUM(e_monthly) as s_total FROM expensesm INNER JOIN eitems ON eitems.ID = expensesm.e_item WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."' AND e_markaz='".$row['ID']."' AND i_type = 2") or die($conn->error());
	$result7 = $conn->query("SELECT SUM(s_every * s_num) as s_monthly, SUM(s_num) as s_num FROM salary WHERE s_month='".$_GET['m']."' AND s_year='".$_GET['y']."' AND s_markaz='".$row['ID']."'") or die($conn->error());
	$result11 = $conn->query("SELECT SUM(p_price) as p_monthly FROM portions WHERE p_month='".$_GET['m']."' AND p_year='".$_GET['y']."' AND p_markaz='".$row['ID']."'") or die($conn->error());
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



	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(20,5,'المجموع',$border3,0,'C',1,0);
	$pdf->SetFillColor(255,255,255);

	$result82 = $conn->query("SELECT DISTINCT eitems.id, eitems.i_name, eitems.i_type FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=1 ORDER BY expensesm.ID DESC LIMIT ".$num88) or die($conn->error());

	$result83 = $conn->query("SELECT DISTINCT eitems.id, eitems.i_name, eitems.i_type FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());


	$pdf->SetFont('aealarabiya','',7);
	while ($row82 = $result82->fetch_assoc()){
	$pdf->Cell($wid,5,$row82['i_name'],$border3,0,'C',1,0);
	}
	$pdf->Cell(15,5,'عدد العاملين',$border3,0,'C',1,0);
	while ($row83 = $result83->fetch_assoc()){
	$pdf->Cell($wid,5,$row83['i_name'],$border3,0,'C',1,0);
	}
	$pdf->Cell(10,5,'التغذية',$border3,0,'C',1,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'البند',$border3,0,'C',1,0);
	$pdf->Cell(15,5,'المركز',$border3,1,'C',1,0);
	$pdf->Ln(0.4);

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


	$pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)));

	$pdf->SetFont('aealarabiya','',9);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(20,5,number_format($row5['total']),0,0,'C',1,0);
	$pdf->SetFillColor(255,255,255);

	$result2 = $conn->query("SELECT expensesm.e_num FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());
	$result6 = $conn->query("SELECT expensesm.e_monthly FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.ID WHERE expensesm.e_month='".$_GET['m']."' AND expensesm.e_year='".$_GET['y']."' AND expensesm.e_markaz='".$row['ID']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=1 ORDER BY expensesm.ID DESC LIMIT ".$num88) or die($conn->error());



	$pdf->SetFont('aealarabiya','',7);
	while ($row6 = $result6->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row6['e_monthly']),0,0,'C',1,0);
	}
	$pdf->Cell(15,5,number_format($row7['s_num']),0,0,'C',1,0);
	while ($row2 = $result2->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row2['e_num']),0,0,'C',1,0);
	}
	$pdf->Cell(10,5,number_format($row5['total']),0,0,'C',1,0);


	$pdf->SetFont('aealarabiya','',8);
	$pdf->Cell(20,5,'العدد',0,0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->MultiCell(15,15,$row['mname'],'B','C',1,1, '', '', true, 0, false, true, 15, 'M');

	$pdf->Ln(-10.25);
	$pdf->SetFillColor(255,255,255);
	$result6 = $conn->query("SELECT DISTINCT eitems.id, eitems.i_name FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=1 ORDER BY expensesm.ID DESC LIMIT ".$num88." OFFSET ".$num88) or die($conn->error());
	$result2 = $conn->query("SELECT expensesm.e_monthly / expensesm.e_num as every FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());
	$result10 = $conn->query("SELECT expensesm.e_monthly / expensesm.e_num as every FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());


	$pdf->SetFont('aealarabiya','',9);
	$pdf->SetFillColor(240,240,240);
	if ($row5['total'] > 0){
	$pdf->Cell(20,5,number_format($f_total / $row5['total']),'TB',0,'C',1,0);
	}else{
	$pdf->Cell(20,5,0,'TB',0,'C',1,0);
	}
	$pdf->SetFillColor(255,255,255);

	if (($num8 % 2) != 0){
	$num100 = $num88 - 1;
	$rep = $wid / $num100;
	$wid2 = $wid + $rep;
	}else{
	$wid2 = $wid;
	}
	$pdf->SetFont('aealarabiya','',7);
	while ($row6 = $result6->fetch_assoc()){
	$pdf->Cell($wid2,5,$row6['i_name'],'TB',0,'C',1,0);
	}

	$pdf->Cell(15,5,'اجمالي الرواتب','TB',0,'C',1,0);
	while ($row2 = $result2->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row2['every']),'TB',0,'C',1,0);
	}
	if ($row5['total'] > 0){
	$pdf->Cell(10,5,number_format($row11['p_monthly'] / $row5['total']),'TB',0,'C',1,0);
	}else{
	$pdf->Cell(10,5,0,'TB',0,'C',1,0);
	}

	$pdf->SetFont('aealarabiya','',8);
	$pdf->Cell(20,5,'التكلفة الفردية','TB',1,'C',1,0);
	$pdf->Ln(0.25);

	$result2 = $conn->query("SELECT expensesm.e_monthly FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.id WHERE expensesm.e_year='".$_GET['y']."' AND expensesm.e_month='".$_GET['m']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=2 ORDER BY expensesm.ID DESC") or die($conn->error());
	$result6 = $conn->query("SELECT expensesm.e_monthly FROM expensesm INNER JOIN eitems ON expensesm.e_item = eitems.ID WHERE expensesm.e_month='".$_GET['m']."' AND expensesm.e_year='".$_GET['y']."' AND expensesm.e_markaz='".$row['ID']."' AND expensesm.e_markaz='".$row['ID']."' AND eitems.i_type=1 ORDER BY expensesm.ID DESC LIMIT ".$num88." OFFSET ".$num88) or die($conn->error());


	if ($com > 0){
	$percent = $d_total / $com;
	}else{
	$percent = 0;
	}
	$percent = $percent * 100;


	$pdf->SetFont('aealarabiya','',9);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(20,5,number_format($f_total),0,0,'C',1,0);
	$pdf->SetFillColor(255,255,255);

	$pdf->SetFont('aealarabiya','',6.5);
	while ($row6 = $result6->fetch_assoc()){
	$pdf->Cell($wid2,5,number_format($row6['e_monthly']),'B',0,'C',1,0);
	}
	$pdf->Cell(15,5,number_format($row7['s_monthly']),'B',0,'C',1,0);
	while ($row2 = $result2->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row2['e_monthly']),'B',0,'C',1,0);
	}
	$pdf->Cell(10,5,number_format($row11['p_monthly']),'B',0,'C',1,0);
	$pdf->SetFont('aealarabiya','',8);
	$pdf->Cell(20,5,'التكلفة الشهرية',0,1,'C',1,0);




	if ($percent >= 100){
	$pdf->SetFillColor(255,180,185);
	$text = "فوق الموازنة";
	}else{
	$pdf->SetFillColor(185,255,185);
	$text = "تحت الموازنة";
	}

	$pdf->Cell(20,5,$text,$border3,0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(20,5,'الحركة',$border3,0,'C',1,0);

	if ($percent >= 100){
	$pdf->SetTextColor(150,0,0);
	}else{
	$pdf->SetTextColor(0,80,0);
	}

	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,number_format($percent).' %',$border3,0,'C',1,0);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(25,5,'نسبة الصرف',$border3,0,'C',1,0);

	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,number_format($d_total).' $',$border3,0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(25,5,'الاجمالي بالدولار',$border3,0,'C',1,0);

	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,number_format($com).' $',$border3,0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(25,5,'الموازنة المحددة',$border3,1,'C',1,0);

	$pdf->Ln(3);
}




}else{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',40);
	$pdf->SetTextColor(200,0,0);
	$pdf->Cell(190,15,'الرجاء اكمال بيانات التقرير',0,1,'C',1,0);
}
}
$pdf->output('achievements_report_'.$_GET['m'].'_'.$_GET['y'].'.pdf');
}else{
	header("Location: login.php");
}
?>