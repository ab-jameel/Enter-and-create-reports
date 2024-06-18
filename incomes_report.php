<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 19") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){

include('tcpdf/tcpdf.php');

$pdf = new TCPDF('P','mm','A4');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetTitle('تقرير الايرادات');


if (isset($_GET['y'])){
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$result1 =  $conn->query("SELECT SUM(i_amount) as d_total FROM incomes WHERE YEAR(i_date)='".$_GET['y']."' AND i_currency = 'دولار'") or die($conn->error());
	$result2 = $conn->query("SELECT SUM(i_amount) as s_total FROM incomes WHERE YEAR(i_date)='".$_GET['y']."' AND i_currency = 'شلن'") or die($conn->error());
	$result3 = $conn->query("SELECT * FROM exchange WHERE e_month=1 AND e_year='".$_GET['y']."'") or die($conn->error());

$num3 = mysqli_num_rows($result3);
if ($num3 > 0){

if (empty($result1)){
	$dollar_total = 0;
}else{
	$row1 = $result1->fetch_assoc();
	$dollar_total = $row1['d_total'];
}


if (empty($result2)){
	$shil_total = 0;
}else{
	$row2 = $result2->fetch_assoc();
	$shil_total = $row2['s_total'];
}

	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	$row3 = $result3->fetch_assoc();

	$exchange = $row3['e_price'];
	$t_shil = $shil_total / $exchange;
	$total = $t_shil + $dollar_total;


	$pdf->Image($tp1['p_source'],'175','',22.5,22.5);
	$pdf->SetFont('aealarabiya','',14);
	$pdf->SetX(145);
	$pdf->Cell(25,0,'مركز الدعوة الاسلامي',0,1,'R');
	$pdf->SetX(145);
	$pdf->Cell(25,8,'تقرير الايرادات',0,1,'R');
	$pdf->SetFont('aealarabiya','',12);
	$pdf->Cell(149,7,$_GET['y'],0,0,'R');
	$pdf->SetFont('aealarabiya','',14);
	$pdf->Cell(10,7,'لعام',0,1,'R');
	$pdf->Ln(3);
	$pdf->SetFont('aealarabiya','',12);
	$pdf->SetXY(25,11);
	$pdf->Cell(25,0,' اعداد واشراف',0,1,'C');
	$pdf->Image($tp11['p_source'],'20','',35,15);


	$pdf->Ln(25);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetDrawColor(255,255,255);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(40,5,'المجموع بالدولار','L',0,'C',1,0);
	$pdf->Cell(40,5,'شلن','L',0,'C',1,0);
	$pdf->Cell(40,5,'دولار','L',0,'C',1,0);
	$pdf->Cell(40,5,'سعر الصرف','L',1,'C',1,0);

	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(180,180,180);
	
	$pdf->Cell(40,5,number_format($total),'LB',0,'C',1,0);
	$pdf->Cell(40,5,number_format($shil_total),'LB',0,'C',1,0);
	$pdf->Cell(40,5,number_format($dollar_total),'LB',0,'C',1,0);
	$pdf->Cell(40,5,number_format($exchange),'LB',0,'C',1,0);
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetDrawColor(255,255,255);
	$pdf->Cell(30,10,'حركة الايرادات','L',1,'C',1,0, 0, false, 'C');


	$pdf->Ln();


	//**table head
	$pdf->SetFillColor(230,230,230);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(27,5,'رقم سند القبض','TB',0,'C',1,0);
	$pdf->Cell(29,5,'ما يعادل بالدولار','TB',0,'C',1,0);
	$pdf->Cell(31,5,'مبلغ الايراد','TB',0,'C',1,0);
	$pdf->Cell(27,5,'العملة','TB',0,'C',1,0);
	$pdf->Cell(28,5,'البيان','TB',0,'C',1,0);
	$pdf->Cell(27,5,'التاريخ','TB',0,'C',1,0);
	$pdf->Cell(20,5,'الرقم','TB',1,'C',1,0);

	$result1 =  $conn->query("SELECT * FROM incomes WHERE YEAR(i_date)='".$_GET['y']."' ORDER BY i_date ASC") or die($conn->error());

	$pdf->SetFillColor(255,255,255);
	$pdf->SetDrawColor(180,180,180);
	$pdf->SetFont('aealarabiya','',8.5);

	$n = 1;
while ($row = $result1->fetch_assoc()){
	
	//**table cells
	$pdf->Ln(0.2);
	$pdf->Cell(27,5,$row['i_number'],'B',0,'C');
	if ($row['i_currency'] == 'شلن'){
	$pdf->Cell(29,5,number_format($row['i_amount'] / $exchange),'B',0,'C');
	}else{
	$pdf->Cell(29,5,'','B',0,'C');
	}
	$pdf->Cell(31,5,number_format($row['i_amount']),'B',0,'C');
	$pdf->Cell(27,5,$row['i_currency'],'B',0,'C');
	$pdf->Cell(28,5,'دفعة مستلمة','B',0,'C');
	$pdf->Cell(27,5,$row['i_date'],'B',0,'C',1,0);
	$pdf->Cell(20,5,$n,'B',1,'C',1,0);

	$n = $n + 1;
}

}else{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',40);
	 $pdf->SetTextColor(200,0,0);
	$pdf->Cell(190,15,'الرجاء اكمال بيانات التقرير',0,1,'C',1,0);
}
}
$pdf->output('incomes_report_'.$_GET['y'].'.pdf');
}else{
echo '<link rel="icon" type="image/png" href="images/new.bmp"/>';
echo '<title>تقرير الايرادات</title>';
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