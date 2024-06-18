<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$update = false;
$id = 0;
$year = date('Y');
$d_date = date('Y-m-d');
$d_notice = '';
$d_amount = '';
$d_number = '';
$d_admin = '';

if (isset($_POST['save'])){
	$d_date = $_POST['d_date'];
	$d_markaz = $_POST['d_markaz'];
	$d_currency = $_POST['d_currency'];
	$d_amount = $_POST['d_amount'];
	$d_admin = $_POST['d_admin'];
	$d_notice = $_POST['d_notice'];
	$d_number = $_POST['d_number'];
	$i_year = DateTime::createFromFormat("Y-m-d", $d_date);
	$i_year = $i_year->format('Y');

	if ($d_admin !== '' and $d_amount !== '' and $d_date !=='' and $d_markaz !== ''){
	$res = $conn->query("SELECT * FROM rok WHERE k_year = '$i_year' AND r_type = 7") or die($conn->error());
	if (mysqli_num_rows($res) == 0){
	$conn->query("INSERT INTO rok (k_year, k_month, k_type, r_type) VALUES('$i_year',13,1,7)") or die($conn->error());
	}

	$conn->query("INSERT INTO debts (d_markaz, d_notice, d_currency, d_amount, d_date, d_admin, d_number) VALUES('$d_markaz','$d_notice','$d_currency','$d_amount','$d_date','$d_admin','$d_number')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة سداد المديونيات بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/debts.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/debts.php");
}
}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM debts WHERE id=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف سداد  المديونيات بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/debts.php");
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM debts WHERE ID=$id") or die($conn->error());
	if (empty($result)){
	}else{
		$row = $result->fetch_array();
		$d_date = $row['d_date'];
		$d_markaz = $row['d_markaz'];
		$d_currency = $row['d_currency'];
		$d_amount = $row['d_amount'];
		$d_admin = $row['d_admin'];
		$d_notice = $row['d_notice'];
		$d_number = $row['d_number'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$d_date = $_POST['d_date'];
	$d_markaz = $_POST['d_markaz'];
	$d_currency = $_POST['d_currency'];
	$d_amount = $_POST['d_amount'];
	$d_admin = $_POST['d_admin'];
	$d_notice = $_POST['d_notice'];
	$d_number = $_POST['d_number'];

	if ($d_admin !== '' and $d_amount !== '' and $d_date !=='' and $d_markaz !==''){
	$conn->query("UPDATE debts SET d_markaz='$d_markaz', d_notice='$d_notice', d_currency='$d_currency', d_amount='$d_amount', d_date='$d_date', d_number='$d_number', d_admin='$d_admin' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث سداد المديونيات بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/debts.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/debts.php?edit=$id");
}
}
?>