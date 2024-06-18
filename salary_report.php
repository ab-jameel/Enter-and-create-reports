<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 2") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){

include('tcpdf/tcpdf.php');

$pdf = new TCPDF('P','mm','A4');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetTitle('مسير الرواتب');


if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=4 AND k_type=1 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
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
	$pdf->Image($tp1['p_source'],'135','',20,20);
	$pdf->SetFont('aealarabiya','',14);
	$pdf->Cell(0,0,'مركز الدعوة الاسلامي',0,1,'R');
	$pdf->Cell(0,8,'مسير الرواتب',0,1,'R');
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(180,6,$tr1['m_name'],0,0,'R');
	$pdf->Cell(10,7,$ro1['k_year'],0,1,'R');
	$pdf->Ln(3);
	$pdf->Rect(15,10,45,23,'D');
	$pdf->SetXY(15,10.5);
	$pdf->SetFont('aealarabiya','',12);
	$pdf->Cell(45,5,'تم الموافقة والاعتماد',0,1,'C');
	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetXY(15,16.5);
	$pdf->Cell(45,5,$ro1['k_person'],0,1,'C');
	$pdf->SetFont('aealarabiya','',12);
	$pdf->SetXY(85,12.5);
	$pdf->Cell(35,0,' اعداد واشراف',0,1,'C');
	$pdf->Image($tp11['p_source'],'82.5','17.5',35,15);
	$pdf->SetXY(15,22.5);
	$pdf->SetFont('aealarabiya','',5);
	$pdf->Cell(45,5,$ro1['k_email'],0,1,'C');
	$pdf->SetXY(15,26.5);
	$pdf->Cell(45,5,$ro1['k_time'],0,1,'C');

	$pdf->Ln(9);
	$pdf->SetFont('aealarabiya','',9);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,number_format($portion),'TB',0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(25,5,'المصروفات بالدولار','TB',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,number_format($exchange),'TB',0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(25,5,'سعر الصرف','TB',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(30,5,number_format($s_monthly),'TB',0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(25,5,'الاجمالي بالشلن','TB',0,'C',1,0);
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(35,5,'الحركة الاجمالية الشهرية',1,1,'C',1,0);

	$pdf->SetTextColor(0,0,0);
while ($row = $result->fetch_assoc()){
	$pdf->Ln(3);
	$result2 = $conn->query("SELECT DISTINCT sitems.i_name FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."' ORDER BY sitems.ID DESC") or die($conn->error());
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',10);
	$result6 = $conn->query("SELECT SUM(salary.s_every * salary.s_num) as s_monthly, SUM(salary.s_num) as s_num FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."'") or die($conn->error());
	$row6 = $result6->fetch_assoc();
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,number_format($row6['s_monthly']),0,0,'C',1,0);
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(25,5,'الاجمالي بالشلن',0,0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	if ($exchange > 0){
	$pdf->Cell(25,5,number_format($row6['s_monthly'] / $exchange),0,0,'C',1,0);
	}else{
	$pdf->Cell(25,5,0,0,0,'C',1,0);
	}
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(25,5,'الاجمالي بالدولار',0,0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,number_format($row6['s_num']),0,0,'C',1,0);
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(25,5,'عدد العاملين',0,0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',13);
	$pdf->Cell(40,5,$row['mname'],'B',1,'R',1,0);
	$pdf->SetFont('aealarabiya','',10);
	while ($row2 = $result2->fetch_assoc()){
	$pdf->MultiCell($wid,5,$row2['i_name'],'TB','C',0,0);
	}
	$pdf->MultiCell(25,5,'البند','TB','C',0,1);
	
	$pdf->SetFillColor(255,255,255);
	$result3 = $conn->query("SELECT salary.s_num FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."' ORDER BY sitems.ID DESC") or die($conn->error());
	while ($row3 = $result3->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row3['s_num']),'TB',0,'C',1,0);	
	}
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(25,5,'العدد','TB',1,'C',1,0);
	
	$pdf->SetFillColor(255,255,255);
	$result4 = $conn->query("SELECT salary.s_every FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."' ORDER BY sitems.ID DESC") or die($conn->error());
	while ($row4 = $result4->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row4['s_every']),'TB',0,'C',1,0);	
	}
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(25,5,'التكلفة الفردية','TB',1,'C',1,0);

	$pdf->SetFillColor(255,255,255);
	$result5 = $conn->query("SELECT salary.s_every,salary.s_num FROM salary INNER JOIN sitems ON salary.s_item = sitems.ID WHERE salary.s_month='".$_GET['m']."' AND salary.s_year='".$_GET['y']."' AND salary.s_markaz='".$row['ID']."' ORDER BY sitems.ID DESC") or die($conn->error());
	while ($row5 = $result5->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row5['s_every'] * $row5['s_num']),'TB',0,'C',1,0);	
	}
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(25,5,'التكلفة الشهرية','TB',1,'C',1,0);
}
}
}
$pdf->output('salary_report_'.$_GET['m'].'_'.$_GET['y'].'.pdf');
}else{
echo '<link rel="icon" type="image/png" href="images/new.bmp"/>';
echo '<title>مسير الرواتب</title>';
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