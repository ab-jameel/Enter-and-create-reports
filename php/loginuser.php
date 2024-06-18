<?php
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
if (isset($_POST['kusername'])) {
$kusername = $_POST['kusername'];
$kpassword = $_POST['kpassword'];
$result = $conn->query("SELECT * FROM kusers WHERE kusername='$kusername' AND kpassword='$kpassword'") or die($conn->error());
$row = $result->fetch_assoc();
$num_rows = mysqli_num_rows($result);
if ($num_rows>=1){
session_start();
$_SESSION['id'] = $row['ID'];
$_SESSION['kusername'] = $row['fname'];
$_SESSION['kemail'] = $row['kemail'];
header("Location:http://localhost/khma/index.php");
}
else{
	$_SESSION['message'] = "خطأ في اسم المستخدم او كلمة المرور";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/login.php");
}
}
?>