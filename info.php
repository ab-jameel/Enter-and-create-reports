<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="css/key.css">
	<script src="js/jquery-3.4.1.slim.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/logout.js"></script>
	<script src="https://kit.fontawesome.com/9acd051564.js" crossorigin="anonymous"></script>
	<link rel="icon" type="image/png" href="images/new.bmp"/>

	<title>بيانات الموازنات</title>

	<style type="text/css">
	*{
		font-family: arial;
	}

	.save{
		float: left;
	}
	</style>

<?php
require_once 'php/info_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 30") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];
$delete = $row1['p_delete'];


if (isset($_GET['edit']) or isset($_GET['edit2']) or isset($_GET['edit3'])){
$info = $edit;
}

if (isset($_GET['edit'])){
	$id=$_GET['edit'];
}

if (isset($_GET['edit2'])){
	$id=$_GET['edit2'];
}

if (isset($_GET['edit3'])){
	$id=$_GET['edit3'];
}

if ($manage == 1 and $info == 1){
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
	      	<button class="saveout" onclick="logout();" style="margin-top: 7.5px; margin-top: 0;">تسجيل الخروج <i class="fas fa-sign-out-alt"></i></button>
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
<?php } endif; ?>
</div>
<br>
<div class="container">
<div class="row justify-content-center">

<div class="col">
<table class="table">
	<thead class="thead1">
		<tr>
			<th></th>
			<th class="right1">النوع</th>
		</tr>
	</thead>
	<?php 
	$result2 = $conn->query("SELECT * FROM ctype") or die($conn->error());
	while ($row2 = $result2->fetch_assoc()){
	?>
	<tr class="me">
		<td>
		<?php if ($edit == 1){ ?>
			<a href="info.php?edit3=<?php echo $row2['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
		<?php } ?>
		</td>
		<td class="right1"><?php echo $row2['t_name']; ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2">
			<button data-toggle="modal" data-target="#mymodel30" class="bt1 save">اضافة نوع<i class="fas fa-plus save1"></i></button>
		</td>
	</tr>
</table>
</div>

<div class="col">
<table class="table">
	<thead class="thead1">
		<tr>
			<th></th>
			<th class="right1">المحور</th>
		</tr>
	</thead>
	<?php 
	$result1 = $conn->query("SELECT * FROM axis") or die($conn->error());
	while ($row1 = $result1->fetch_assoc()){
	?>
	<tr class="me">
		<td>
		<?php if ($edit == 1){ ?>
			<a href="info.php?edit2=<?php echo $row1['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
		<?php } ?>
		</td>
		<td class="right1"><?php echo $row1['a_name']; ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2">
			<button data-toggle="modal" data-target="#mymodel20" class="bt1 save">اضافة محور<i class="fas fa-plus save1"></i></button>
		</td>
	</tr>
</table>
</div>

<div class="col">
<table class="table">
	<thead class="thead1">
		<tr>
			<th></th>
			<th class="right1">البرنامج</th>
		</tr>
	</thead>
	<?php 
	$result = $conn->query("SELECT * FROM programs") or die($conn->error());
	while ($row = $result->fetch_assoc()){
	?>
	<tr class="me">
		<td>
		<?php if ($edit == 1){ ?>
			<a href="info.php?edit=<?php echo $row['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
		<?php } ?>
		</td>
		<td class="right1"><?php echo $row['p_name']; ?></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2">
			<button data-toggle="modal" data-target="#mymodel10" class="bt1 save">اضافة برنامح<i class="fas fa-plus save1"></i></button>
		</td>
	</tr>
</table>
</div>
</div>
</div>

<form action="php/info_proccess.php" method="POST">
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
				<input type="text" name="name" class="right1" autocomplete="off">
			</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="submit" class="save" name="save">حفظ <i class="fas fa-save save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>
</form>

<form action="php/info_proccess.php" method="POST">
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
				<input type="text" name="name" class="right1" autocomplete="off">
			</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="submit" class="save" name="save2">حفظ <i class="fas fa-save save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>
</form>

<form action="php/info_proccess.php" method="POST">
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
				<input type="text" name="name" class="right1" autocomplete="off">
			</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="submit" class="save" name="save3">حفظ <i class="fas fa-save save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>
</form>

<form action="php/info_proccess.php" method="POST">
<div id="mymodel1" class="modal fade right1" role="dialog" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="justify-content-start">
				<a href="info.php" class="a1">&times;</a>
				</div>
				<div class="justify-content-end">
				<h3 class="modal-title">تعديل البيانات</h3>
				</div>
			</div>
			<input type="hidden" name="selected" value="<?php if (isset($_GET['edit'])){
			echo 1;
		} elseif (isset($_GET['edit2'])){
		echo 2;
	} elseif (isset($_GET['edit3'])){
	echo 3;
}; ?>">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<div class="modal-body">
			<div class="half1 ha1">
			<?php if (isset($_GET['edit'])){?>
				<p class="block1"> :اسم البرنامج</p>
				<?php } elseif (isset($_GET['edit2'])){?>
				<p class="block1"> :اسم المحور</p>
				<?php } elseif (isset($_GET['edit3'])){?>
				<p class="block1"> :اسم النوع</p>
			<?php }; ?>
				<input type="text" name="name1" class="right1" value="<?php echo $name; ?>" autocomplete="off">
				<br>
			</div>
			</div>
			<div class="modal-footer justify-content-between">
			<button type="submit" class="save" name="update">تحديث  <i class="fas fa-sync-alt save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>
</form>

<script type="text/javascript">
	if (window.location.href.indexOf("edit") > 0) {
	$('#mymodel1').modal('show');
}
</script>


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