<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$p_markaz = '';
$p_quantity = '';
$p_price = '';
$p_item = '';
$update = false;

if (isset($_POST['save'])){
$count = count($_POST['p_quantity']);
	for ($i=0; $i < $count; $i++) {
	if ($_POST['p_quantity'][$i] == '' or $_POST['p_quantity'][$i] == 0){
		$_POST['p_price'][$i] = 0;
	}
	$query = $conn->query("INSERT INTO portions (p_markaz, p_month, p_year, p_quantity, p_price, p_item) VALUES('{$_POST['p_markaz'][$i]}','{$_POST['p_month']}','{$_POST['p_year']}','{$_POST['p_quantity'][$i]}','{$_POST['p_price'][$i]}','{$_POST['p_item'][$i]}')") or die($conn->error());
}
	if ($query){
	$conn->query("INSERT INTO rok (k_year, k_month, k_type, r_type) VALUES('{$_POST['p_year']}','{$_POST['p_month']}',0,3)") or die($conn->error());
	$res1 = $conn->query("SELECT * FROM rok WHERE k_year = '{$_POST['p_year']}' AND r_type = 9") or die($conn->error());
	$num1 = mysqli_num_rows($res1);
	if ($num1 == 0){
	$conn->query("INSERT INTO rok (k_year, k_month, k_type, r_type) VALUES('{$_POST['p_year']}',13,1,9)") or die($conn->error());		
	}
	$_SESSION['message'] = "تم حفظ البيانات بنجاح";
	$_SESSION['msg_type'] = "success";
}else{
	$_SESSION['message'] = "لا يمكن حفظ البيانات";
	$_SESSION['msg_type'] = "danger";
}
	header("Location:http://localhost/khma/portion.php");
}

if (isset($_POST['update'])){
$count = count($_POST['id1']);
	for ($i=0; $i < $count; $i++) { 
	if ($_POST['p_quantity1'][$i] == '' or $_POST['p_quantity1'][$i] == 0){
		$_POST['p_price1'][$i] = 0;
	}
	$conn->query("UPDATE portions SET p_quantity='{$_POST['p_quantity1'][$i]}', p_price='{$_POST['p_price1'][$i]}' WHERE ID='{$_POST['id1'][$i]}'") or die($conn->error());
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