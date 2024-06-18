<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$i_name = '';
$update = false;
if (isset($_POST['save'])){
	$i_name = $_POST['i_name'];
	$i_type = $_POST['i_type'];
	$i_name = ltrim($i_name);

	if ($i_name !== ''){
	$conn->query("INSERT INTO eitems (i_name,i_type) VALUES('$i_name','$i_type')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة البند بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/eitems.php");
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/eitems.php");
}

}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM eitems WHERE id=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف البند بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/eitems.php");
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM eitems WHERE ID=$id") or die($conn->error());
	if (empty($result)){
}
		else{
		$row = $result->fetch_array();
		$i_name = $row['i_name'];
		$i_type = $row['i_type'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$i_name = $_POST['i_name'];
	$i_type = $_POST['i_type'];
	$i_name = ltrim($i_name);
	if ($i_name !== ''){
	$conn->query("UPDATE eitems SET i_name='$i_name', i_type='$i_type' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث البند بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/eitems.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/eitems.php?edit=$id");
}
}
?>