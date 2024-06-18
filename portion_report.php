<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 4") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){

include('tcpdf/tcpdf.php');

$pdf = new TCPDF('P','mm','A4');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetTitle('تقرير نصيب الفرد');


if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=3 AND k_type=1 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$result = $conn->query("SELECT DISTINCT marakez.mname, marakez.ID FROM portions INNER JOIN marakez ON marakez.ID = portions.p_markaz WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY ID ASC") or die($conn->error());
	$result7 =  $conn->query("SELECT * FROM portions WHERE p_month='".$_GET['m']."' AND p_year='".$_GET['y']."'") or die($conn->error());
	$result8 = $conn->query("SELECT DISTINCT items.id, items.i_name FROM portions INNER JOIN items ON portions.p_item = items.id WHERE p_year='".$_GET['y']."' AND p_month='".$_GET['m']."' ORDER BY portions.ID DESC") or die($conn->error());
	$result3 = $conn->query("SELECT * FROM countc WHERE c_year='".$_GET['y']."' AND c_month='".$_GET['m']."'") or die($conn->error());


	$num1 = mysqli_num_rows($re1);
	$num2 = mysqli_num_rows($result);
	$num3 = mysqli_num_rows($result7);
	$num4 = mysqli_num_rows($result3);
	$num8 = mysqli_num_rows($result8);
	if ($num8 > 0){
	$wid =  130 / $num8;
	}else{
	$wid = 0;
	}
if ($num1 > 0 and $num2 > 0 and $num3 > 0 and $num4 > 0){

	$tr1 = $t1->fetch_assoc();
	$ro1 = $re1->fetch_assoc();
	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	$pdf->Image($tp1['p_source'],'185','11.5',12.5,12.5);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(0,0,'                   مركز الدعوة الاسلامي',0,1,'R');
	$pdf->Ln(-1.25);
	$pdf->Cell(0,8,'                   تقرير نصيب الفرد',0,1,'R');
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

	$border = array(
	'L' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)),
	'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

	$pdf->Ln(15);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(230,230,230);
	$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'المجموع','T',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	while ($row8 = $result8->fetch_assoc()){
	$pdf->MultiCell($wid,5,$row8['i_name'],'T','C',1,0);
	}
	$pdf->Cell(20,5,'البند','T',0,'C',1,0);
	$pdf->Cell(20,5,'المركز','T',1,'C',1,0);
