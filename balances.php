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
	<title>الارصدة الافتتاحية</title>
<?php 
require_once 'php/balances_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 28") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];
$delete = $row1['p_delete'];


if (isset($_GET['edit'])){
$balances = $edit;
$id = $_GET['edit'];
}

if ($manage == 1 and $balances == 1){
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
$result = $conn->query("SELECT b_year FROM balances ORDER BY b_year DESC") or die($conn->error());
$num = mysqli_num_rows($result);
if ($num > 0){
$row = $result->fetch_assoc();
$last = $row['b_year'];
	$result = $conn->query("SELECT * FROM balances WHERE b_year = ".$last) or die($conn->error());
}else{
	$result = $conn->query("SELECT * FROM balances") or die($conn->error());
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

<form action="php/balances_proccess.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div class="line">
		<div class="form-group">
			<br>
			<?php 
			if ($update == true):
			?>
			<button tabindex="6" type="submit" class="save" name="update">تحديث  <i class="fas fa-sync-alt save1"></i></button>
			<?php else: ?>
			<button tabindex="5" type="submit" class="save" name="save">حفظ <i class="fas fa-save save1"></i></button>
			<?php endif; ?>
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: رابط المرفقات</label>
			<input tabindex="4" type="text" class="form-control right1" style="height: 30px; width: 450px;" value="<?php echo $b_url ?>" name="b_url" autocomplete="off">
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: الرصيد الافتتاحي</label>
			<input tabindex="3" type="text" class="form-control right1" style="height: 30px; width: 150px;" value="<?php echo $b_amount ?>" name="b_amount" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57 || event.charCode==45" autocomplete="off">
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: العملة</label>
			<select tabindex="2" name="b_currency" class="form-control" style="height: 30px; width: 100px;">
				<option <?php if ($update == true){if ($b_currency == 'دولار'){echo 'selected';}} ?>>دولار</option>
				<option <?php if ($update == true){if ($b_currency == 'شلن'){echo 'selected';}} ?>>شلن</option>
			</select>
		</div>
		</div>		

		<div class="line margin1">
		<div class="form-group">
			<label>: العام</label>
			<input tabindex="1" type="text" name="b_year" class="form-control right1" style="height: 30px;width: 150px;" value="<?php echo $b_year ?>"ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off">
		</div>
		</div>

	</div>
</form>

<div class="row justify-content-center">
<table class="table">
	<thead class="thead1">
		<tr>
			<th class="right1">اجراءات</th>
			<th class="right1">مرفقات</th>
			<th class="right1">الرصيد الافتتاحي</th>
			<th class="right1">العملة</th>
			<th class="right1">العام</th>
		</tr>
	</thead>
	<?php while ($row = $result->fetch_assoc()){ ?>
	<tr class="me">
		<td class="right1">
			<?php if ($edit == 1){ ?>
			<a href="balances.php?edit=<?php echo $row['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
			<?php } ?>
		</td>
		<td class="right1"><a href="<?php echo $row['b_url']?>" target="_blank"><?php echo $row['b_url']?></a></td>
		<td class="right1"><?php echo $row['b_amount']?></td>
		<td class="right1"><?php echo $row['b_currency']?></td>
		<td class="right1"><?php echo $row['b_year']?></td>
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