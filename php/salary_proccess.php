<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$s_markaz = '';
$s_num = '';
$s_every = '';
$s_item = '';
$update = false;

if (isset($_POST['save'])){
$count = count($_POST['s_num']);
	for ($i=0; $i < $count; $i++) {
	if ($_POST['s_num'][$i] == '' or $_POST['s_num'][$i] == 0){
	$_POST['s_every'][$i] = 0;
	}
	$query = $conn->query("INSERT INTO salary (s_markaz, s_month, s_year, s_num, s_every, s_item) VALUES('{$_POST['s_markaz'][$i]}','{$_POST['s_month']}','{$_POST['s_year']}','{$_POST['s_num'][$i]}','{$_POST['s_every'][$i]}','{$_POST['s_item'][$i]}')") or die($conn->error());
}
	if ($query){
	$conn->query("INSERT INTO rok (k_year, k_month, k_type, r_type) VALUES('{$_POST['s_year']}','{$_POST['s_month']}',0,4)") or die($conn->error());
	$_SESSION['message'] = "تم حفظ البيانات بنجاح";
	$_SESSION['msg_type'] = "success";
	}else{
	$_SESSION['message'] = "لا يمكن حفظ البيانات";
	$_SESSION['msg_type'] = "danger";
	}
	header("Location:http://localhost/khma/salary.php");
}

if (isset($_POST['update'])){
$count = count($_POST['id1']);
	for ($i=0; $i < $count; $i++) { 
	if ($_POST['s_num1'][$i] == '' or $_POST['s_num1'][$i] == 0){
	$_POST['s_every1'][$i] = 0;
	}
	$conn->query("UPDATE salary SET s_num='{$_POST['s_num1'][$i]}', s_every='{$_POST['s_every1'][$i]}' WHERE ID='{$_POST['id1'][$i]}'") or die($conn->error());
}
	$_SESSION['message'] = "تم تحديث التقرير بنجاح";
	$_SESSION['msg_type'] = "success";
	if ($_POST['r1']==1){
	header('Location:http://localhost/khma/reports.php');
}else{
	header('Location:http://localhost/khma/rok.php');
}
}
?>