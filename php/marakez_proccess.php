<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$mname = '';
$myear = date('Y');
$update = false;
if (isset($_POST['save'])){
	$mname = $_POST['mname'];
	$myear = $_POST['myear'];
	$mtype = $_POST['mtype'];
	$mname = ltrim($mname);
	$myear = ltrim($myear);

	if ($mname !== '' and $myear !== ''){
	$conn->query("INSERT INTO marakez (mname,myear,mtype) VALUES('$mname','$myear','$mtype')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة المركز بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/marakez.php");
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/marakez.php");
}

}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM marakez WHERE id=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف المركز بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/marakez.php");
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM marakez WHERE ID=$id") or die($conn->error());
	if (empty($result)){
}
		else{
		$row = $result->fetch_array();
		$mname = $row['mname'];
		$myear = $row['myear'];
		$mtype = $row['mtype'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$mname = $_POST['mname'];
	$myear = $_POST['myear'];
	$mtype = $_POST['mtype'];
	$mname = ltrim($mname);
	$myear = ltrim($myear);
	if ($mname !== ''){
	$conn->query("UPDATE marakez SET mname='$mname', myear='$myear', mtype='$mtype' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث المركز بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/marakez.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/marakez.php?edit=$id");
}
}
?>