<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$kusername = '';
if (isset($_POST['update'])){
	$id = $_POST['id'];
	$newurl = $_POST['newurl'];
	$newurl = ltrim($newurl);
	if ($newurl !== ''){
	$conn->query("UPDATE pictures SET p_source='$newurl' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث الشعار بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/logos.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/logos.php");	
}
}
?>