<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 3") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){

include('tcpdf/tcpdf.php');

$pdf = new TCPDF('P','mm','A4');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetTitle('تقرير مصروفات التأسيسية');


if (isset($_GET['m']) and isset($_GET['y'])){
	require_once 'connect.php';
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=5 AND k_type=1 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
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
if ($num1 > 0 and $num2 > 0 and $num3 > 0 and $num4 > 0 and $num5 > 0 and $num6 > 0 and $num7 > 0){

	$num88 = $num8 / 2;
	$num88 = number_format($num88);
	$num9 = $num88 + $num81;
	if ($num9 > 0){
	$wid =  110 / $num9;
	}else{
	$wid = 0;
	}

	$result20 = $conn->query("SELECT SUM(e_monthly) as s_total FROM expensesm WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."'") or die($conn->error());
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
	$row21 = $result21->fetch_assoc();
	$row22 = $result22->fetch_assoc();
	$row23 = $result23->fetch_assoc();
	$row24 = $result24->fetch_assoc();


	$exchange = $row17['e_price'];
	$e_total = $row20['s_total'] + $row21['s_monthly'] + $row22['p_monthly'];
	$real = $e_total / $exchange;
	$t_com = $row23['c_amount'] + $row24['c_amount'];
	$t_com = $t_com / 12;
	$dif = $t_com - $real;
	$perc = $real / $t_com;
	$perc = $perc * 100;

	$pdf->Image($tp1['p_source'],'185','11.5',12.5,12.5);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(0,0,'                   مركز الدعوة الاسلامي',0,1,'R');
	$pdf->Ln(-1.25);
	$pdf->Cell(0,8,'                   تقرير مصروفات التأسيسية',0,1,'R');
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
;

	$pdf->Ln(6);
	$pdf->SetTextColor(0,0,0);
while ($row = $result->fetch_assoc()){

	$result12 = $conn->query("SELECT SUM(e_monthly) as s_total FROM expensesm WHERE e_year='".$_GET['y']."' AND e_month='".$_GET['m']."' AND e_markaz='".$row['ID']."'") or die($conn->error());
	$result7 = $conn->query("SELECT SUM(salary.s_every * salary.s_num) as s_monthly, SUM(salary.s_num) as s_num FROM salary WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."'") or die($conn->error());
	$result11 = $conn->query("SELECT SUM(portions.p_price) as p_monthly FROM portions WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."'") or die($conn->error());
	$result5 = $conn->query("SELECT c_learn + c_dev as total FROM countc WHERE c_month='".$_GET['m']."' AND c_year='".$_GET['y']."' AND c_markaz='".$row['ID']."'") or die($conn->error());
	$row5 = $result5->fetch_assoc();
	$row7 = $result7->fetch_assoc();
	$row11 = $result11->fetch_assoc();
	$row12 = $result12->fetch_assoc();

	if (empty($row5['total'])) {
		$row5['total'] = 0;
	}

	$f_total = $row12['s_total'] + $row7['s_monthly'] + $row11['p_monthly'];

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

	$pdf->SetFont('aealarabiya','',7);
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
$pdf->output('expensesm_report_'.$_GET['m'].'_'.$_GET['y'].'.pdf');
}else{
echo '<link rel="icon" type="image/png" href="images/new.bmp"/>';
echo '<title>تقرير مصروفات التأسيسية</title>';
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