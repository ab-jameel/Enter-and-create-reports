<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$e_markaz = '';
$e_num = '';
$e_every = '';
$e_item = '';
$update = false;

if (isset($_POST['save'])){
$count = count($_POST['e_markaz']);
	for ($i=0; $i < $count; $i++) {
	if ($_POST['i_type'][$i] == 2 and $_POST['e_num'][$i] == 0){
		$_POST['e_monthly'][$i] = 0;
	}
	if ($_POST['i_type'][$i] == 1 and $_POST['e_monthly'][$i] != 0){
			$_POST['e_num'][$i] = 1;
	}
	$query = $conn->query("INSERT INTO expensesm (e_markaz, e_month, e_year, e_num, e_item, e_monthly) VALUES('{$_POST['e_markaz'][$i]}','{$_POST['e_month']}','{$_POST['e_year']}','{$_POST['e_num'][$i]}','{$_POST['e_item'][$i]}','{$_POST['e_monthly'][$i]}')") or die($conn->error());
}
	if ($query){
	$conn->query("INSERT INTO rok (k_year, k_month, k_type, r_type) VALUES('{$_POST['e_year']}','{$_POST['e_month']}',0,5)") or die($conn->error());
	$_SESSION['message'] = "تم حفظ البيانات بنجاح";
	$_SESSION['msg_type'] = "success";
}else{
	$_SESSION['message'] = "لا يمكن حفظ البيانات";
	$_SESSION['msg_type'] = "danger";
}
	header("Location:http://localhost/khma/expensesm.php");
}

if (isset($_POST['update'])){
$count = count($_POST['id1']);
	for ($i=0; $i < $count; $i++) {
	if ($_POST['i_type1'][$i] == 2 and $_POST['e_num1'][$i] == 0){
		$_POST['e_monthly1'][$i] = 0;
	}
	if ($_POST['i_type1'][$i] == 1 and $_POST['e_monthly1'][$i] != 0){
			$_POST['e_num1'][$i] = 1;
	}
	$conn->query("UPDATE expensesm SET e_num='{$_POST['e_num1'][$i]}', e_monthly='{$_POST['e_monthly1'][$i]}' WHERE ID='{$_POST['id1'][$i]}'") or die($conn->error());
}
	$_SESSION['message'] = "تم تحديث التقرير بنجاح";
	$_SESSION['msg_type'] = "success";
	if ($_POST['r1']==1){
	header('Location:http://localhost/khma/reports.php');
}else{
	header('Location:http://localhost/khma/lrok.php');
}
}
?>