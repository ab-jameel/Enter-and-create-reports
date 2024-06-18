<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$update = false;
$id = 0;
$c_date = date('Y-m-d');
$c_admin = '';
$c_dollar = '';
$c_exchange = '';
$c_number = '';

if (isset($_POST['save'])){
	$c_date = $_POST['c_date'];
	$c_admin = $_POST['c_admin'];
	$c_dollar = $_POST['c_dollar'];
	$c_exchange = $_POST['c_exchange'];
	$c_number = $_POST['c_number'];

	if ($c_admin !== '' and $c_exchange !== '' and $c_date !=='' and $c_dollar !== ''){
	$conn->query("INSERT INTO cash (c_dollar, c_admin, c_exchange, c_date, c_number) VALUES('$c_dollar','$c_admin','$c_exchange','$c_date','$c_number')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة صرف العملة بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/cash.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/cash.php");
}
}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM cash WHERE id=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف صرف العملة بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/cash.php");
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM cash WHERE ID=$id") or die($conn->error());
	if (empty($result)){
	}else{
		$row = $result->fetch_array();
		$c_date = $row['c_date'];
		$c_admin = $row['c_admin'];
		$c_dollar = $row['c_dollar'];
		$c_exchange = $row['c_exchange'];
		$c_number = $row['c_number'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$c_date = $_POST['c_date'];
	$c_admin = $_POST['c_admin'];
	$c_dollar = $_POST['c_dollar'];
	$c_exchange = $_POST['c_exchange'];
	$c_number = $_POST['c_number'];

	if ($c_admin !== '' and $c_exchange !== '' and $c_date !=='' and $c_dollar !== ''){
	$conn->query("UPDATE cash SET c_dollar='$c_dollar', c_admin='$c_admin', c_exchange='$c_exchange', c_date='$c_date', c_number='$c_number' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث صرف العملة بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/cash.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/cash.php?edit=$id");
}
}
?>