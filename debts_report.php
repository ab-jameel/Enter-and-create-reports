<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 18") or die($conn->error());
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

$pdf->SetTitle('تقرير المديونيات');


if (isset($_GET['y'])){
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$result1 =  $conn->query("SELECT * FROM balances WHERE b_year='".$_GET['y']."'") or die($conn->error());
	$result2 = $conn->query("SELECT * FROM debts WHERE YEAR(d_date)='".$_GET['y']."' ORDER BY d_date ASC") or die($conn->error());
	$result3 = $conn->query("SELECT * FROM exchange WHERE e_month=1 AND e_year='".$_GET['y']."'") or die($conn->error());

$num1 = mysqli_num_rows($result1);
$num2 = mysqli_num_rows($result2);
$num3 = mysqli_num_rows($result3);
if ($num1 > 1 and $num3 > 0){

	$result4 =  $conn->query("SELECT b_amount FROM balances WHERE b_year='".$_GET['y']."' AND b_currency = 'دولار'") or die($conn->error());
	$result5 =  $conn->query("SELECT b_amount FROM balances WHERE b_year='".$_GET['y']."' AND b_currency = 'شلن'") or die($conn->error());


	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
	$row3 = $result3->fetch_assoc();
	$row4 = $result4->fetch_assoc();
	$row5 = $result5->fetch_assoc();

	$exchange = $row3['e_price'];
	$s_dollar = $row4['b_amount'];
	$s_shil = $row5['b_amount'];
	$s_shil = $s_shil / $exchange;
	$s_total = $s_dollar + $s_shil;



	if ($num2 > 0){
	$result6 =  $conn->query("SELECT SUM(d_amount) as d_amount FROM debts WHERE YEAR(d_date)='".$_GET['y']."' AND d_currency = 'دولار'") or die($conn->error());
	$result7 =  $conn->query("SELECT SUM(d_amount) as d_amount FROM debts WHERE YEAR(d_date)='".$_GET['y']."' AND d_currency = 'شلن'") or die($conn->error());

	if (empty($result6)){
	$t_dollar = 0;
	}else{
	$row6 = $result6->fetch_assoc();
	$t_dollar = $row6['d_amount'];
	}

	if (empty($result7)){
	$t_shil = 0;
	}else{
	$row7 = $result7->fetch_assoc();
	$t_shil = $row7['d_amount'];
	$t_shil = $t_shil / $exchange;
	}
	$d_total = $t_dollar + $t_shil;
	}else{
	$d_total = 0;
	}

	$left = $d_total + $s_total;

	$pdf->Image($tp1['p_source'],'175','',22.5,22.5);
	$pdf->SetFont('aealarabiya','',14);
	$pdf->SetX(145);
	$pdf->Cell(25,0,'مركز الدعوة الاسلامي',0,1,'R');
	$pdf->SetX(145);
	$pdf->Cell(25,8,'تقرير المديونيات',0,1,'R');
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
	$pdf->Cell(40,5,'الباقي','L',0,'C',1,0);
	$pdf->Cell(40,5,'اجمالي السداد','L',0,'C',1,0);
	$pdf->Cell(40,5,'ديون مدورة','L',0,'C',1,0);
	$pdf->Cell(40,5,'سعر الصرف','L',1,'C',1,0);

	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(180,180,180);
	
	$pdf->Cell(40,5,number_format($left),'LB',0,'C',1,0);
	$pdf->Cell(40,5,number_format($d_total),'LB',0,'C',1,0);
	$pdf->Cell(40,5,number_format($s_total),'LB',0,'C',1,0);
	$pdf->Cell(40,5,number_format($exchange),'LB',0,'C',1,0);
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->SetDrawColor(255,255,255);
	$pdf->Cell(30,10,'حركة الديون بالدولار','L',1,'C',1,0, 0, false, 'C');


	$pdf->Ln();


	//**table head
	$pdf->SetFillColor(230,230,230);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('aealarabiya','',10);
	$pdf->Cell(20,5,'رقم السند','TB',0,'R',1,0);
	$pdf->Cell(23.75,5,'المسؤول','TB',0,'R',1,0);
	$pdf->Cell(30,5,'البيان','TB',0,'R',1,0);
	$pdf->Cell(25,5,'ما يعادل بالدولار','TB',0,'R',1,0);
	$pdf->Cell(30,5,'المبلغ','TB',0,'R',1,0);
	$pdf->Cell(15,5,'العملة','TB',0,'R',1,0);
	$pdf->Cell(23.75,5,'خاص بمركز','TB',0,'R',1,0);
	$pdf->Cell(22.5,5,'التاريخ','TB',1,'R',1,0);


	$pdf->SetFillColor(255,255,255);
	$pdf->SetDrawColor(180,180,180);
	$pdf->SetFont('aealarabiya','',8.5);

while ($row = $result1->fetch_assoc()){
	
	//**table balances cells
	$pdf->Ln(0.2);
	$pdf->Cell(20,5,'','B',0,'R');
	$pdf->Cell(23.75,5,'','B',0,'R');
	$pdf->Cell(30,5,'الرصيد المدور','B',0,'R');
	if ($row['b_currency'] == 'شلن'){
	$pdf->Cell(25,5,number_format($row['b_amount'] / $exchange),'B',0,'R');
	}else{
	$pdf->Cell(25,5,'','B',0,'R');
	}
	$pdf->Cell(30,5,number_format($row['b_amount']),'B',0,'R');
	$pdf->Cell(15,5,$row['b_currency'],'B',0,'R');
	$pdf->Cell(23.75,5,'','B',0,'R');
	$pdf->Cell(22.5,5,$row['b_year'],'B',1,'R',1,0);

}

while ($row2 = $result2->fetch_assoc()) {
	$result_markaz = $conn->query("SELECT * FROM marakez WHERE ID=".$row2['d_markaz']) or die($conn->error());
	$markaz = $result_markaz->fetch_assoc();
	//**table debts cells
	$pdf->Ln(0.2);
	$pdf->Cell(20,5,$row2['d_number'],'B',0,'R');
	$pdf->MultiCell(23.75,5,$row2['d_admin'],'B','R',1,0, '', '', true, 0, false, true, 5, 'M');
	$pdf->MultiCell(30,5,$row2['d_notice'],'B','R',1,0, '', '', true, 0, false, true, 5, 'M');
	if ($row2['d_currency'] == 'شلن'){
	$pdf->Cell(25,5,number_format($row2['d_amount'] / $exchange),'B',0,'R');
	}else{
	$pdf->Cell(25,5,'','B',0,'R');
	}
	$pdf->Cell(30,5,number_format($row2['d_amount']),'B',0,'R');
	$pdf->Cell(15,5,$row2['d_currency'],'B',0,'R');
	$pdf->Cell(23.75,5,$markaz['mname'],'B',0,'R');
	$pdf->Cell(22.5,5,$row2['d_date'],'B',1,'R',1,0);

}

}else{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',40);
	 $pdf->SetTextColor(200,0,0);
	$pdf->Cell(190,15,'الرجاء اكمال بيانات التقرير',0,1,'C',1,0);
}
}
$pdf->output('debts_report_'.$_GET['y'].'.pdf');
}else{
echo '<link rel="icon" type="image/png" href="images/new.bmp"/>';
echo '<title>تقرير المديونيات</title>';
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