<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$e_price = '';
$e_year = '';
$update = false;

if (isset($_POST['save'])){
	$e_year = $_POST['e_year'];
	$e_price = $_POST['e_price'];

	if ($e_year !== '' and $e_price !== ''){
	for ($i=1; $i <= 12; $i++) {
	$conn->query("INSERT INTO exchange (e_year, e_month, e_price) VALUES('$e_year','$i','$e_price')") or die($conn->error());
	}
	$_SESSION['message'] = "تم اضافة السنة بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/exchange.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/exchange.php");
}
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM exchange WHERE ID=$id") or die($conn->error());
	if (empty($result)){
	}else{
	$row = $result->fetch_array();
	$result2 = $conn->query("SELECT * FROM months WHERE ID=".$row['e_month']) or die($conn->error());
	$row2 = $result2->fetch_array();
		$e_month = $row2['m_name'];
		$e_price = $row['e_price'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$e_price = $_POST['e_price1'];
	if ($e_price !== ''){
	$conn->query("UPDATE exchange SET e_price='$e_price' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث سعر الصرف بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/exchange.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/exchange.php?edit=$id");
}
}
?>