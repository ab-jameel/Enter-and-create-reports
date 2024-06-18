<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$markaz_name = '';
$group_name = '';
$the_year = date('Y');
$update = false;
if (isset($_POST['save'])){
	$markaz_name = $_POST['markaz_name'];
	$group_name = $_POST['group_name'];
	$the_year = $_POST['the_year'];
	$markaz_name = ltrim($markaz_name);
	$group_name = ltrim($group_name);
	$the_year = ltrim($the_year);

	if ($markaz_name !== '' and $group_name !== '' and $the_year !==''){
	$conn->query("INSERT INTO groups (markaz_name, group_name, the_year) VALUES('$markaz_name','$group_name','$the_year')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة الفرقة بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/groups.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/groups.php");
}
}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM groups WHERE id=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف الفرقة بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/groups.php");
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM groups WHERE ID=$id") or die($conn->error());
	if (empty($result)){
}
		else{
		$row = $result->fetch_array();
		$markaz_name = $row['markaz_name'];
		$group_name = $row['group_name'];
		$the_year = $row['the_year'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$markaz_name = $_POST['markaz_name'];
	$group_name = $_POST['group_name'];
	$the_year = $_POST['the_year'];
	$markaz_name = ltrim($markaz_name);
	$group_name = ltrim($group_name);
	$the_year = ltrim($the_year);


	if ($markaz_name !== '' and $group_name !== '' and $the_year !== ''){
	$conn->query("UPDATE groups SET markaz_name='$markaz_name', group_name='$group_name', the_year='$the_year' WHERE ID=$id") or die($conn->error());
	$_SESSION['message'] = "تم تحديث الفرقة بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/groups.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/groups.php?edit=$id");
}
}
?>