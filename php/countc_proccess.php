<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$c_markaz = '';
$c_learn = '';
$c_learnl = '';
$c_dev = '';
$c_devl = '';
$c_student = '';
$update = false;

if (isset($_POST['save'])){
$count = count($_POST['c_markaz']);
	for ($i=0; $i < $count; $i++) {

	$query = $conn->query("INSERT INTO countc (c_markaz, c_month, c_year, c_learn, c_learnl, c_dev, c_devl, c_student) VALUES('{$_POST['c_markaz'][$i]}','{$_POST['c_month']}','{$_POST['c_year']}','{$_POST['c_learn'][$i]}','{$_POST['c_learnl'][$i]}','{$_POST['c_dev'][$i]}','{$_POST['c_devl'][$i]}','{$_POST['c_student'][$i]}')") or die($conn->error());
}
	if ($query){
	$_SESSION['message'] = "تم حفظ البيانات بنجاح";
	$_SESSION['msg_type'] = "success";
	}else{
	$_SESSION['message'] = "لا يمكن حفظ البيانات";
	$_SESSION['msg_type'] = "danger";
	}
	header("Location:http://localhost/khma/countc.php");
}

if (isset($_POST['update'])){
$count = count($_POST['id1']);
	for ($i=0; $i < $count; $i++) { 
	
	$conn->query("UPDATE countc SET c_learn='{$_POST['c_learn1'][$i]}', c_learnl='{$_POST['c_learnl1'][$i]}', c_dev='{$_POST['c_dev1'][$i]}', c_devl='{$_POST['c_devl1'][$i]}', c_student='{$_POST['c_student1'][$i]}' WHERE ID='{$_POST['id1'][$i]}'") or die($conn->error());
}
	$_SESSION['message'] = "تم تحديث التقرير بنجاح";
	$_SESSION['msg_type'] = "success";
	header('Location:http://localhost/khma/countc.php');
}
?>