<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$update = false;
$id = 0;
$year = date('Y');
$e_date = date('Y-m-d');
$e_notice = '';
$e_amount = '';

if (isset($_POST['save'])){
	$e_date = $_POST['e_date'];
	$e_currency = $_POST['e_currency'];
	$e_amount = $_POST['e_amount'];
	$e_comparison = $_POST['e_comparison'];
	$e_notice = $_POST['e_notice'];

	if ($e_notice !== '' and $e_amount !== '' and $e_date !==''){
	$conn->query("INSERT INTO expenses (e_comparison, e_notice, e_currency, e_amount, e_date) VALUES('$e_comparison','$e_notice','$e_currency','$e_amount','$e_date')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة المصروفات بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/expenses.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/expenses.php");
}
}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM expenses WHERE id=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف المصروفات بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/expenses.php");
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM expenses WHERE ID=$id") or die($conn->error());
	if (empty($result)){
	}else{
		$row = $result->fetch_array();
		$e_comparison = $row['e_comparison'];
		$e_notice = $row['e_notice'];
		$e_currency = $row['e_currency'];
		$e_amount = $row['e_amount'];
		$e_date = $row['e_date'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$e_comparison = $_POST['e_comparison'];
	$e_notice = $_POST['e_notice'];
	$e_currency = $_POST['e_currency'];
	$e_amount = $_POST['e_amount'];
	$e_date = $_POST['e_date'];

	if ($e_notice !== '' and $e_amount !== '' and $e_date !==''){
	$conn->query("UPDATE expenses SET e_comparison='$e_comparison', e_notice='$e_notice', e_currency='$e_currency', e_amount='$e_amount', e_date='$e_date' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث المصروفات بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/expenses.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/expenses.php?edit=$id");
}
}
?>