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


	<style type="text/css">
	.save{
		margin-right: 10px;
		margin-top: -30px;
	}
	</style>
	<title>صرف العملة</title>
<?php 
require_once 'php/cash_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 17") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];
$delete = $row1['p_delete'];


if (isset($_GET['edit'])){
$cash = $edit;
$id = $_GET['edit'];
}

if ($money == 1 and $cash == 1){
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
	      <li class="nav-item">
	        <a class="nav-link" href="manage.php">الادارة العامة</a>
	      </li>
	  	  <?php } ?>
	      <?php if ($money == 1){ ?>
	      <li class="nav-item active">
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
$result = $conn->query("SELECT YEAR(c_date) AS year FROM cash ORDER BY c_date DESC") or die($conn->error());
$num = mysqli_num_rows($result);
if ($num > 0){
$row = $result->fetch_assoc();
$last = $row['year'];
$last2 = $last-1;
	$result = $conn->query("SELECT * FROM cash WHERE YEAR(c_date) = ".$last) or die($conn->error());
}else{
	$result = $conn->query("SELECT * FROM cash") or die($conn->error());
}
?>
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

<form action="php/cash_proccess.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="line">
		<div class="form-group">
			<br>
			<?php 
			if ($update == true):
			?>
			<button tabindex="7" type="submit" class="save" name="update">تحديث  <i class="fas fa-sync-alt save1"></i></button>
			<?php else: ?>
			<button tabindex="6" type="submit" class="save" name="save">حفظ <i class="fas fa-save save1"></i></button>
			<?php endif; ?>
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: رقم الفاتورة</label>
			<input tabindex="5" type="text" class="form-control right1" style="height: 30px; width: 150px;" value="<?php echo $c_number ?>" name="c_number" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off">
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: سعر الصرف</label>
			<input tabindex="4" type="text" class="form-control right1" style="height: 30px; width: 150px;" value="<?php echo $c_exchange ?>" name="c_exchange" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off">
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: القيمة بالدولار </label>
			<input tabindex="3" type="text" class="form-control right1" style="height: 30px; width: 150px;" value="<?php echo $c_dollar ?>" name="c_dollar" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off">
		</div>
		</div>
		
		<div class="line margin1">
		<div class="form-group">
			<label>: الشخص المسؤول</label>
			<input tabindex="2" autocomplete="off" type="text" name="c_admin" class="form-control right1" style="height: 30px;" value="<?php echo $c_admin ?>">
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: التاريخ </label>
			<input tabindex="1" type="date" min="<?php echo $last2 ?>-01-01" class="form-control right1" style="height: 30px;width: 155px;" value="<?php echo $c_date ?>" name="c_date">
		</div>
		</div>

	</div>
</form>

<div class="row justify-content-center">
<table class="table">
	<thead class="thead1">
		<tr>
			<th class="right1">اجراءات</th>
			<th class="right1">رقم الفاتورة</th>
			<th class="right1">القيمة بالشلن</th>
			<th class="right1">سعر الصرف</th>
			<th class="right1">القيمة بالدولار </th>
			<th class="right1">الشخص المسؤول</th>
			<th class="right1">التاريخ</th>
		</tr>
	</thead>
	<?php while ($row = $result->fetch_assoc()){ ?>
	<tr class="me">
		<td class="right1">
			<?php if ($delete == 1){ ?>
			<a href="php/cash_proccess.php?delete=<?php echo $row['ID']; ?>"><i class="fas fa-trash-alt i1"></i></a>
			<?php } ?>
			<?php if ($edit == 1){ ?>
			<a href="cash.php?edit=<?php echo $row['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
			<?php } ?>
		</td>
		<td class="right1"><?php echo $row['c_number']?></td>
		<td class="right1"><?php $shil = $row['c_exchange'] * $row['c_dollar'];
								echo number_format($shil);?></td>
		<td class="right1"><?php echo number_format($row['c_exchange'])?></td>
		<td class="right1"><?php echo number_format($row['c_dollar'])?></td>
		<td class="right1"><?php echo $row['c_admin']?></td>
		<td class="right1"><?php echo $row['c_date']?></td>
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