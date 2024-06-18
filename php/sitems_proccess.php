<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$i_name = '';
$update = false;
if (isset($_POST['save'])){
	$i_name = $_POST['i_name'];
	$i_name = ltrim($i_name);

	if ($i_name !== ''){
	$conn->query("INSERT INTO sitems (i_name) VALUES('$i_name')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة البند بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/sitems.php");
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/sitems.php");
}

}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM sitems WHERE id=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف البند بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/sitems.php");
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM sitems WHERE ID=$id") or die($conn->error());
	if (empty($result)){
}
		else{
		$row = $result->fetch_array();
		$i_name = $row['i_name'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$i_name = $_POST['i_name'];
	$i_name = ltrim($i_name);
	if ($i_name !== ''){
	$conn->query("UPDATE sitems SET i_name='$i_name' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث البند بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/sitems.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/sitems.php?edit=$id");
}
}
?>