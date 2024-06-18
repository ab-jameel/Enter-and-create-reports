<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$update = false;
if (isset($_POST['save'])){
$count = count($_POST['b_group']);
		for ($i=0; $i < $count; $i++) {
	$query = $conn->query("INSERT INTO rprograms (b_markaz, b_group, b_month, b_year, b_place, b_countr, b_attend, b_countm, b_countk, b_countt) VALUES('{$_POST['b_markaz'][$i]}','{$_POST['b_group'][$i]}','{$_POST['b_month']}','{$_POST['b_year']}','{$_POST['b_place'][$i]}','{$_POST['b_countr'][$i]}','{$_POST['b_attend'][$i]}','{$_POST['b_countm'][$i]}','{$_POST['b_countk'][$i]}','{$_POST['b_countt'][$i]}')") or die($conn->error());
}
	if ($query) {
	$conn->query("INSERT INTO rok (k_year, k_month, k_type, r_type) VALUES('{$_POST['b_year']}','{$_POST['b_month']}',0,1)") or die($conn->error());
	$_SESSION['message'] = "تم حفظ البيانات بنجاح";
	$_SESSION['msg_type'] = "success";
}else{
	$_SESSION['message'] = "لا يمكن حفظ البيانات";
	$_SESSION['msg_type'] = "danger";
}
	header("Location:http://localhost/khma/rprograms.php");
}

if (isset($_POST['update'])){
$count = count($_POST['b_group1']);
	for ($i=0; $i < $count; $i++) { 

	$conn->query("UPDATE rprograms SET b_markaz='{$_POST['b_markaz1'][$i]}', b_group='{$_POST['b_group1'][$i]}', b_place='{$_POST['b_place1'][$i]}', b_countr='{$_POST['b_countr1'][$i]}', b_attend='{$_POST['b_attend1'][$i]}', b_countm='{$_POST['b_countm1'][$i]}', b_countk='{$_POST['b_countk1'][$i]}', b_countt='{$_POST['b_countt1'][$i]}' WHERE ID='{$_POST['id1'][$i]}'") or die($conn->error());
}
	$_SESSION['message'] = "تم تحديث التقرير بنجاح";
	$_SESSION['msg_type'] = "success";
	if ($_POST['r1']==1){
	header('Location:http://localhost/khma/reports.php');
}else{
	header('Location:http://localhost/khma/rok.php');
}
}
?>