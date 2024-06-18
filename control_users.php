<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap3.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="css/key.css">
	<script src="js/jquery-3.4.1.slim.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/logout.js"></script>
	<script src="https://kit.fontawesome.com/9acd051564.js" crossorigin="anonymous"></script>
	<link rel="icon" type="image/png" href="images/new.bmp"/>

	<title>اضافة وتعديل المستخدمين</title>

<?php 
require_once 'php/proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id1 = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id1 AND p_page = 34") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];
$delete = $row1['p_delete'];


if (isset($_GET['edit'])){
$users = $edit;
$id = $_GET['edit'];
}

if ($manage == 1 and $users == 1){
?>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div style="order: 3;">
	  <a class="navbar-brand" href="index.php">
	    مؤسسة المدينة للتنمية
	    <img src="images/new.bmp" width="45" height="45" class="d-inline-block align-top" alt="" style="margin-top: -12.5px;">
	  </a>
	</div>
  	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNav">
	    <ul class="navbar-nav">
	      <li class="nav-item">
	      	<button class="saveout" onclick="logout();" style="margin-top: 7.5px;">تسجيل الخروج <i class="fas fa-sign-out-alt"></i></button>
	      </li>
	      <?php if ($manage == 1){ ?>
	      <li class="nav-item active">
	        <a class="nav-link" href="manage.php">الادارة العامة</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($money == 1){ ?>
	      <li class="nav-item">
	        <a class="nav-link" href="finance.php">المالية</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($call == 1){ ?>
	      <li class="nav-item">
	        <a class="nav-link" href="call.php">الدعوة</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($learn == 1){ ?>
	      <li class="nav-item">
	        <a class="nav-link" href="learn.php">التعليم</a>
	      </li>
	  	  <?php } ?>
	  	  <li class="nav-item">
	        <a class="nav-link" href="index.php">الصفحة الرئيسية <span class="sr-only">(current)</span></a>
	      </li>
	    </ul>
	  </div>
	</nav>

</head>
<body class="right1">

<?php
if (isset($_SESSION['message'])):
?>
<div class="alert alert-<?=$_SESSION['msg_type']?>">
	<?php 
echo $_SESSION['message'];
unset($_SESSION['message']);
if ($_SESSION['msg_type'] == "success"){
	?>
<i class="fas fa-check i2"></i>
<?php }else{?>
	<i class="fas fa-exclamation i2"></i>
<?php } endif ?>
</div>
<br>
<?php
if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$update = true;
	$result=$conn->query("SELECT * FROM kusers WHERE ID=$id") or die($conn->error());
	if (empty($result)){}else{
		$row = $result->fetch_array();
		$kusername = $row['kusername'];
		$fname = $row['fname'];
		$kpassword = $row['kpassword'];
		$kemail = $row['kemail'];
	}
}
?>
<div class="container">
	<form action="php/proccess.php" method="POST" id="myform" onsubmit="sub1();">
<div class="row justify-content-center">
		<input type="hidden" name="id2" value="<?php echo $id; ?>">

		<div class="col col-sm-3">
		<div class="form-group">
			<label>: كلمة المرور</label>
			<input autocomplete="off" type="text" name="kpassword" class="form-control right1" value="<?php echo $kpassword ?>" placeholder="ادخل كلمة المرور" tabindex="4">
		</div>
		</div>

		<div class="col col-sm-3">
		<div class="form-group">
			<label>: البريد الالكتروني</label>
			<input autocomplete="off" type="email" name="kemail" maxlength="40" class="form-control" value="<?php echo $kemail ?>" placeholder="ادخل البريد الالكتروني" tabindex="3">
		</div>
		</div>

		<div class="col col-sm-3">
		<div class="form-group">
			<label>: الاسم الكامل</label>
			<input autocomplete="off" type="text" name="fname" maxlength="25" class="form-control right1" value="<?php echo $fname ?>" placeholder="ادخل الاسم الكامل" tabindex="2">
		</div>
		</div>
		
		<div class="col col-sm-3">
		<div class="form-group">
			<label>: اسم المستخدم</label>
			<input autocomplete="off" type="text" name="kusername" class="form-control right1" value="<?php echo $kusername ?>" placeholder="ادخل اسم المستخدم" tabindex="1">
		</div>
		</div>

</div>
	<?php
	$result = $conn->query("SELECT * FROM pages ORDER BY p_manage ASC, ID ASC") or die($conn->error());
	?>
<div class="row justify-content-center">
	<table class="table right1">
		<thead class="thead1">
			<tr>
				<th class="cen2">pdf</th>
				<th class="cen2">حذف</th>
				<th class="cen2">تعديل</th>
				<th class="cen2">اضافة</th>
				<th class="right1">الشاشة</th>
			</tr>
		</thead>
		<?php
		if (isset($_GET['edit'])){
		while ($row = $result->fetch_assoc()):
			$result2 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = ".$row['ID']) or die($conn->error());
			$result3 = $conn->query("SELECT * FROM premissions WHERE p_user = $id1 AND p_page = ".$row['ID']) or die($conn->error());
			$row2 = $result2->fetch_assoc();
			$row3 = $result3->fetch_assoc();
		?>
			<tr class="me" style="border-bottom: 1px solid gray;">
				<td class="cen2" style="border-left: 1px solid gray;">
				<?php if ($row3['p_pdf'] == 1){ ?>
				<input type="checkbox" name="pdf[]" onclick="if(this.value=='1'){this.value='0'}else{this.value='1'}" <?php if ($row2['p_pdf'] == 1){ echo 'value="1"'; echo 'checked'; }else{echo 'value="0"';}?>>
				<?php }else{ ?>
				<input type="checkbox" name="pdf[]" value="0" style="display: none;">
				<?php } ?>
				</td>
				<td class="cen2" style="border-left: 1px solid gray;">
				<?php if ($row3['p_delete'] == 1){ ?>
				<input type="checkbox" name="delete1[]" onclick="if(this.value=='1'){this.value='0'}else{this.value='1'}" <?php if ($row2['p_delete'] == 1){ echo 'value="1"'; echo 'checked'; }else{echo 'value="0"';}?>>
				<?php }else{ ?>
				<input type="checkbox" name="delete1[]" value="0" style="display: none;">
				<?php } ?>
				</td>
				<td class="cen2" style="border-left: 1px solid gray;">
				<?php if ($row3['p_edit'] == 1){ ?>
				<input type="checkbox" name="edit[]" onclick="if(this.value=='1'){this.value='0'}else{this.value='1'}" <?php if ($row2['p_edit'] == 1){ echo 'value="1"'; echo 'checked'; }else{echo 'value="0"';}?>>
				<?php }else{ ?>
				<input type="checkbox" name="edit[]" value="0" style="display: none;">
				<?php } ?>
				</td>
				<td class="cen2" style="border-left: 1px solid gray;">
				<?php if ($row3['p_show'] == 1){ ?>
				<input type="checkbox" name="show[]" onclick="if(this.value=='1'){this.value='0'}else{this.value='1'}" <?php if ($row2['p_show'] == 1){ echo 'value="1"'; echo 'checked'; }else{echo 'value="0"';}?>>
				<?php }else{ ?>
				<input type="checkbox" name="show[]" value="0" style="display: none;">
				<?php } ?>
				</td>

				<td style="border-left: 1px solid gray;"><input type="hidden" name="id[]" value="<?php echo $row2['ID']; ?>"><input type="hidden" name="manage[]" value="<?php echo $row['p_manage']; ?>"><?php echo $row['p_name']; ?></td>
			</tr>
		<?php endwhile;
		}else{
		while ($row = $result->fetch_assoc()):
			$result3 = $conn->query("SELECT * FROM premissions WHERE p_user = $id1 AND p_page = ".$row['ID']) or die($conn->error());
			$row3 = $result3->fetch_assoc();
		?>
			<tr class="me" style="border-bottom: 1px solid gray;">
				<td class="cen2" style="border-left: 1px solid gray;">
				<?php if ($row3['p_pdf'] == 1){ ?>
				<input type="checkbox" name="pdf[]" onclick="if(this.value=='1'){this.value='0'}else{this.value='1'}" value="1" checked>
				<?php }else{ ?>
				<input type="checkbox" name="pdf[]" value="0" style="display: none;">
				<?php } ?>
				</td>
				<td class="cen2" style="border-left: 1px solid gray;">
				<?php if ($row3['p_delete'] == 1){ ?>
				<input type="checkbox" name="delete1[]" onclick="if(this.value=='1'){this.value='0'}else{this.value='1'}" value="1" checked>
				<?php }else{ ?>
				<input type="checkbox" name="delete1[]" value="0" style="display: none;">
				<?php } ?>
				</td>
				<td class="cen2" style="border-left: 1px solid gray;">
				<?php if ($row3['p_edit'] == 1){ ?>
				<input type="checkbox" name="edit[]" onclick="if(this.value=='1'){this.value='0'}else{this.value='1'}" value="1" checked>
				<?php }else{ ?>
				<input type="checkbox" name="edit[]" value="0" style="display: none;">
				<?php } ?>
				</td>
				<td class="cen2" style="border-left: 1px solid gray;">
				<?php if ($row3['p_show'] == 1){ ?>
				<input type="checkbox" name="show[]" onclick="if(this.value=='1'){this.value='0'}else{this.value='1'}" value="1" checked>
				<?php }else{ ?>
				<input type="checkbox" name="show[]" value="0" style="display: none;">
				<?php } ?>
				</td>

				<td style="border-left: 1px solid gray;"><input type="hidden" name="id[]" value="<?php echo $row['ID']; ?>"><input type="hidden" name="manage[]" value="<?php echo $row['p_manage']; ?>"><?php echo $row['p_name']; ?></td>
			</tr>
		<?php endwhile; } ?>
	</table>
</div>


		<div class="col col-sm-3">
		<div class="form-group">
			<br>
			<?php 
			if ($update == true):
			?>
			<button type="submit" class="save" name="update">تحديث  <i class="fas fa-sync-alt save1"></i></button>
			<?php else: ?>
				<button type="submit" class="save" name="save">حفظ <i class="fas fa-save save1"></i></button>
			<?php endif; ?>
				<a href="users.php" class="cancel">الغاء<i class="fas fa-times cancel1"></i></a>
</div>
</div>

<script type="text/javascript">
	function sub1(){

	var pdf = document.forms['myform'].elements[ 'pdf[]' ];
	var delete1 = document.forms['myform'].elements[ 'delete1[]' ];
	var edit = document.forms['myform'].elements[ 'edit[]' ];
	var show = document.forms['myform'].elements[ 'show[]' ];

	for (var i=0, len=pdf.length; i<len; i++) {
		if(pdf[i].checked = true){
			pdf[i].value = pdf[i].value;
		}
		if(delete1[i].checked = true){
			delete1[i].value = delete1[i].value;
		}
		if(edit[i].checked = true){
			edit[i].value = edit[i].value;
		}
		if(show[i].checked = true){
			show[i].value = show[i].value;
		}
	}

	};
</script>

</form>
</div>
</body>
</html>
<?php 
}else{ ?>
<br>
<p style="font-size: 25px; color: red; font-weight: bold; text-align: center;">لاتوجد لديك صلاحية للوصول لهذه الصفحة</p>
<div style="text-align: center;">
<a href="index.php">الصفحة الرئيسية</a>
</div>
<?php }
}else{
	header("Location: login.php");
} ?>