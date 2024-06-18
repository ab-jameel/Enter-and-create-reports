<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="css/key.css">
	<script src="js/jquery-3.4.1.slim.js"></script>
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/logout.js"></script>
	<script src="https://kit.fontawesome.com/9acd051564.js" crossorigin="anonymous"></script>
	<link rel="icon" type="image/png" href="images/new.bmp"/>
	
	<script type="text/javascript">
		function save() {
			var name=document.getElementById('name').value;
			var dataString='name='+name;
			$.ajax({
				type:"post",
				url:"php/save.php",
				data:dataString,
				cache:false,
				success:function(html){
				$('#select1').load('php/refresh.php');
				document.getElementById('name').value = '';
				$('#mymodel10').modal('hide');
				document.getElementById('success').innerHTML = html;
				}
			});
			return false;
		};

		function save2() {
			var name=document.getElementById('name2').value;
			var dataString='name2='+name;
			$.ajax({
				type:"post",
				url:"php/save.php",
				data:dataString,
				cache:false,
				success:function(html){
				$('#select2').load('php/refresh2.php');
				document.getElementById('name2').value = '';
				$('#mymodel20').modal('hide');
				document.getElementById('success').innerHTML = html;
				}
			});
			return false;
		};
		
		function save3() {
			var name=document.getElementById('name3').value;
			var dataString='name3='+name;
			$.ajax({
				type:"post",
				url:"php/save.php",
				data:dataString,
				cache:false,
				success:function(html){
				$('#select3').load('php/refresh3.php');
				document.getElementById('name3').value = '';
				$('#mymodel30').modal('hide');
				document.getElementById('success').innerHTML = html;
				}
			});
			return false;
		};

		function reload() {
			var c_year=document.getElementById('c_year').value;
			var dataString='c_year='+c_year;
			$.ajax({
				type:"post",
				url:"php/save.php",
				data:dataString,
				cache:false,
				success:function(html){
				document.getElementById('select4').innerHTML = html;
				}
			});
			return false;
		};
	</script>

	<title>الموازنات</title>

	<style type="text/css">
	*{
		font-family: arial;
	}

	.i1{
		margin-left: 10px;
	}

	.i1:hover{
		cursor: pointer;
	}

	.table{
		margin-top: 20px;
	}

	select{
		border-radius: 0.25em;
		text-align: right;
		width: 100px;
		height: 35px;
	}

	input{
		border-radius: 0.25em;
		border: 2px groove;
	}
	</style>

<?php 
require_once 'php/comparison_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 27") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];
$delete = $row1['p_delete'];


if (isset($_GET['edit'])){
$comparison = $edit;
$id = $_GET['edit'];
}