while ($row = $result->fetch_assoc()){
	$pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
	$pdf->Ln(0.25);
	$result6 = $conn->query("SELECT portions.p_quantity FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(20,5,'','T',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	$pdf->Cell($wid,5,$row6['p_quantity'],$border,0,'C',1,0);
	}
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'الكمية',$border,0,'C',1,0);
	$pdf->SetFillColor(230,230,230);
	$pdf->MultiCell(20,15,$row['mname'],'T','C',1,1, '', '', true, 0, false, true, 15, 'M');

	$pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)));
	$pdf->Ln(-9.75);
	$pdf->SetFillColor(255,255,255);
	$result6 = $conn->query("SELECT p_price / p_quantity as p_average FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(20,5,'','T',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row6['p_average']),'TL',0,'C',1,0);
	}
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'سعر الوحدة','TL',1,'C',1,0);
	$pdf->Ln(0.25);

	$result6 = $conn->query("SELECT p_price FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	$result9 = $conn->query("SELECT SUM(p_price) as price2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	$row9 = $result9->fetch_assoc();
	$pdf->SetFont('aealarabiya','',9);
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(20,5,number_format($row9['price2']),'T',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row6['p_price']),'TL',0,'C',1,0);
	}
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'السعر الكامل','TL',1,'C',1,0);
	$pdf->Ln(0.25);

	$result5 = $conn->query("SELECT c_learn + c_dev as total FROM countc WHERE c_month='".$_GET['m']."' AND c_year='".$_GET['y']."' AND c_markaz='".$row['ID']."'") or die($conn->error());
	$row5 = $result5->fetch_assoc();

	$result6 = $conn->query("SELECT p_quantity / '".$row5['total']."' as portion2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(20,5,'','T',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	if ($row6['portion2'] != ''){
	$pdf->Cell($wid,5,number_format($row6['portion2'],1),'TL',0,'C',1,0);
	}else{
	$pdf->Cell($wid,5,0,'TL',0,'C',1,0);
	}
	}
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'نصيب الفرد','TL',0,'C',1,0);
	$pdf->Cell(20,5,'عدد المستفيدين',0,1,'C',1,0);
	$pdf->Ln(0.25);

	$pdf->SetFillColor(230,230,230);
	$pdf->SetFont('aealarabiya','',9);
	if ($row5['total'] > 0){
	$result6 = $conn->query("SELECT p_price / '".$row5['total']."' as portion2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	$pdf->Cell(20,5,number_format($row9['price2'] / $row5['total']),'T',0,'C',1,0);
	}else{
	$result6 = $conn->query("SELECT 0 as portion2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' AND portions.p_markaz='".$row['ID']."' ORDER BY portions.ID DESC") or die($conn->error());
	$pdf->Cell(20,5,0,'T',0,'C',1,0);
	}
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	$pdf->Cell($wid,5,number_format($row6['portion2']),'TL',0,'C',1,0);
	}
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'تكلفة الفرد','TL',0,'C',1,0);
	$pdf->Cell(20,5,$row5['total'],0,1,'C',1,0);
	$pdf->Ln(0.25);
}	



	$border2 = array(
	'L' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)),
	'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)),
	'B' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
	$border3 = array(
	'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)),
	'B' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
//******** sum table
$pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
	$pdf->Ln(0.5);
	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(20,5,'','T',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	$result4 = $conn->query("SELECT SUM(p_quantity) as t_quantity FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$row4 = $result4->fetch_assoc();
	$pdf->Cell($wid,5,$row4['t_quantity'],$border,0,'C',1,0);
	}
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'الكمية',$border,0,'C',1,0);
	$pdf->SetFillColor(230,230,230);
	$pdf->MultiCell(20,15,'إحصائية جميع المراكز','T','C',1,1, '', '', true, 0, false, true, 15, 'M');

	$pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)));
	$pdf->Ln(-9.75);
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(20,5,'','T',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	$result4 = $conn->query("SELECT SUM(p_price) / SUM(p_quantity) as t_average FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$row4 = $result4->fetch_assoc();
	$pdf->Cell($wid,5,number_format($row4['t_average']),'TL',0,'C',1,0);
	}
	$pdf->SetFont('aealarabiya','',6);
	$pdf->Cell(20,5,'متوسط سعر الوحدة','TL',1,'C',1,0);
	$pdf->Ln(0.25);

	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$result9 = $conn->query("SELECT SUM(p_price) as t_price2 FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$row9 = $result9->fetch_assoc();
	$pdf->SetFont('aealarabiya','',9);
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(20,5,number_format($row9['t_price2']),'T',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	$result4 = $conn->query("SELECT SUM(p_price) as t_price FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$row4 = $result4->fetch_assoc();
	$pdf->Cell($wid,5,number_format($row4['t_price']),'TL',0,'C',1,0);
	}
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'السعر الكامل','TL',1,'C',1,0);
	$pdf->Ln(0.25);

	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$result5 = $conn->query("SELECT SUM(c_learn + c_dev) as t_total FROM countc WHERE c_month='".$_GET['m']."' AND c_year='".$_GET['y']."'") or die($conn->error());
	$row5 = $result5->fetch_assoc();
	$pdf->SetFillColor(230,230,230);
	$pdf->Cell(20,5,'','T',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	$result4 = $conn->query("SELECT SUM(p_quantity) / '".$row5['t_total']."' as t_portion2 FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$row4 = $result4->fetch_assoc();
	if ($row4['t_portion2'] != ''){
	$pdf->Cell($wid,5,number_format($row4['t_portion2'],1),'TL',0,'C',1,0);
	}else{
	$pdf->Cell($wid,5,0,'TL',0,'C',1,0);
	}
	}
	$pdf->SetFont('aealarabiya','',6);
	$pdf->Cell(20,5,'متوسط نصيب الفرد','TL',0,'C',1,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'عدد المستفيدين',0,1,'C',1,0);
	$pdf->Ln(0.25);

	$pdf->SetFillColor(230,230,230);
	$pdf->SetFont('aealarabiya','',9);
	if ($row5['t_total'] > 0){
	$pdf->Cell(20,5,number_format($row9['t_price2'] / $row5['t_total']),$border3,0,'C',1,0);
	}else{
	$pdf->Cell(20,5,0,$border3,0,'C',1,0);
	}
	$pdf->SetFillColor(255,255,255);
	$result6 = $conn->query("SELECT DISTINCT items.ID FROM portions INNER JOIN items ON portions.p_item = items.ID WHERE portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$pdf->SetFont('aealarabiya','',6);
	while ($row6 = $result6->fetch_assoc()){
	$result4 = $conn->query("SELECT SUM(p_price) / '".$row5['t_total']."' as t_portion2 FROM portions WHERE portions.p_item = '".$row6['ID']."' AND portions.p_month='".$_GET['m']."' AND portions.p_year='".$_GET['y']."' ORDER BY portions.ID DESC") or die($conn->error());
	$row4 = $result4->fetch_assoc();
	$pdf->Cell($wid,5,number_format($row4['t_portion2']),$border2,0,'C',1,0);
	}
	$pdf->SetFont('aealarabiya','',6);
	$pdf->Cell(20,5,'متوسط تكلفة الفرد',$border2,0,'C',1,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetLineStyle(array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
	$pdf->Cell(20,5,$row5['t_total'],'B',1,'C',1,0);
	$pdf->Ln(0.25);
//*********************************


}else{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',40);
	$pdf->SetTextColor(200,0,0);
	$pdf->Cell(190,15,'الرجاء اكمال بيانات التقرير',0,1,'C',1,0);
}
}
$pdf->output('portion_report_'.$_GET['m'].'_'.$_GET['y'].'.pdf');
}else{
echo '<link rel="icon" type="image/png" href="images/new.bmp"/>';
echo '<title>تقرير نصيب الفرد</title>';
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