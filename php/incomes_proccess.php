<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$update = false;
$id = 0;
$i_admin = '';
$i_amount = '';
$i_number = '';
$i_date = date('Y-m-d');

if (isset($_POST['save'])){
	$i_source = $_POST['i_source'];
	$i_admin = $_POST['i_admin'];
	$i_currency = $_POST['i_currency'];
	$i_amount = $_POST['i_amount'];
	$i_date = $_POST['i_date'];
	$i_number = $_POST['i_number'];
	$i_year = DateTime::createFromFormat("Y-m-d", $i_date);
	$i_year = $i_year->format('Y');

	if ($i_admin !== '' and $i_amount !== '' and $i_date !=='' and $i_number !==''){
	$res = $conn->query("SELECT * FROM rok WHERE k_year = '$i_year' AND r_type = 8") or die($conn->error());
	if (mysqli_num_rows($res) == 0){
	$conn->query("INSERT INTO rok (k_year, k_month, k_type, r_type) VALUES('$i_year',13,1,8)") or die($conn->error());
	}

	$conn->query("INSERT INTO incomes (i_source, i_admin, i_currency, i_amount, i_date, i_number) VALUES('$i_source','$i_admin','$i_currency','$i_amount','$i_date','$i_number')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة الايراد بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/incomes.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/incomes.php");
}
}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM incomes WHERE id=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف الايراد بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/incomes.php");
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM incomes WHERE ID=$id") or die($conn->error());
	if (empty($result)){
	}else{
		$row = $result->fetch_array();
		$i_source = $row['i_source'];
		$i_admin = $row['i_admin'];
		$i_currency = $row['i_currency'];
		$i_amount = $row['i_amount'];
		$i_date = $row['i_date'];
		$i_number = $row['i_number'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$i_source = $_POST['i_source'];
	$i_admin = $_POST['i_admin'];
	$i_currency = $_POST['i_currency'];
	$i_amount = $_POST['i_amount'];
	$i_date = $_POST['i_date'];
	$i_number = $_POST['i_number'];

	if ($i_admin !== '' and $i_amount !== '' and $i_date !=='' and $i_number !==''){
	$conn->query("UPDATE incomes SET i_source='$i_source', i_admin='$i_admin', i_currency='$i_currency', i_amount='$i_amount', i_date='$i_date', i_number='$i_number' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث الايراد بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/incomes.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/incomes.php?edit=$id");
}
}
?>