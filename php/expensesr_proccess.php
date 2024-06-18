<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$update = false;
if (isset($_POST['save'])){
$count = count($_POST['r_item']);
	for ($i=0; $i < $count; $i++) {
	$query = $conn->query("INSERT INTO expensesr (r_item, r_month, r_year, r_amount) VALUES('{$_POST['r_item'][$i]}','{$_POST['r_month']}','{$_POST['r_year']}','{$_POST['r_amount'][$i]}')") or die($conn->error());
	}
	if ($query) {
	$conn->query("INSERT INTO rok (k_year, k_month, k_type, r_type) VALUES('{$_POST['r_year']}','{$_POST['r_month']}',0,6)") or die($conn->error());
	$_SESSION['message'] = "تم حفظ البيانات بنجاح";
	$_SESSION['msg_type'] = "success";
}else{
	$_SESSION['message'] = "لا يمكن حفظ البيانات";
	$_SESSION['msg_type'] = "danger";
}
	header("Location:http://localhost/khma/expensesr.php");
}

if (isset($_POST['update'])){
$count = count($_POST['id1']);
	for ($i=0; $i < $count; $i++) { 

	$conn->query("UPDATE expensesr SET r_amount='{$_POST['r_amount1'][$i]}' WHERE ID='{$_POST['id1'][$i]}'") or die($conn->error());
}
	$_SESSION['message'] = "تم تحديث التقرير بنجاح";
	$_SESSION['msg_type'] = "success";
	if ($_POST['r1']==1){
	header('Location:http://localhost/khma/reports.php');
}else{
	header('Location:http://localhost/khma/frok.php');
}
}
?>