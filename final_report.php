<?php
session_start();
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';

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

$pdf->SetTitle('الملخص المالي السنوي');


if (isset($_GET['y'])){
	$p1 = $conn->query("SELECT * FROM pictures ORDER BY ID ASC") or die($conn->error());
	$p11 = $conn->query("SELECT * FROM pictures ORDER BY ID DESC") or die($conn->error());
	$result2 = $conn->query("SELECT * FROM balances WHERE b_year='".$_GET['y']."'") or die($conn->error());
    $result3 = $conn->query("SELECT * FROM exchange WHERE e_month = 1 AND e_year='".$_GET['y']."'") or die($conn->error());

$num22 = mysqli_num_rows($result2);
$num33 = mysqli_num_rows($result3);
if ($num22 > 1 and $num33 > 0){

	$tp1 = $p1->fetch_assoc();
	$tp11 = $p11->fetch_assoc();
    $row3 = $result3->fetch_assoc();


    $exchange1 = $row3['e_price'];
	$t_shil = 0;
	$total = 0;


	$pdf->Image($tp1['p_source'],'175','',22.5,22.5);
	$pdf->SetFont('aealarabiya','',14);
	$pdf->SetX(145);
	$pdf->Cell(25,0,'مركز الدعوة الاسلامي',0,1,'R');
	$pdf->SetX(145);
	$pdf->Cell(25,8,'الملخص المالي السنوي',0,1,'R');
	$pdf->SetFont('aealarabiya','',12);
	$pdf->Cell(149,7,$_GET['y'],0,0,'R');
	$pdf->SetFont('aealarabiya','',14);
	$pdf->Cell(10,7,'لعام',0,1,'R');
	$pdf->Ln(3);
	$pdf->SetFont('aealarabiya','',12);
	$pdf->SetXY(25,11);
	$pdf->Cell(25,0,' اعداد واشراف',0,1,'C');
	$pdf->Image($tp11['p_source'],'20','',35,15);




    $pdf->SetXY(10,115);

	//**table head
	$pdf->SetFillColor(230,230,230);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetFont('aealarabiya','',9);
	$pdf->Cell(17,5,'سعر الصرف','TB',0,'C',1,0);
	$pdf->Cell(20,5,'مجموع المصروفات','TB',0,'C',1,0);
	$pdf->Cell(18.3,5,'سداد ديون','TB',0,'C',1,0);
	$pdf->Cell(18.3,5,'مصروفات عامة','TB',0,'C',1,0);
	$pdf->Cell(18.3,5,'الدعوة','TB',0,'C',1,0);
    $pdf->Cell(18.3,5,'التعليم','TB',0,'C',1,0);
	$pdf->Cell(18.3,5,'التشغيلية','TB',0,'C',1,0);
    $pdf->Cell(18.3,5,'صرف عملة','TB',0,'C',1,0);
    $pdf->Cell(18.3,5,'واردات','TB',0,'C',1,0);
    $pdf->Cell(12,5,'العملة','TB',0,'C',1,0);
	$pdf->Cell(13,5,'الشهر','TB',1,'C',1,0);

	$result1 =  $conn->query("SELECT * FROM months ORDER BY ID ASC") or die($conn->error());

	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',8);

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

while ($row = $result1->fetch_assoc()){
	
    $r1 = $conn->query("SELECT * FROM rok WHERE k_month = '".$row['ID']."' AND k_year = '".$_GET['y']."' AND k_type = 1") or die($conn->error());
    $num1 = mysqli_num_rows($r1);

    if ($num1 > 0){

    $r2 = $conn->query("SELECT * FROM exchange WHERE e_month = '".$row['ID']."' AND e_year = '".$_GET['y']."'") or die($conn->error());
    $ro2 = $r2->fetch_assoc();
    $exchange = $ro2['e_price'];


//********************* dollar

	$pdf->Ln(0.5);
    $result4 = $conn->query("SELECT SUM(d_amount) as d_amount FROM debts WHERE MONTH(d_date) = '".$row['ID']."' AND YEAR(d_date) = '".$_GET['y']."' AND d_currency = 'دولار'") or die($conn->error());
    if (empty($result4)){
    $dollar_debts = 0;
    }else{
    $row4 = $result4->fetch_assoc();
    $dollar_debts = $row4['d_amount'];
    }

    $result5 = $conn->query("SELECT SUM(e_amount) as e_amount FROM expenses WHERE MONTH(e_date) = '".$row['ID']."' AND YEAR(e_date) = '".$_GET['y']."' AND e_currency = 'دولار'") or die($conn->error());
    if (empty($result5)){
    $dollar_expenses = 0;
    }else{
    $row5 = $result5->fetch_assoc();
    $dollar_expenses = $row5['e_amount'];
    }

    $result6 = $conn->query("SELECT SUM(c_dollar) as c_dollar FROM cash WHERE MONTH(c_date) = '".$row['ID']."' AND YEAR(c_date) = '".$_GET['y']."'") or die($conn->error());
    if (empty($result6)){
    $dollar_cash = 0;
    }else{
    $row6 = $result6->fetch_assoc();
    $dollar_cash = $row6['c_dollar'];
    }

    $result7 = $conn->query("SELECT SUM(i_amount) as i_amount FROM incomes WHERE MONTH(i_date) = '".$row['ID']."' AND YEAR(i_date) = '".$_GET['y']."' AND i_currency = 'دولار'") or die($conn->error());
    if (empty($result7)){
    $dollar_incomes = 0;
    }else{
    $row7 = $result7->fetch_assoc();
    $dollar_incomes = $row7['i_amount'];
    }

    $dollar_total_expenses = $dollar_expenses + $dollar_debts;
    $pdf->SetDrawColor(180,180,180);

    $pdf->Cell(17,5,'',0,0,'C',1,0);
    $pdf->Cell(20,5,number_format($dollar_total_expenses),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($dollar_debts),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($dollar_expenses),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,'','B',0,'C',1,0);
    $pdf->Cell(18.3,5,'','B',0,'C',1,0);
    $pdf->Cell(18.3,5,'','B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($dollar_cash),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($dollar_incomes),'B',0,'C',1,0);
    $pdf->Cell(12,5,'دولار','B',1,'C',1,0);

//**************************


//**************** shil

    $result8 = $conn->query("SELECT SUM(d_amount) as d_amount FROM debts WHERE MONTH(d_date) = '".$row['ID']."' AND YEAR(d_date) = '".$_GET['y']."' AND d_currency = 'شلن'") or die($conn->error());
    if (empty($result8)){
    $shil_debts = 0;
    }else{
    $row8 = $result8->fetch_assoc();
    $shil_debts = $row8['d_amount'];
    }

    $result9 = $conn->query("SELECT SUM(e_amount) as e_amount FROM expenses WHERE MONTH(e_date) = '".$row['ID']."' AND YEAR(e_date) = '".$_GET['y']."' AND e_currency = 'شلن'") or die($conn->error());
    if (empty($result9)){
    $shil_expenses = 0;
    }else{
    $row9 = $result9->fetch_assoc();
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
    $result11 = $conn->query("SELECT SUM(m_num1 * m_coss1) + SUM(m_num2 * m_coss2) + m_coss3 + m_coss4 as total FROM minfo WHERE m_month = '".$row['ID']."' AND m_year = '".$_GET['y']."'") or die($conn->error());
    $row11 = $result11->fetch_assoc();
    $shil_minfo = $row11['total'];
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
    $result12 = $conn->query("SELECT SUM(e_monthly * e_num) as total FROM expensesm WHERE e_month = '".$row['ID']."' AND e_year = '".$_GET['y']."'") or die($conn->error());
    $row12 = $result12->fetch_assoc();
    $shil_expensesm = $row12['total'];
    }else{
    $shil_expensesm = "غير معتمد";
    }
    }else{
    $shil_expensesm = "غير مدخل";
    }

    $result13 = $conn->query("SELECT SUM(c_dollar * c_exchange) as c_shil FROM cash WHERE MONTH(c_date) = '".$row['ID']."' AND YEAR(c_date) = '".$_GET['y']."'") or die($conn->error());
    if (empty($result13)){
    $shil_cash = 0;
    }else{
    $row13 = $result13->fetch_assoc();
    $shil_cash = $row13['c_shil'];
    }

    $result14 = $conn->query("SELECT SUM(i_amount) as i_amount FROM incomes WHERE MONTH(i_date) = '".$row['ID']."' AND YEAR(i_date) = '".$_GET['y']."' AND i_currency = 'شلن'") or die($conn->error());
    if (empty($result14)){
    $shil_incomes = 0;
    }else{
    $row14 = $result14->fetch_assoc();
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

    $pdf->SetDrawColor(0,0,0);

    $pdf->Ln(0.5);
    $pdf->Cell(17,10,number_format($exchange),'B',0,'C',1,0, 0, false, 'C');
    $pdf->Cell(20,5,number_format($shil_total_expenses),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_debts),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_expenses),'B',0,'C',1,0);
    if (is_numeric($shil_minfo)){
    $pdf->Cell(18.3,5,number_format($shil_minfo),'B',0,'C',1,0);
    }else{
    $pdf->SetTextColor(150,0,0);
    $pdf->Cell(18.3,5,$shil_minfo,'B',0,'C',1,0);
    }
    $pdf->SetTextColor(0,0,0);
    if (is_numeric($shil_expensesm)){
    $pdf->Cell(18.3,5,number_format($shil_expensesm),'B',0,'C',1,0);
    }else{
    $pdf->SetTextColor(150,0,0);
    $pdf->Cell(18.3,5,$shil_expensesm,'B',0,'C',1,0);
    }
    $pdf->SetTextColor(0,0,0);
    if (is_numeric($shil_expensesr)){
    $pdf->Cell(18.3,5,number_format($shil_expensesr),'B',0,'C',1,0);
    }else{
    $pdf->SetTextColor(150,0,0);
    $pdf->Cell(18.3,5,$shil_expensesr,'B',0,'C',1,0);
    }
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(18.3,5,number_format($shil_cash),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_incomes),'B',0,'C',1,0);
    $pdf->Cell(12,5,'شلن','B',0,'C',1,0);
    $pdf->Cell(13,10,$row['m_name'],'B',1,'C',1,0, 0, false, 'C');





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


//*************************


   
}
}


    $pdf->Ln(0.5);
    $pdf->SetDrawColor(180,180,180);

    $pdf->Cell(17,5,'','B',0,'C',1,0);
    $pdf->Cell(20,5,number_format($dollar_total_expenses_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($dollar_debts_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($dollar_expenses_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,'','B',0,'C',1,0);
    $pdf->Cell(18.3,5,'','B',0,'C',1,0);
    $pdf->Cell(18.3,5,'','B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($dollar_cash_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($dollar_incomes_t),'B',0,'C',1,0);
    $pdf->Cell(12,5,'دولار','B',1,'C',1,0);

    $pdf->SetDrawColor(0,0,0);

    $pdf->Cell(17,5,'','B',0,'C',1,0);
    $pdf->Cell(20,5,number_format($shil_total_expenses_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_debts_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_expenses_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_minfo_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_expensesm_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_expensesr_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_cash_t),'B',0,'C',1,0);
    $pdf->Cell(18.3,5,number_format($shil_incomes_t),'B',0,'C',1,0);
    $pdf->Cell(12,5,'شلن','B',0,'C',1,0);
    $pdf->Cell(13,10,'الاجمالي','B',1,'C',1,0, 0, false, 'C');




//************ totals
    $result100 = $conn->query("SELECT * FROM balances WHERE b_currency = 'دولار' AND b_year = '".$_GET['y']."'") or die($conn->error());
    $row100 = $result100->fetch_assoc();
    $result200 = $conn->query("SELECT * FROM balances WHERE b_currency = 'شلن' AND b_year = '".$_GET['y']."'") or die($conn->error());
    $row200 = $result200->fetch_assoc();

    $dollar_beggin = $row100['b_amount'];
    $shil_beggin = $row200['b_amount'];

    $dollar_final = $dollar_beggin + $dollar_incomes_t - $dollar_cash_t - $dollar_total_expenses_t;
    $shil_final = $shil_beggin + $shil_incomes_t + $shil_cash_t - $shil_total_expenses_t;



    $pdf->SetXY(10,85);
    $pdf->SetFont('aealarabiya','',14);

    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(190,5,'التقرير الاجمالي السنوي',0,1,'R',1,0);

    $pdf->Ln(1);
    $pdf->SetFillColor(0,0,0);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetFont('aealarabiya','',10);
    $pdf->Cell(35,5,'الرصيد الحالي',0,0,'C',1,0);
    $pdf->Cell(35,5,'اجمالي المصروفات','L',0,'C',1,0);
    $pdf->Cell(35,5,'اجمالي صرف العملات','L',0,'C',1,0);
    $pdf->Cell(35,5,'اجمالي الواردات','L',0,'C',1,0);
    $pdf->Cell(35,5,'الرصيد المدور','L',0,'C',1,0);
    $pdf->Cell(15,5,'العملة','L',1,'R',1,0);

    $pdf->SetFont('aealarabiya','',8.5);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(180,180,180);

    if ($dollar_final < 0){
    $pdf->SetFillColor(255,185,185);
    }else{
    $pdf->SetFillColor(185,255,185);
    }
    $pdf->Cell(35,5,number_format($dollar_final),'B',0,'C',1,0);

    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(35,5,number_format($dollar_total_expenses_t),'B',0,'C',1,0);
    $pdf->Cell(35,5,number_format($dollar_cash_t),'B',0,'C',1,0);
    $pdf->Cell(35,5,number_format($dollar_incomes_t),'B',0,'C',1,0);
    $pdf->Cell(35,5,number_format($dollar_beggin),'B',0,'C',1,0);
    $pdf->Cell(15,5,'دولار','B',1,'R',1,0);

    $pdf->Ln(0.1);
    if ($shil_final < 0){
    $pdf->SetFillColor(255,185,185);
    }else{
    $pdf->SetFillColor(185,255,185);
    }
    $pdf->Cell(35,5,number_format($shil_final),'B',0,'C',1,0);

    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(35,5,number_format($shil_total_expenses_t),'B',0,'C',1,0);
    $pdf->Cell(35,5,number_format($shil_cash_t),'B',0,'C',1,0);
    $pdf->Cell(35,5,number_format($shil_incomes_t),'B',0,'C',1,0);
    $pdf->Cell(35,5,number_format($shil_beggin),'B',0,'C',1,0);
    $pdf->Cell(15,5,'شلن','B',1,'R',1,0);

//*********************************************


    $shil_beggin_dollar = $shil_beggin / $exchange1;
    $beggin = $shil_beggin_dollar + $dollar_beggin;

    $shil_incomes_dollar = $shil_incomes_t / $exchange1;

    $incomes_final = $dollar_incomes_t + $shil_incomes_dollar;

    $shil_expenses_final = $shil_total_expenses_t1 / $exchange1;

    $expenses_final = $dollar_expenses_t + $shil_expenses_final;

//*******chart 1
$pdf->SetFont('aealarabiya','',8.5);
$chartX=10;
$chartY=40;

$chartWidth=75;
$chartHeight=50;

$chartTopPadding=10;
$chartLeftPadding=20;
$chartBottomPadding=20;
$chartRightPadding=5;

$chartBoxX=$chartX+$chartLeftPadding;
$chartBoxY=$chartY+$chartTopPadding;
$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
$chartBoxHeight=$chartHeight-$chartTopPadding-$chartBottomPadding;

$barWidth=7.5;

$data=array(
    'ايرادات'=>[
        'color'=>[0,180,0],
        'value'=>$incomes_final
    ],
    'مصروفات'=>[
        'color'=>[0,0,180],
        'value'=>$expenses_final
    ]
);

$dataMax=0;
foreach ($data as $item) {
    if($item['value']>$dataMax)$dataMax=$item['value'];
}

if ($beggin > 0){
    $total100 = $beggin + $incomes_final;
    if ($total100 > $dataMax){
        $dataMax = $total100;
    }
}else{
    $total100 = abs($beggin) + $expenses_final;
    if ($total100 > $dataMax){
        $dataMax = $total100;
    }
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

    $pdf->SetFillColor($item['color'][0],$item['color'][1],$item['color'][2]);
    $pdf->SetDrawColor($item['color'][0],$item['color'][1],$item['color'][2]);

    $barHeight=$yAxisUnits * $item['value'];

    $barX=($xLabelWidth/2)+($xLabelWidth*$barXPos);
    $barX=$barX-($barWidth/2);
    $barX=$barX+$chartBoxX;

    $barY = $chartBoxHeight-$barHeight;
    $barY=$barY+$chartBoxY-0.2;

    $pdf->Rect($barX,$barY + 0.5,$barWidth,$barHeight - 0.5,'DF');

    $barXPos++;
}

    $barHeight = $yAxisUnits * abs($beggin);
    $barY = $chartBoxHeight-$barHeight;
    $barY=$barY+$chartBoxY;

    $pdf->SetFillColor(180,0,0);
    $pdf->SetDrawColor(180,0,0);

    if ($beggin < 0){
    $barY = $barY - ($yAxisUnits * $expenses_final);
    $pdf->Rect($barX,$barY,$barWidth,$barHeight,'DF');
    }elseif ($beggin > 0){
    $barY = $barY - ($yAxisUnits * $incomes_final);
    $pdf->Rect($barX-25,$barY,$barWidth,$barHeight,'DF');
    }

    if ($beggin != 0){
    $sqX = $chartX + ($chartBoxWidth / 2) + 30;
    $pdf->Rect($sqX,$chartY,1.5,1.5,'DF');
    $pdf->SetXY($sqX - 10,$chartY - 1.5);
    $pdf->Cell(5,0,"الرصيد المدور",0,0,'C');
    }


$pdf->SetDrawColor(0);
$pdf->SetFont('aealarabiya','',8);
$pdf->SetXY(($chartWidth/2)-30+$chartX,$chartY+$chartHeight-($chartBottomPadding/2)-3);
$pdf->Cell($chartWidth,0,"الايرادات والمصروفات بالدولار",0,0,'C');
//***************************************************





}else{
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('aealarabiya','',40);
	$pdf->SetTextColor(200,0,0);
	$pdf->Cell(190,15,'الرجاء اكمال بيانات التقرير',0,1,'C',1,0);
}
}
$pdf->output('final_report_'.$_GET['y'].'.pdf');
}else{
    header("Location: login.php");
}
?>