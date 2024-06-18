<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$m_markaz = '';
$m_num1 = '';
$m_coss1 = '';
$m_num2 = '';
$m_coss2 = '';
$m_num3 = '';
$m_coss3 = '';
$m_coss4 = '';
$update = false;
if (isset($_POST['save'])){
$count = count($_POST['m_num1']);
	for ($i=0; $i < $count; $i++) {
	if ($_POST['m_coss4'][$i] == 0){
		$m_num4 = 0;
	}else{
		$m_num4 = 1;
	}

	$m_coss11 = $_POST['m_coss1'][$i] * $_POST['m_num1'][$i];
	$m_coss22 = $_POST['m_coss2'][$i] * $_POST['m_num2'][$i];
	$m_coss33 = $_POST['m_coss3'][$i] / $_POST['m_num3'][$i];

	$query = $conn->query("INSERT INTO minfo (m_markaz, m_month, m_year, m_num1, m_coss1, m_coss11, m_num2, m_coss2, m_coss22, m_num3, m_coss3, m_coss33, m_num4, m_coss4) VALUES('{$_POST['m_markaz'][$i]}','{$_POST['m_month']}','{$_POST['m_year']}','{$_POST['m_num1'][$i]}','{$_POST['m_coss1'][$i]}','$m_coss11','{$_POST['m_num2'][$i]}','{$_POST['m_coss2'][$i]}','$m_coss22','{$_POST['m_num3'][$i]}','{$_POST['m_coss3'][$i]}','$m_coss33','$m_num4','{$_POST['m_coss4'][$i]}')") or die($conn->error());
}
	if ($query){
	$conn->query("INSERT INTO rok (k_year, k_month, k_type, r_type) VALUES('{$_POST['m_year']}','{$_POST['m_month']}',0,2)") or die($conn->error());
	$_SESSION['message'] = "تم حفظ البيانات بنجاح";
	$_SESSION['msg_type'] = "success";
}else{
	$_SESSION['message'] = "لا يمكن حفظ البيانات";
	$_SESSION['msg_type'] = "danger";
}
	header("Location:http://localhost/khma/minfo.php");
}

if (isset($_POST['update'])){
$count = count($_POST['id1']);
	for ($i=0; $i < $count; $i++) { 
	if ($_POST['m_coss41'][$i] == 0){
		$m_num4 = 0;
	}else{
		$m_num4 = 1;
	}
	
	$m_coss11 = $_POST['m_coss11'][$i] * $_POST['m_num11'][$i];
	$m_coss22 = $_POST['m_coss21'][$i] * $_POST['m_num21'][$i];
	$m_coss33 = $_POST['m_coss31'][$i] / $_POST['m_num31'][$i];

	$conn->query("UPDATE minfo SET m_num1='{$_POST['m_num11'][$i]}', m_coss1='{$_POST['m_coss11'][$i]}', m_coss11='$m_coss11', m_num2='{$_POST['m_num21'][$i]}', m_coss2='{$_POST['m_coss21'][$i]}', m_coss22='$m_coss22', m_num3='{$_POST['m_num31'][$i]}', m_coss3='{$_POST['m_coss31'][$i]}', m_coss33='$m_coss33', m_num4='$m_num4', m_coss4='{$_POST['m_coss41'][$i]}' WHERE ID='{$_POST['id1'][$i]}'") or die($conn->error());
}
	$_SESSION['message'] = "تم تحديث التقرير بنجاح";
	$_SESSION['msg_type'] = "success";
	if ($_POST['r1']==1){
	header('Location:http://localhost/khma/reports.php');
}else{
	header('Location:http://localhost/khma/crok.php');
}
}
?>