if ($manage == 1 and $comparison == 1){
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
	      	<button class="saveout" onclick="logout();" style="margin-top: 2px;">تسجيل الخروج <i class="fas fa-sign-out-alt"></i></button>
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
<div id="success"></div>
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

<div class="container">
<div class="row justify-content-center">

<form action="php/comparison_proccess.php" method="POST">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<div class="line btns">
<?php 
if ($update == true):
?>
<button type="submit" class="save" tabindex="8" name="update">تحديث  <i class="fas fa-sync-alt save1"></i></button>
<?php else: ?>
<button type="submit" class="save" tabindex="7" name="save">حفظ <i class="fas fa-save save1"></i></button>
<?php endif; ?>
</div>

<div class="line">
<fieldset>
<legend style="width: 50px;font-size: 20px;">المركز</legend>
<select id="select4" name="c_markaz" style="margin-left: 10px;width: 125px;" tabindex="6">
<?php 
$result = $conn->query("SELECT * FROM marakez WHERE myear='$c_year'") or die($conn->error()); ?>
	<option <?php if ($update == true){
		if ($c_markaz == 0){
			echo "selected";
		}
	} ?>></option>
<?php while ($row = $result->fetch_assoc()) { ?>
	<option value="<?php echo $row['ID'] ?>" <?php if ($update == true){
		if ($c_markaz != 0){
		if ($row['ID'] == $c_markaz){
			echo "selected";
		}}
	} ?>><?php echo $row['mname']; ?></option>
<?php } ?>
 ?>
</select>
</fieldset>
</div>

<div class="line">
<fieldset>
<legend style="width: 40px;font-size: 20px;">المبلغ</legend>
<input name="c_amount" tabindex="5" class="right1" style="height: 35px;margin-left: 10px;padding-right: 2px;width: 125px;" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off" value="<?php echo $c_amount ?>">
</fieldset>
</div>

<div class="line">
<fieldset>
<legend style="width: 90px;font-size: 20px;">نوع الموازنة</legend>
<i data-toggle="modal" data-target="#mymodel30" class="fas fa-plus i1"></i>
<select id="select3" name="c_type" tabindex="4">
<?php 
$result = $conn->query("SELECT * FROM ctype") or die($conn->error());
while ($row = $result->fetch_assoc()) {?>
	<option <?php if ($update == true){
		if ($row['t_name'] == $c_type){
			echo "selected";
		}
	} ?>><?php echo $row['t_name']; ?></option>
<?php } ?>
</select>
</fieldset>
</div>

<div class="line">
<fieldset>
<legend style="width: 50px;font-size: 20px;">المحور</legend>
<i data-toggle="modal" data-target="#mymodel20" class="fas fa-plus i1"></i>
<select id="select2" name="c_axis" tabindex="3">
<?php 
$result = $conn->query("SELECT * FROM axis") or die($conn->error());
while ($row = $result->fetch_assoc()) { ?>
	<option <?php if ($update == true){
		if ($row['a_name'] == $c_axis){
			echo "selected";
		}
	} ?>><?php echo $row['a_name']; ?></option>
<?php } ?>
?>
</select>
</fieldset>
</div>

<div class="line">
<fieldset>
<legend style="width: 60px;font-size: 20px;">البرنامج</legend>
<i data-toggle="modal" data-target="#mymodel10" class="fas fa-plus i1"></i>
<select id="select1" name="c_program" tabindex="2">
<?php 
$result = $conn->query("SELECT * FROM programs") or die($conn->error());
while ($row = $result->fetch_assoc()) { ?>
	<option <?php if ($update == true){
		if ($row['p_name'] == $c_program){
			echo "selected";
		}
	} ?>><?php echo $row['p_name']; ?></option>
<?php } ?>
?>
</select>
</fieldset>
</div>

<div class="line">
<fieldset>
<legend style="width: 35px;font-size: 20px;">العام</legend>
<input class="right1" tabindex="1" name="c_year" style="height: 35px;margin-left: 10px;padding-right: 2px;width: 125px;" value="<?php echo $c_year ?>" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" onkeyup="return reload();" autocomplete="off" name="c_year" id="c_year">
</fieldset>
</div>

</form>

<div id="mymodel10" class="modal fade right1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="justify-content-between">
				<button type="button" class="close" data-dismiss="modal" style="float: left;">&times;</button>
				</div>
				<h3 class="modal-title">اضافة برنامج</h3>
			</div>
			<div class="modal-body">
				<div class="half1 ha1">
				<p class="block1"> :اسم البرنامج</p>
				<input type="text" id="name" class="right1" autocomplete="off">
			</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button class="save" onclick="return save();">حفظ <i class="fas fa-save save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>

<div id="mymodel20" class="modal fade right1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="justify-content-between">
				<button type="button" class="close" data-dismiss="modal" style="float: left;">&times;</button>
				</div>
				<h3 class="modal-title">اضافة محور</h3>
			</div>
			<div class="modal-body">
				<div class="half1 ha1">
				<p class="block1"> :اسم المحور</p>
				<input type="text" id="name2" class="right1" autocomplete="off">
			</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button class="save" onclick="return save2();">حفظ <i class="fas fa-save save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>

<div id="mymodel30" class="modal fade right1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="justify-content-between">
				<button type="button" class="close" data-dismiss="modal" style="float: left;">&times;</button>
				</div>
				<h3 class="modal-title">اضافة نوع</h3>
			</div>
			<div class="modal-body">
				<div class="half1 ha1">
				<p class="block1"> :اسم النوع</p>
				<input type="text" id="name3" class="right1" autocomplete="off">
			</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button class="save" onclick="return save3();">حفظ <i class="fas fa-save save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>

<?php
$result = $conn->query("SELECT * FROM comparison ORDER BY c_year DESC") or die($conn->error());
$num = mysqli_num_rows($result);
$row = $result->fetch_assoc();
if ($num > 0){
	$last = $row['c_year'];
	$result = $conn->query("SELECT * FROM comparison WHERE c_year='$last'") or die($conn->error());
}else{
	$result = $conn->query("SELECT * FROM comparison") or die($conn->error());
}
?>

<table class="table">
	<thead class="thead1">
		<tr>
			<th>اجراءات</th>
			<th class="right1">المركز</th>
			<th class="right1">نوع الموازنة</th>
			<th class="right1">المبلغ</th>
			<th class="right1">المحور</th>
			<th class="right1">البرنامج</th>
			<th class="right1">العام</th>
		</tr>
	</thead>
	<?php while ($row = $result->fetch_assoc()) {
	if ($row['c_markaz'] == 0) {
		$markaz = '';
	}else{
	$result2 = $conn->query("SELECT * FROM marakez WHERE ID=".$row['c_markaz'])  or die($conn->error());
	$row2 = $result2->fetch_assoc();
	$markaz = $row2['mname'];
	}
	?>
	<tr class="me">
		<td>
			<?php if ($delete == 1){ ?>
			<a href="php/comparison_proccess.php?delete=<?php echo $row['ID']; ?>"><i class="fas fa-trash-alt i1"></i></a>
			<?php } ?>
			<?php if ($edit == 1){ ?>
			<a href="comparison.php?edit=<?php echo $row['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
			<?php } ?>
		</td>
		<td class="right1"><?php echo $markaz ?></td>
		<td class="right1"><?php echo $row['c_type'] ?></td>
		<td class="right1"><?php echo number_format($row['c_amount']) ?></td>
		<td class="right1"><?php echo $row['c_axis'] ?></td>
		<td class="right1"><?php echo $row['c_program'] ?></td>
		<td class="right1"><?php echo $row['c_year'] ?></td>
	</tr>
<?php } ?>
</table>


</div>
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