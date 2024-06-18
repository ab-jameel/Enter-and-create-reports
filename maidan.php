<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 10") or die($conn->error());
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

$pdf->SetTitle('التقرير الميداني');


	if (isset($_GET['m']) and isset($_GET['y'])){
	$re1 = $conn->query("SELECT * FROM rok WHERE r_type=1 AND k_type=1 AND k_month='".$_GET['m']."' AND k_year='".$_GET['y']."'") or die($conn->error());
	$t1=$conn->query("SELECT * FROM months WHERE ID=".$_GET['m']) or die($conn->error());
	$re2 = $conn->query("SELECT * FROM rprograms WHERE b_year='".$_GET['y']."' AND b_month='".$_GET['m']."'") or die($conn->error());
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$c1 = mysqli_num_rows($re1);
	$c2 = mysqli_num_rows($re2);
	if ($c1 > 0 and $c2 > 0){

	$result = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM rprograms INNER JOIN marakez ON rprograms.b_markaz = marakez.ID WHERE rprograms.b_year='".$_GET['y']."' AND rprograms.b_month='".$_GET['m']."' ORDER BY ID ASC") or die($conn->error());
	$result4 = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM rprograms INNER JOIN marakez ON rprograms.b_markaz = marakez.ID WHERE rprograms.b_year='".$_GET['y']."' AND rprograms.b_month='".$_GET['m']."'") or die($conn->error());
	$num4 = mysqli_num_rows($result4);
	$tr1 = $t1->fetch_assoc();
	$ro1 = $re1->fetch_assoc();
	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	$pdf->Image($tp1['p_source'],'100','',30,30);
	$pdf->SetFont('aealarabiya','',14);
	$pdf->Cell(0,0,'مركز الدعوة الاسلامي',0,1,'R');
	$pdf->Cell(0,8,'التقرير الميداني',0,1,'R');
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

$result110 =  $conn->query("SELECT SUM(b_countm) as b_countm, SUM(b_attend) as b_attend FROM rprograms WHERE b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
$row110 = $result110->fetch_assoc();
if ($row110['b_countm'] > 0 and $row110['b_attend'] > 0){
//*******chart 1
$pdf->SetFont('aealarabiya','',7);
$chartX=0;
$chartY=2;

$chartWidth=$num4 * 20;
$chartHeight=45;

$chartTopPadding=10;
$chartLeftPadding=20;
$chartBottomPadding=20;
$chartRightPadding=5;

$chartBoxX=$chartX+$chartLeftPadding;
$chartBoxY=$chartY+$chartTopPadding;
$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
$chartBoxHeight=$chartHeight-$chartTopPadding-$chartBottomPadding;

$barWidth=5;

$data=array();

$result10 = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM rprograms INNER JOIN marakez ON rprograms.b_markaz = marakez.ID WHERE rprograms.b_year='".$_GET['y']."' AND rprograms.b_month='".$_GET['m']."'") or die($conn->error());
while ($row10 = $result10->fetch_array()) {
$result11 =  $conn->query("SELECT SUM(b_countm) as b_countm FROM rprograms WHERE b_markaz= '".$row10['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
$row11 = $result11->fetch_assoc();

$data[$row10['mname']]['value'] = $row11['b_countm'];
};
$dataMax=0;
foreach ($data as $item) {
	if($item['value']>$dataMax)$dataMax=$item['value'];
}

$cen2 = $dataMax / 4;

$dataStep=$cen2;

$pdf->SetLineWidth(0.2);
$pdf->SetDrawColor(0);

$pdf->Line(
	$chartBoxX,
	$chartBoxY,
	$chartBoxX,
	$chartBoxY+$chartBoxHeight
);

$pdf->Line(
	$chartBoxX-2,
	$chartBoxY+$chartBoxHeight,
	$chartBoxX+$chartBoxWidth,
	$chartBoxY+$chartBoxHeight
);
if ($dataMax > 0){
$yAxisUnits=$chartBoxHeight / $dataMax;
}else{
$yAxisUnits = $chartBoxHeight;
}

for ($i=0; $i <= $dataMax; $i+=$dataStep) { 
	$yAxisPos= $chartBoxY + ($yAxisUnits * $i);

	$pdf->Line(
		$chartBoxX-2,
		$yAxisPos,
		$chartBoxX,
		$yAxisPos
	);

	$pdf->SetXY($chartBoxX - $chartLeftPadding , $yAxisPos-2);
	$pdf->Cell($chartLeftPadding-4,5,number_format($dataMax-$i),0,0,'R');

}

$pdf->SetXY($chartBoxX,$chartBoxY+$chartBoxHeight);
if (count($data) > 0){
$xLabelWidth=$chartBoxWidth / count($data);
}else{
$xLabelWidth = $chartBoxWidth;
}

$barXPos=0;

foreach ($data as $itemName => $item) {
	$pdf->Cell($xLabelWidth,5,$itemName,0,0,'C');

	$pdf->SetFillColor(0,180,0);

	$barHeight=$yAxisUnits * $item['value'];

	$barX=($xLabelWidth/2)+($xLabelWidth*$barXPos);
	$barX=$barX-($barWidth/2);
	$barX=$barX+$chartBoxX;

	$barY = $chartBoxHeight-$barHeight;
	$barY=$barY+$chartBoxY;

	$pdf->RoundedRect($barX,$barY,$barWidth,$barHeight,0.5,'1001','DF');

	$barXPos++;
}

$pdf->SetFont('aealarabiya','',10);
$pdf->SetXY(($chartWidth/2)-30+$chartX,$chartY+$chartHeight-($chartBottomPadding/2)-3);
$pdf->Cell($chartWidth,0,"عدد المهتدين",0,0,'C');
//***************************************************


//******chart 2
$pdf->SetFont('aealarabiya','',7);

$pieX=25;
$pieY=55;
$r=10;
$legendX=50;
$legendY=46.5;

$color2=array(
	[225,0,0],
	[0,0,200],
	[255,165,0],
	[0,150,0],
	[170,0,0],
	[0,75,100],
	[0,75,0],
	[100,0,100],
	[0,0,100],
	[0,120,100]
);

$data2 = array();
	$result10 = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM rprograms INNER JOIN marakez ON rprograms.b_markaz = marakez.ID WHERE rprograms.b_year='".$_GET['y']."' AND rprograms.b_month='".$_GET['m']."'") or die($conn->error());
	while ($row10 = $result10->fetch_assoc()) {
		$result111 =  $conn->query("SELECT SUM(b_attend) as b_attend, SUM(b_countm) as b_countm FROM rprograms WHERE b_markaz='".$row10['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
		$row111 = $result111->fetch_assoc();
		if ($row111['b_attend'] > 0){
		$n1 = $row111['b_countm'];
		$n2 = $row111['b_attend'];
		if ($n2 > 0){
		$n3 = $n1/$n2;
		}else{
		$n3 = $n1;
		}
$data2[$row10['mname']]['value']=$n3;
for ($i=0; $i < count($data2); $i++) { 
$data2[$row10['mname']]['color']=$color2[$i];
}}
};

$dataSum=0;
foreach ($data2 as $item2) {
	$dataSum+=$item2['value'];
}

if ($dataSum > 0){
$degUnit=360/$dataSum;
}else{
$degUnit=360;
}

$currentAngle=0;
$currentLegendY=$legendY;

foreach ($data2 as $index => $item2) {
	$deg=$degUnit*$item2['value'];
	$pdf->SetFillColor($item2['color'][0],$item2['color'][1],$item2['color'][2]);
	$pdf->SetDrawColor(255,255,255);
	$pdf->Sector($pieX,$pieY,$r,$currentAngle,$currentAngle+$deg);
	$currentAngle+=$deg;

	$num3 = number_format($item2['value'], 2, '.', '');
	$num3 = $num3*100;

	$pdf->Rect($legendX,$currentLegendY,4,4,'DF');
	$pdf->SetXY($legendX+4,$currentLegendY);
	$pdf->Cell(20,0,$index.'  ( '.$num3.'% )',0,0);
	$currentLegendY+=4.5;
}
$pdf->SetFillColor(255,255,255);
$pdf->Sector($pieX,$pieY,4.5,0,360);
$pdf->SetXY($pieX-18,$pieY-14);
$pdf->Cell(0,0,'نسبة المهتدين من عدد الحضور');
//*********************************************
}else{
	$pdf->Ln(-20);
}
	$pdf->Ln(25);
	$pdf->SetFont('aealarabiya','',10);

$html ="
			<table class=\"table1\">
					<tr>
						<td class=\"th2\">الاجماليات</td>
					</tr>
					<tr>
					<th class=\"th1\">البرامج الاذاعية</th>
					<th class=\"th1\">الخطب</th>
					<th class=\"th1\">المهتدين</th>
					<th class=\"th1\">الحضور التقريبي</th>
					<th class=\"th1\">المناظرات</th>
					<th class=\"th1kh\">المركز</th>
				</tr>
";
$result7 =  $conn->query("SELECT SUM(b_countr) as b_countr, SUM(b_attend) as b_attend, SUM(b_countm) as b_countm, SUM(b_countk) as b_countk, SUM(b_countt) as b_countt FROM rprograms WHERE b_month='".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());

while ($row4 = $result4->fetch_assoc()) {
	$res = $conn->query("SELECT * FROM rprograms WHERE b_markaz= '".$row4['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
	if (mysqli_num_rows($res) > 0){
	$result6 =  $conn->query("SELECT SUM(b_countr) as b_countr, SUM(b_attend) as b_attend, SUM(b_countm) as b_countm, SUM(b_countk) as b_countk, SUM(b_countt) as b_countt FROM rprograms WHERE b_markaz= '".$row4['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
	$row6 = $result6->fetch_assoc();
$html .="
					<tr>
					<td class=\"pad\">".number_format($row6['b_countt'])."</td>
					<td class=\"pad\">".number_format($row6['b_countk'])."</td>
					<td class=\"pad\">".number_format($row6['b_countm'])."</td>
					<td class=\"pad\">".number_format($row6['b_attend'])."</td>
					<td class=\"pad\">".number_format($row6['b_countr'])."</td>
					<td class=\"padkh\">".$row4['mname']."</td>
					</tr>

";
}}	$row7 = $result7->fetch_assoc();

$html .="
				<tr>
					<td class=\"b1\">".number_format($row7['b_countt'])."</td>
					<td class=\"b1\">".number_format($row7['b_countk'])."</td>
					<td class=\"b1\">".number_format($row7['b_countm'])."</td>
					<td class=\"b1\">".number_format($row7['b_attend'])."</td>
					<td class=\"b1\">".number_format($row7['b_countr'])."</td>
					<td class=\"b1\">الاجمالي</td>
				</tr>
			</table>
";

$html .="
<style>  	
.pad{
	border-collapse: collapse;
	border-bottom: 1px solid lightgrey;
	padding: 5px;
	text-align: center;
	width: 90px;
}

.padkh{
	border-collapse: collapse;
	border-bottom: 1px solid lightgrey;
	text-align: right;
	width: 90px;
}

.th1{
color: white;
background-color: black;
text-align: center;
vertical-align: middle;
font-weight: bold;
font-size: 11px;
width: 90px;
}

.th1kh{
color: white;
background-color: black;
text-align: center;
vertical-align: middle;
font-weight: bold;
font-size: 11px;
text-align: right;
width: 90px;
}

.th2{
	border: none; 
	text-align: right;
	font-size: 15px;
	font-weight: bold;
	width:540px;
}

.table1{
	vertical-align: top;
	display: inline-block;
	border-collapse: collapse;
	border-bottom: 2px double lightgrey;
	font-size: 10px;
	width: 690px;
	border-bottom: none;
}

.b1{
font-size: 11px;
color: black;
background-color: white;
text-align: center;
vertical-align: middle;
font-weight: bold;
width: 90px;
height:15px;
border-top: 2px solid black;
border-bottom: 2px solid black;
margin-top: 2px;
}

</style>
";
$pdf->WriteHTMLCell(190,0,9,'',$html,0,1,0,'','C');
while ($row = $result->fetch_assoc()){
	$result2 =  $conn->query("SELECT * FROM rprograms WHERE b_markaz= '".$row['ID']."' AND b_month= '".$_GET['m']."' AND b_year='".$_GET['y']."'") or die($conn->error());
	if (mysqli_num_rows($result2) > 0){
	$pdf->Ln(3);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(90,90,90);
	$pdf->SetFont('aealarabiya','',13);
	$pdf->Cell(190,5,$row['mname'],0,1,'R',1,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->SetFillColor(200,200,200);
	$pdf->Cell(30,5,'البرامج الاذاعية',0,0,'C',1,0);
	$pdf->Cell(30,5,'الخطب',0,0,'C',1,0);
	$pdf->Cell(30,5,'المهتدين',0,0,'C',1,0);
	$pdf->Cell(30,5,'الحضور التقريبي',0,0,'C',1,0);
	$pdf->Cell(30,5,'المناظرات',0,0,'C',1,0);
	$pdf->Cell(40,5,'الفرقة',0,1,'R',1,0);

	while ($row2 = $result2->fetch_assoc()) {
	$result3 = $conn->query("SELECT * from groups WHERE ID=".$row2['b_group']) or die($conn->error());

	$pdf->SetDrawColor(180,180,180);

	while ($row3 = $result3->fetch_assoc()) {

	$pdf->Cell(30,5,number_format($row2['b_countt']),'B',0,'C');
	$pdf->Cell(30,5,number_format($row2['b_countk']),'B',0,'C');
	$pdf->Cell(30,5,number_format($row2['b_countm']),'B',0,'C');
	$pdf->Cell(30,5,number_format($row2['b_attend']),'B',0,'C');
	$pdf->Cell(30,5,number_format($row2['b_countr']),'B',0,'C');
	$pdf->Cell(40,5,$row3['group_name'],'B',1,'R');

}}
}
}}}
$pdf->output('maidan_report_'.$_GET['m'].'_'.$_GET['y'].'.pdf');
}else{
echo '<link rel="icon" type="image/png" href="images/new.bmp"/>';
echo '<title>التقرير الميداني</title>';
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