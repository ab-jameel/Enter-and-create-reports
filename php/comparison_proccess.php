<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$result = $conn->query("SELECT * FROM comparison ORDER BY c_year DESC") or die($conn->error());
$num = mysqli_num_rows($result);
$row = $result->fetch_assoc();
if ($num > 0){
	$last = $row['c_year'];
}else{
	$last = date('Y');
}
$id = 0;
$c_year = $last;
$update = false;
$c_amount = '';

if (isset($_POST['save'])){
	$c_year = $_POST['c_year'];
	$c_program = $_POST['c_program'];
	$c_axis = $_POST['c_axis'];
	$c_amount = $_POST['c_amount'];
	$c_type = $_POST['c_type'];
	$c_markaz = $_POST['c_markaz'];
	$c_year = ltrim($c_year);
	$c_amount = ltrim($c_amount);

	if ($c_year !== '' and $c_amount !== ''){
	$conn->query("INSERT INTO comparison (c_year, c_program, c_axis, c_amount, c_type, c_markaz) VALUES('$c_year','$c_program','$c_axis','$c_amount','$c_type','$c_markaz')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة الموازنة بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/comparison.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/comparison.php");
}
}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM comparison WHERE id=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف الموازنة بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/comparison.php");
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM comparison WHERE ID=$id") or die($conn->error());
	if (empty($result)){
}
		else{
		$row = $result->fetch_array();
		$c_year = $row['c_year'];
		$c_program = $row['c_program'];
		$c_axis = $row['c_axis'];
		$c_amount = $row['c_amount'];
		$c_type = $row['c_type'];
		$c_markaz = $row['c_markaz'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$c_year = $_POST['c_year'];
	$c_program = $_POST['c_program'];
	$c_axis = $_POST['c_axis'];
	$c_amount = $_POST['c_amount'];
	$c_type = $_POST['c_type'];
	$c_markaz = $_POST['c_markaz'];
	$c_year = ltrim($c_year);
	$c_amount = ltrim($c_amount);


	if ($c_year !== '' and $c_amount !== ''){
	$conn->query("UPDATE comparison SET c_year='$c_year', c_program='$c_program', c_axis='$c_axis', c_amount='$c_amount', c_type='$c_type', c_markaz='$c_markaz' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث الموازنة بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/comparison.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/comparison.php?edit=$id");
}
}
?>