<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$name1 = '';
$update = false;

if (isset($_POST['save'])){
	$name = $_POST['name'];

	if ($name !== ''){
	$conn->query("INSERT INTO programs (p_name) VALUES('$name')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة البرنامج بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/info.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/info.php");
}
}

if (isset($_POST['save2'])){
	$name = $_POST['name'];

	if ($name !== ''){
	$conn->query("INSERT INTO axis (a_name) VALUES('$name')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة المحور بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/info.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/info.php");
}
}

if (isset($_POST['save3'])){
	$name = $_POST['name'];

	if ($name !== ''){
	$conn->query("INSERT INTO ctype (t_name) VALUES('$name')") or die($conn->error());
	$_SESSION['message'] = "تم اضافة النوع بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/info.php");
}else {
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/info.php");
}
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM programs WHERE ID=$id") or die($conn->error());
	if (empty($result)){
	}else{
		$row = $result->fetch_array();
		$name = $row['p_name'];
	}
}

if (isset($_GET['edit2'])){
	$id=$_GET['edit2'];
	$update = true;
	$result=$conn->query("SELECT * FROM axis WHERE ID=$id") or die($conn->error());
	if (empty($result)){
	}else{
		$row = $result->fetch_array();
		$name = $row['a_name'];
	}
}

if (isset($_GET['edit3'])){
	$id=$_GET['edit3'];
	$update = true;
	$result=$conn->query("SELECT * FROM ctype WHERE ID=$id") or die($conn->error());
	if (empty($result)){
	}else{
		$row = $result->fetch_array();
		$name = $row['t_name'];
	}
}

if (isset($_POST['update'])){
	$id = $_POST['id'];
	$selected = $_POST['selected'];
	$name = $_POST['name1'];
	if ($name !== ''){
	if ($selected == 1){
	$conn->query("UPDATE programs SET p_name='$name' WHERE ID=$id") or die($conn->error());
	}elseif ($selected == 2){
	$conn->query("UPDATE axis SET a_name='$name' WHERE ID=$id") or die($conn->error());
	}elseif($selected == 3){
	$conn->query("UPDATE ctype SET t_name='$name' WHERE ID=$id") or die($conn->error());
	}
	$_SESSION['message'] = "تم تحديث البيانات بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/info.php');
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقل الفارغ";
	$_SESSION['msg_type'] = "danger";
	if ($selected == 1){
	header("Location:http://localhost/khma/info.php?edit=$id");
	}elseif ($selected == 2){
	header("Location:http://localhost/khma/info.php?edit2=$id");
	}elseif($selected == 3){
	header("Location:http://localhost/khma/info.php?edit3=$id");
	}
}
}
?>