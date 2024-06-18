<?php
require_once '../connect.php';

if (isset($_POST['e_date'])){
$e_date = $_POST['e_date'];
$result1 = $conn->query("SELECT * FROM programs") or die($conn->error());
while ($row1 = $result1->fetch_assoc()){
$result2 = $conn->query("SELECT * FROM comparison WHERE c_year='".$e_date."' AND c_program LIKE '".$row1['p_name']."'") or die($conn->error());
$num2 = mysqli_num_rows($result2);
if ($num2 > 0){
	echo "<option>";
	echo $row1['p_name'];
	echo "</option>";
	}
}}

if (isset($_POST['search'])){
$searchq = $_POST['search'];
$output = '';

session_start();
$id = $_SESSION['id'];

$result2 = $conn->query("SELECT premissions.*, pages.p_name FROM premissions INNER JOIN pages ON premissions.p_page = pages.ID WHERE p_user=$id") or die($conn->error());
while ($row2 = $result2->fetch_assoc()) {
if ($row2['p_name'] == 'تقرير الايرادات والمصروفات'){
$expensesr_pdf = $row2['p_pdf'];
}
if ($row2['p_name'] == 'المصروفات التشغيلية'){
$expensesr_edit = $row2['p_edit'];
}
if ($row2['p_name'] == 'مصروفات المراكز'){
$expensesm_pdf = $row2['p_pdf'];
$expensesm_edit = $row2['p_edit'];
}
if ($row2['p_name'] == 'مسيرات الرواتب'){
$salary_pdf = $row2['p_pdf'];
$salary_edit = $row2['p_edit'];
}
if ($row2['p_name'] == 'نصيب الفرد'){
$portion_pdf = $row2['p_pdf'];
$portion_edit = $row2['p_edit'];
}
if ($row2['p_name'] == 'مصروفات الدعوة'){
$minfo_pdf = $row2['p_pdf'];
$minfo_edit = $row2['p_edit'];
}
if ($row2['p_name'] == 'الحركة الميدانية'){
$maidan_pdf = $row2['p_pdf'];
$maidan_edit = $row2['p_edit'];
}
if ($row2['p_name'] == 'المديونيات'){
$debts = $row2['p_pdf'];
}
if ($row2['p_name'] == 'الايرادات'){
$incomes = $row2['p_pdf'];
}
}

$result = $conn->query("SELECT rok.*, report_months.m_name, treports.t_name FROM rok INNER JOIN treports ON rok.r_type = treports.ID INNER JOIN report_months ON k_month = report_months.ID WHERE k_type = 1 AND (t_name LIKE '%$searchq%' OR k_year LIKE '%$searchq%' OR k_month LIKE '%$searchq%' OR m_name LIKE '%$searchq%') ORDER BY k_year ASC, k_month ASC, r_type ASC") or die($conn->error());
$result1 = $conn->query("SELECT MAX(k_year) as max FROM rok WHERE k_type = 1") or die($conn->error());
if (empty($result1)){
	$max1 = 0;
}else{
	$row1 = $result1->fetch_assoc();
	$max1 = $row1['max'];
}
$num = mysqli_num_rows($result);
	$output .='
	<thead class="thead1">
			<th class="right1">الاجراءات</th>
			<th class="right1">الحالة</th>
			<th class="right1">نوع التقرير</th>
			<th class="right1">الشهر</th>
			<th class="right1">العام</th>
	</thead>';
if ($num > 0){
	while ($row = $result->fetch_assoc()) {
	$year = $row['k_year'];
	$output .= '<tr class="me">';
	$output .= '<td>';
		if ($row['r_type'] == 1){
		if ($maidan_pdf == 1){
	$output .= '<a href="maidan.php?m='.$row['k_month'].'&y='.$row['k_year'].'" target="_blank"><i class="far fa-file-pdf i1"></i></a>';
		}
	if ($year == $max1){
	if ($maidan_edit == 1){
	$output .= '<a href="rprograms.php?edit='.$row['k_year'].'&edit2='.$row['k_month'].'&r=1"><i class="fas fa-pencil-alt i1"></i></a>';}}
		}elseif ($row['r_type'] == 2){
		if ($minfo_pdf == 1){
	$output .= '<a href="money.php?m='.$row['k_month'].'&y='.$row['k_year'].'" target="_blank"><i class="far fa-file-pdf i1"></i></a>';
		}
	if ($year == $max1){
	if ($minfo_edit == 1){
	$output .= '<a href="minfo.php?edit='.$row['k_year'].'&edit2='.$row['k_month'].'&r=1"><i class="fas fa-pencil-alt i1"></i></a>';}}
		}elseif ($row['r_type'] == 3){
		if ($portion_pdf == 1){
	$output .= '<a href="portion_report.php?m='.$row['k_month'].'&y='.$row['k_year'].'" target="_blank"><i class="far fa-file-pdf i1"></i></a>';
		}
	if ($year == $max1){
	if ($portion_edit == 1){
	$output .= '<a href="portion.php?edit='.$row['k_year'].'&edit2='.$row['k_month'].'&r=1"><i class="fas fa-pencil-alt i1"></i></a>';}}
		}elseif ($row['r_type'] == 4){
		if ($salary_pdf == 1){
	$output .= '<a href="salary_report.php?m='.$row['k_month'].'&y='.$row['k_year'].'" target="_blank"><i class="far fa-file-pdf i1"></i></a>';
		}
	if ($year == $max1){
	if ($salary_edit == 1){
	$output .= '<a href="salary.php?edit='.$row['k_year'].'&edit2='.$row['k_month'].'&r=1"><i class="fas fa-pencil-alt i1"></i></a>';}}
 		}elseif ($row['r_type'] == 5){
		if ($expensesm_pdf == 1){
	$output .= '<a href="expensesm_report.php?m='.$row['k_month'].'&y='.$row['k_year'].'" target="_blank"><i class="far fa-file-pdf i1"></i></a>';
		}
	if ($year == $max1){
	if ($expensesm_edit == 1){
	$output .= '<a href="expensesm.php?edit='.$row['k_year'].'&edit2='.$row['k_month'].'&r=1"><i class="fas fa-pencil-alt i1"></i></a>';}}
 		}elseif ($row['r_type'] == 6){
		if ($expensesr_pdf == 1){
	$output .= '<a href="expensesr_report.php?m='.$row['k_month'].'&y='.$row['k_year'].'" target="_blank"><i class="far fa-file-pdf i1"></i></a>';
		}
	if ($year == $max1){
	if ($expensesr_edit == 1){
	$output .= '<a href="expensesr.php?edit='.$row['k_year'].'&edit2='.$row['k_month'].'&r=1"><i class="fas fa-pencil-alt i1"></i></a>';}}
 		}elseif ($row['r_type'] == 7){
		if ($debts == 1){
	$output .= '<a href="debts_report.php?y='.$row['k_year'].'" target="_blank"><i class="far fa-file-pdf i1"></i></a>';
		}
 		}elseif ($row['r_type'] == 8){
		if ($incomes == 1){
	$output .= '<a href="incomes_report.php?y='.$row['k_year'].'" target="_blank"><i class="far fa-file-pdf i1"></i></a>';
		}
		}elseif ($row['r_type'] == 9){
	$output .= '<a href="final_report.php?y='.$row['k_year'].'" target="_blank"><i class="far fa-file-pdf i1"></i></a>';
 		}
	$output .= '</td>';
	$output .= '<td>معتمد</td>';
	$output .= '<td>'.$row['t_name'].'</td>';
	$output .= '<td>'.$row['m_name'].'</td>';
	$output .= '<td>'.$row['k_year'].'</td>';
	$output .= '</tr>';
 	}
}else{
	$output .= '
	<tr> 
		<td colspan="5" style="color: red; font-size: 17px; font-weight: bold; text-align: center;">لا توجد بيانات وفقا لمدخلات البحث</td>
	</tr>';
}
echo $output;
}

?>