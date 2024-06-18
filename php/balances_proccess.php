<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$update = false;
$id = 0;
$b_year = date('Y');
$b_amount = '';
$b_url = '';

if (isset($_POST['save'])){
	$b_year = $_POST['b_year'];
	$b_amount = $_POST['b_amount'];
	$b_currency = $_POST['b_currency'];
	$b_url = $_POST['b_url'];

	if ($b_amount !== '' and $b_year !==''){
	$check = $conn->query("SELECT * FROM balances WHERE b_year = '$b_year' AND b_currency = '$b_currency'") or die($conn->error());
	$num = mysqli_num_rows($check);
	if ($num == 0){
	$conn->query("INSERT INTO balances (b_currency, b_amount, b_year, b_url) VALUES('$b_currency','$b_amount','$b_year','$b_url')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة الرصيد الافتتاحي بنجاح";
	$_SESSION['msg_type'] = "success";
	}else{
	$_SESSION['message'] = "البيانات مضافة مسبقا";
	$_SESSION['msg_type'] = "danger";
	}
	header("Location:http://localhost/khma/balances.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/balances.php");
}
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM balances WHERE ID=$id") or die($conn->error());
	if (empty($result)){
	}else{
		$row = $result->fetch_array();
		$b_year = $row['b_year'];
		$b_amount = $row['b_amount'];
		$b_currency = $row['b_currency'];
		$b_url = $row['b_url'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$b_year = $_POST['b_year'];
	$b_amount = $_POST['b_amount'];
	$b_currency = $_POST['b_currency'];
	$b_url = $_POST['b_url'];

	if ($b_amount !== '' and $b_year !==''){
	$check = $conn->query("SELECT * FROM balances WHERE b_year = '$b_year' AND b_currency = '$b_currency' AND ID != '$id'") or die($conn->error());
	$num = mysqli_num_rows($check);
	if ($num == 0){
	$conn->query("UPDATE balances SET b_currency='$b_currency', b_amount='$b_amount', b_year='$b_year', b_url='$b_url' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث الرصيد الافتتاحي بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/balances.php");
	}else{
	$_SESSION['message'] = "البيانات مضافة مسبقا";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/balances.php?edit=$id");
	}
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/balances.php?edit=$id");
}
}
?>