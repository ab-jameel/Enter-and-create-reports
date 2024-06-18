<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 9") or die($conn->error());
$row1 = $result1->fetch_assoc();
$report = $row1['p_pdf'];

if ($report == 1){

include('tcpdf/tcpdf.php');

class PDF_SECTOR extends TCPDF
{
    function Sector($xc, $yc, $r, $a, $b, $style='FD', $cw=true, $o=90)
    {
        $d0 = $a - $b;
        if($cw){
            $d = $b;
            $b = $o - $a;
            $a = $o - $d;
        }else{
            $b += $o;
            $a += $o;
        }
        while($a<0)
            $a += 360;
        while($a>360)
            $a -= 360;
        while($b<0)
            $b += 360;
        while($b>360)
            $b -= 360;
        if ($a > $b)
            $b += 360;
        $b = $b/360*2*M_PI;
        $a = $a/360*2*M_PI;
        $d = $b - $a;
        if ($d == 0 && $d0 != 0)
            $d = 2*M_PI;
        $k = $this->k;
        $hp = $this->h;
        if (sin($d/2))
            $MyArc = 4/3*(1-cos($d/2))/sin($d/2)*$r;
        else
            $MyArc = 0;
        //first put the center
        $this->_out(sprintf('%.2F %.2F m',($xc)*$k,($hp-$yc)*$k));
        //put the first point
        $this->_out(sprintf('%.2F %.2F l',($xc+$r*cos($a))*$k,(($hp-($yc-$r*sin($a)))*$k)));
        //draw the arc
        if ($d < M_PI/2){
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }else{
            $b = $a + $d/4;
            $MyArc = 4/3*(1-cos($d/8))/sin($d/8)*$r;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }
        //terminate drawing
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='b';
        else
            $op='s';
        $this->_out($op);
    }
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3 )
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            $x1*$this->k,
            ($h-$y1)*$this->k,
            $x2*$this->k,
            ($h-$y2)*$this->k,
            $x3*$this->k,
            ($h-$y3)*$this->k));
    }
}

