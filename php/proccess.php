<?php  
session_start();
$conn=new mysqli('localhost' ,'root' ,'' ,'maktab' ) or die(mysql_error($conn));
$conn->set_charset('utf8');
$id = 0;
$kusername = '';
$fname = '';
$kpassword = '';
$kemail = '';
$update = false;

if (isset($_POST['save'])){
	$kusername = $_POST['kusername'];
	$fname = $_POST['fname'];
	$kpassword = $_POST['kpassword'];
	$kemail = $_POST['kemail'];
	$kusername = ltrim($kusername);
	$fname = ltrim($fname);
	$kpassword = ltrim($kpassword);
	$kemail = ltrim($kemail);



	if ($kusername !== '' and $kpassword !== '' and $kemail !== '' and $fname !== ''){
	$query = $conn->query("INSERT INTO kusers (kusername, kpassword, kemail, fname) VALUES('$kusername','$kpassword','$kemail','$fname')") or die($conn->error());

	if ($query){
	$res1 = $conn->query("SELECT * FROM kusers ORDER BY ID DESC") or die($conn->error());
	$ro1 = $res1->fetch_assoc();
	$user_id = $ro1['ID'];
	$c = count($_POST['id']);
	for ($i=0; $i < $c; $i++) {

			$show = $_POST['show'][$i];
			$edit = $_POST['edit'][$i];
			$delete = $_POST['delete1'][$i];
			$pdf = $_POST['pdf'][$i];


	$conn->query("INSERT INTO premissions (p_user, p_manage, p_page, p_show, p_edit, p_delete, p_pdf) VALUES ($user_id,{$_POST['manage'][$i]},{$_POST['id'][$i]},$show,$edit,$delete,$pdf)") or die($conn->error());
	}
	$_SESSION['message'] = "تم اضافة المستخدم بنجاح";
	$_SESSION['msg_type'] = "success";
	}else{
	$_SESSION['message'] = "لا يمكن حفظ البيانات";
	$_SESSION['msg_type'] = "danger";
	}
	header("Location:http://localhost/khma/users.php");
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/control_users.php");
}
}

if (isset($_GET['delete'])){
	$id=$_GET['delete'];
	$conn->query("DELETE FROM kusers WHERE id=$id") or die($conn->error());
	$conn->query("DELETE FROM premissions WHERE p_user=$id") or die($conn->error());
	$_SESSION['message'] = "تم حذف المستخدم بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/users.php");
}

if (isset($_POST['update'])){
	$id2 = $_POST['id2'];
	$kusername = $_POST['kusername'];
	$fname = $_POST['fname'];
	$kpassword = $_POST['kpassword'];
	$kemail = $_POST['kemail'];
	$kusername = ltrim($kusername);
	$fname = ltrim($fname);
	$kpassword = ltrim($kpassword);
	$kemail = ltrim($kemail);

	if ($kusername !== '' and $kpassword !== '' and $kemail !== '' and $fname !== ''){
	$query = $conn->query("UPDATE kusers SET kusername='$kusername', kpassword='$kpassword', kemail='$kemail', fname='$fname' WHERE ID=$id2") or die($conn->error());

	if ($query){
	$c = count($_POST['id']);
	for ($i=0; $i < $c; $i++) {

			$id = $_POST['id'][$i];
			$show = $_POST['show'][$i];
			$edit = $_POST['edit'][$i];
			$delete = $_POST['delete1'][$i];
			$pdf = $_POST['pdf'][$i];


	$conn->query("UPDATE premissions SET p_show='$show', p_edit='$edit', p_delete='$delete', p_pdf='$pdf' WHERE ID=$id") or die($conn->error());
	}
	$_SESSION['message'] = "تم تحديث المستخدم بنجاح";
	$_SESSION['msg_type'] = "success";
	header("Location:http://localhost/khma/users.php");
	}else{
	$_SESSION['message'] = "لا يمكن حفظ البيانات";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/control_users.php?edit=$id2");
	}
}else{
	$_SESSION['message'] = "الرجاء تعبئة الحقول الفارغة";
	$_SESSION['msg_type'] = "danger";
	header("Location:http://localhost/khma/control_users.php?edit=$id2");
}
}
?>