$pdf = new TCPDF('P','mm','A4');
$pdf = new PDF_SECTOR('P','mm','A4');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetTitle('التقرير المالي للمراكز الدعوية');


	if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=2 AND k_type=1 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$c1 = mysqli_num_rows($re1);
	if ($c1 > 0){
	$result = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM minfo INNER JOIN marakez ON minfo.m_markaz = marakez.ID WHERE minfo.m_year='".$_GET['y']."' AND minfo.m_month='".$_GET['m']."' ORDER BY ID ASC") or die($conn->error());
$result7 =  $conn->query("SELECT SUM(m_num1) as m_num1, SUM(m_coss1) as m_coss1, SUM(m_coss11) as m_coss11, SUM(m_num2) as m_num2, SUM(m_coss2) as m_coss2, SUM(m_coss22) as m_coss22, SUM(m_num3) as m_num3, SUM(m_coss3) as m_coss3, SUM(m_coss33) as m_coss33, SUM(m_num4) as m_num4, SUM(m_coss4) as m_coss4 FROM minfo WHERE m_month='".$_GET['m']."' AND m_year='".$_GET['y']."'") or die($conn->error());

$result6 = $conn->query("SELECT SUM(c_amount) as c_amount FROM comparison WHERE c_year='".$_GET['y']."' AND c_program LIKE 'المناظرات والمحاضرات' AND c_axis LIKE 'التعريف بالاسلام'") or die($conn->error());

$result8 = $conn->query("SELECT * FROM exchange WHERE e_month='".$_GET['m']."' AND e_year='".$_GET['y']."'") or die($conn->error());

$result12 = $conn->query("SELECT * FROM groups WHERE the_year=".$_GET['y']) or die($conn->error());

$resul2 = $conn->query("SELECT * FROM groups WHERE the_year=".$_GET['y']) or die($conn->error());

$row7 = $result7->fetch_assoc();
$row6 = $result6->fetch_assoc();
$row8 = $result8->fetch_assoc();
$num1 = mysqli_num_rows($result12);
$num2 = mysqli_num_rows($result);
$num3 = mysqli_num_rows($resul2);
if ($num2 > 0 and $num3 > 0){
if ($row7['m_coss4'] > 0){
	$m_num4 = 1;
}else{
	$m_num4 = 0;
}

$m_coss3 = $row7['m_coss3'];
if ($row7['m_num3'] > 0){
$sum5 = $row7['m_coss3'] / $row7['m_num3'];
}else{
$sum5 = 0;
}
$sum1 = $row7['m_num1'] + $row7['m_num2'];
if ($row7['m_num1'] > 0){
$sum3 = $row7['m_coss11'] / $row7['m_num1'];
}else{
$sum3 = 0;
}
if ($row7['m_num2'] > 0){
$sum4 = $row7['m_coss22'] / $row7['m_num2'];
}else{
$sum4 = 0;
}
$sum2 = $row7['m_coss11'] + $row7['m_coss22'] + $row7['m_coss3'] + $row7['m_coss4'];
$sum6 = $m_num4 * $row7['m_coss4'];
if ($sum1 > 0){
$sum7 = $sum2 / $sum1;
}else{
$sum7 = 0;
}
if ($row8['e_price'] > 0){
$real = $sum2 / $row8['e_price'];
}else{
$real = 0;
}

$m_num1 = number_format($row7['m_num1']);
$m_num2 = number_format($row7['m_num2']);
$m_num3 = number_format($row7['m_num3']);
$m_coss4 = number_format($row7['m_coss4']);

$real2 = number_format($real, 0, '.', ',');
$dif = $row6['c_amount']/12;
if ($num1 > 0){
$egroup = $dif / $num1;
}else{
$egroup = 0;
}
if ($dif > 0){
$final = $real / $dif;
}else{
$final = 0;
}
$final = $final * 100;
$final3 = $final / 2;
if ($real > 0){
$dif2 = $dif / $real;
}else{
$dif2 = 0;
}
$dif2 = $dif2 * 100;
$dif2 = $dif2 / 2;
$final2 = number_format($final, 0, '.', '');

	$tr1 = $t1->fetch_assoc();
	$ro1 = $re1->fetch_assoc();
	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	$pdf->Image($tp1['p_source'],'100','',30,30);
	$pdf->SetFont('aealarabiya','',14);
	$pdf->Cell(0,0,'مركز الدعوة الاسلامي',0,1,'R');
	$pdf->Cell(0,8,'التقرير المالي',0,1,'R');
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(180,6,$tr1['m_name'],0,0,'R');
	$pdf->Cell(10,7,$ro1['k_year'],0,1,'R');
	$pdf->Ln(3);
	$pdf->Rect(155,37.5,45,23,'D');
	$pdf->SetXY(155,38);
	$pdf->SetFont('aealarabiya','',12);
	$pdf->Cell(45,5,'تم الموافقة والاعتماد',0,1,'C');
	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetXY(155,44.5);
	$pdf->Cell(45,5,$ro1['k_person'],0,1,'C');
	$pdf->SetFont('aealarabiya','',12);
	$pdf->SetXY(98.5,45);
	$pdf->Cell(35,0,' اعداد واشراف',0,1,'C');
	$pdf->Image($tp11['p_source'],'96','',35,15);
	$pdf->SetXY(155,50);
	$pdf->SetFont('aealarabiya','',5);
	$pdf->Cell(45,5,$ro1['k_email'],0,1,'C');
	$pdf->SetXY(155,54.5);
	$pdf->Cell(45,5,$ro1['k_time'],0,1,'C');

//******chart 1
$pdf->SetFont('aealarabiya','',7);

$pieX=25;
$pieY=35;
$r=10;
$legendX=50;
$legendY=30;

$data2 = array(
'الصرف الفعلي بالدولار'=>[
	'color'=>[255,165,0],
	'value'=>$final3
],
'الموازنة الشهرية'=>[
	'color'=>[0,150,0],
	'value'=>$dif2
]
);

$dataSum=0;
foreach ($data2 as $item2) {
	$dataSum+=$item2['value'];
}

if ($dataSum > 0){
$degUnit=360/$dataSum;
}else{
$degUnit = 0;
}

$currentAngle=0;
$currentLegendY=$legendY;

foreach ($data2 as $index => $item2) {
	$deg=$degUnit*$item2['value'];
	$pdf->SetFillColor($item2['color'][0],$item2['color'][1],$item2['color'][2]);
	$pdf->SetDrawColor(255,255,255);
	$pdf->Sector($pieX,$pieY,$r,$currentAngle,$currentAngle+$deg);
	$currentAngle+=$deg;

	$num3 = number_format($item2['value'], 1, '.', '');

	$pdf->Rect($legendX,$currentLegendY,4,4,'DF');
	$pdf->SetXY($legendX+4,$currentLegendY);
	$pdf->Cell(20,0,$index.'  ( '.$num3.'% )',0,0);
	$currentLegendY+=4.5;
}
$pdf->SetFillColor(255,255,255);
$pdf->SetXY($pieX-18,$pieY-14);
$pdf->Cell(0,0,'مقارنة الصرف الفعلي بالموازنة');
//*********************************************
	$pdf->Ln(45);
	$pdf->SetFont('aealarabiya','',10);

	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetDrawColor(255,255,255);
	$pdf->SetFont('aealarabiya','',9);
	$pdf->Cell(25,5,'الحركة',0,0,'C',1,0);
	$pdf->Cell(20,5,'نسبة الصرف','L',0,'C',1,0);
	$pdf->Cell(20,5,'الموازنة الشهرية','L',0,'C',1,0);
	$pdf->Cell(30,5,'الصرف الفعلي بالدولار','L',0,'C',1,0);
	$pdf->Cell(20,5,'سعر الصرف','L',0,'C',1,0);
	$pdf->Cell(25,5,'المجموع بالشلن','L',0,'C',1,0);
	$pdf->Cell(20,5,'موازنة الفرقة','L',1,'C',1,0);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(180,180,180);
	if ($final >= 100){
	$pdf->SetFillColor(255,180,185);
	$text = "فوق الموازنة";
	}else{
	$pdf->SetFillColor(185,255,185);
	$text = "تحت الموازنة";
	}
	$pdf->Cell(25,5,$text,'LB',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(20,5,$final2.' %','LB',0,'C',1,0);
	$pdf->Cell(20,5,number_format($dif),'LB',0,'C',1,0);
	$pdf->Cell(30,5,$real2,'LB',0,'C',1,0);
	$pdf->Cell(20,5,number_format($row8['e_price']),'LB',0,'C',1,0);
	$pdf->Cell(25,5,number_format($sum2),'LB',0,'C',1,0);
	$pdf->Cell(20,5,number_format($egroup),'LB',0,'C',1,0);
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetDrawColor(255,255,255);
	$pdf->Cell(30,10,'الحركة الشهرية','L',1,'C',1,0, 0, false, 'C');


	$pdf->Ln(5);
	//*** sum table head
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('aealarabiya','',13);
	$pdf->Cell(30,5,'عدد الفرق       '.$num1,0,0,'R',1,0);
	$pdf->Cell(160,5,'الاجمالي',0,1,'R',1,0);
	$pdf->Ln(1);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(30,5,'المجموع الكلي','TB',0,'C',1,0);
	$pdf->Cell(30,5,'ميكروفونات وصيانة','TB',0,'C',1,0);
	$pdf->Cell(30,5,'تغذية الدعاة وتنقلهم','TB',0,'C',1,0);
	$pdf->Cell(30,5,'دعاة 2','TB',0,'C',1,0);
	$pdf->Cell(30,5,'دعاة 1','TB',0,'C',1,0);
	$pdf->Cell(40,5,'البند','TB',1,'C',1,0);
	
	//** sum table cells
	$pdf->Ln(0.2);
	$pdf->SetDrawColor(180,180,180);
	$pdf->Cell(30,5,number_format($sum1),'B',0,'C');
	$pdf->Cell(30,5,$m_num4,'B',0,'C');
	$pdf->Cell(30,5,$m_num3,'B',0,'C');
	$pdf->Cell(30,5,$m_num2,'B',0,'C');
	$pdf->Cell(30,5,$m_num1,'B',0,'C');
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(40,5,'العدد','B',1,'C',1,0);
	$pdf->Ln(0.1);
	$pdf->Cell(30,5,number_format($sum7),'B',0,'C');
	$pdf->Cell(30,5,number_format($sum6),'B',0,'C');
	$pdf->Cell(30,5,number_format($sum5),'B',0,'C');
	$pdf->Cell(30,5,number_format($sum4),'B',0,'C');
	$pdf->Cell(30,5,number_format($sum3),'B',0,'C');
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(40,5,'التكلفة الفردية','B',1,'C',1,0);
	$pdf->Ln(0.1);
	$pdf->SetDrawColor(0,0,0);
	$pdf->Cell(30,5,number_format($sum2),'B',0,'C');
	$pdf->Cell(30,5,$m_coss4,'B',0,'C');
	$pdf->Cell(30,5,number_format($m_coss3),'B',0,'C');
	$pdf->Cell(30,5,number_format($row7['m_coss22']),'B',0,'C');
	$pdf->Cell(30,5,number_format($row7['m_coss11']),'B',0,'C');
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(40,5,'التكلفة الشهرية','B',1,'C',1,0);

	$pdf->Ln(3);
while ($row = $result->fetch_assoc()){
	$pdf->Ln(3);
	$result2 = $conn->query("SELECT * FROM minfo WHERE m_month='".$_GET['m']."' AND m_year='".$_GET['y']."' AND m_markaz='".$row['ID']."'") or die($conn->error());
	$result15 = $conn->query("SELECT * FROM groups WHERE the_year='".$_GET['y']."' AND markaz_name='".$row['ID']."'") or die($conn->error());
	$result20 = $conn->query("SELECT * FROM comparison WHERE c_year='".$_GET['y']."' AND c_program LIKE 'المناظرات والمحاضرات' AND c_axis LIKE 'التعريف بالاسلام' AND c_markaz='".$row['ID']."'");
	$num4 = mysqli_num_rows($result15);
	$row2 = $result2->fetch_assoc();
	$row20 = $result20->fetch_assoc();

$m_num11 = number_format($row2['m_num1']);
$m_num21 = number_format($row2['m_num2']);
$m_num31 = number_format($row2['m_num3']);
$m_coss11 = number_format($row2['m_coss1']);
$m_coss21 = number_format($row2['m_coss2']);
$m_coss31 = $row2['m_coss3'];
$m_num41 = number_format($row2['m_num4']);
$m_coss41 = number_format($row2['m_coss4']);

if ($row2['m_num3'] > 0){
$sum51 = $row2['m_coss3'] / $row2['m_num3'];
}else{
$sum51 = 0;
}
$sum11 = $row2['m_num1'] + $row2['m_num2'];
$sum31 = $row2['m_num1'] * $row2['m_coss1'];
$sum41 = $row2['m_num2'] * $row2['m_coss2'];
$sum61 = $m_num41 * $row2['m_coss4'];
$sum71 = $sum31 + $sum41 + $m_coss31 + $sum61;
if ($sum11 > 0){
$sum21 = $sum71 / $sum11;
}else{
$sum21 = 0;
}
if ($row8['e_price'] > 0){
$real1 = $sum71 / $row8['e_price'];
}else{
$real1 = 0;
}
$real21 = number_format($real1, 0, '.', ',');
if (mysqli_num_rows($result20) > 0){
$dif1 = $row20['c_amount'] / 12;
}else{
$dif1 = 0;
}
if ($dif1 > 0){
$final1 = $real1 / $dif1;
}else{
$final1 = 0;
}
$final1 = $final1 * 100;
$final21 = number_format($final1, 0, '.', '');

	//**table head
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('aealarabiya','',13);
	$pdf->Cell(30,5,'عدد الفرق       '.$num4,0,0,'R',1,0);
	$pdf->Cell(160,5,$row['mname'],0,1,'R',1,0);
	$pdf->Ln(1);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(30,5,'المجموع الكلي','TB',0,'C',1,0);
	$pdf->Cell(30,5,'ميكروفونات وصيانة','TB',0,'C',1,0);
	$pdf->Cell(30,5,'تغذية الدعاة وتنقلهم','TB',0,'C',1,0);
	$pdf->Cell(30,5,'دعاة 2','TB',0,'C',1,0);
	$pdf->Cell(30,5,'دعاة 1','TB',0,'C',1,0);
	$pdf->Cell(40,5,'البند','TB',1,'C',1,0);
	
	//**table cells
	$pdf->Ln(0.2);
	$pdf->SetDrawColor(180,180,180);
	$pdf->Cell(30,5,number_format($sum11),'B',0,'C');
	$pdf->Cell(30,5,$m_num41,'B',0,'C');
	$pdf->Cell(30,5,$m_num31,'B',0,'C');
	$pdf->Cell(30,5,$m_num21,'B',0,'C');
	$pdf->Cell(30,5,$m_num11,'B',0,'C');
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(40,5,'العدد','B',1,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->Ln(0.2);
	$pdf->Cell(30,5,number_format($sum21),'B',0,'C');
	$pdf->Cell(30,5,$m_coss41,'B',0,'C');
	$pdf->Cell(30,5,number_format($sum51),'B',0,'C');
	$pdf->Cell(30,5,$m_coss21,'B',0,'C');
	$pdf->Cell(30,5,$m_coss11,'B',0,'C');
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(40,5,'التكلفة الفردية','B',1,'C',1,0);
	$pdf->Ln(0.2);
	$pdf->Cell(30,5,number_format($sum71),'B',0,'C');
	$pdf->Cell(30,5,number_format($sum61),'B',0,'C');
	$pdf->Cell(30,5,number_format($m_coss31),'B',0,'C');
	$pdf->Cell(30,5,number_format($sum41),'B',0,'C');
	$pdf->Cell(30,5,number_format($sum31),'B',0,'C');
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(40,5,'التكلفة الشهرية','B',1,'C',1,0);
	if ($final1 >= 100){
	$pdf->SetFillColor(255,180,185);
	$text = "فوق الموازنة";
	}else{
	$pdf->SetFillColor(185,255,185);
	$text = "تحت الموازنة";
	}
	$pdf->SetDrawColor(0,0,0);
	$pdf->Cell(25,5,$text,'TB',0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(20,5,'الحركة','TB',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(20,5,$final21.' %','TB',0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(25,5,'نسبة الصرف','TB',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,'$ '.$real21,'TB',0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(25,5,'المصروف بالدولار','TB',0,'C',1,0);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(25,5,'$ '.number_format($dif1),'TB',0,'C',1,0);
	$pdf->SetFillColor(240,240,240);
	$pdf->Cell(25,5,'الموازنة الشهرية','TB',1,'C',1,0);
	$pdf->Ln();
}
}
}
}
$pdf->output('money_report_'.$_GET['m'].'_'.$_GET['y'].'.pdf');
}else{
echo '<link rel="icon" type="image/png" href="images/new.bmp"/>';
echo '<title>التقرير المالي للمراكز الدعوية</title>';
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