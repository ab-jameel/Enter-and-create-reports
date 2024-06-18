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
	.form-control{
		height: 30px;
	}

	.sm1{
		width: 50%;
		float: right;
	}
</style>
	<title>المصروفات التشغيلية</title>
<?php 
require_once 'php/expensesr_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 16") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];

if (isset($_GET['edit'])){
$expensesr = $edit;
}

if ($money == 1 and $expensesr == 1){
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
if (isset($_SESSION['message'])):
?>
<div class="alert alert-<?=$_SESSION['msg_type']?>">
	<?php 
echo $_SESSION['message'];
unset($_SESSION['message']);
if ($_SESSION['msg_type'] == "success"){
	?>
<i class="fas fa-check i2"></i>
<?php } endif;
	$result10 = $conn->query("SELECT * FROM expensesr ORDER BY ID DESC") or die($conn->error());
	$num10 = mysqli_num_rows($result10);
	if ($num10 > 0){
		$row10 = $result10->fetch_assoc();
		$the_year = $row10['r_year'];
		$the_month = $row10['r_month'];
		if ($the_month == 12){
			$the_year = $the_year+1;
			$the_month = 1;
		}else{
			$the_month = $the_month+1;
		}
	}else{
		$the_month = 1;
		$the_year = date('Y');
	}
?>
</div>
<br>
<div class="container">
<div class="row justify-content-center">
	<form action="php/expensesr_proccess.php" method="POST">
		<?php if (isset($_GET['edit'])) {
		}else{ ?>
		<div class="col col-sm-6">
		<div class="form-group">
			<label>: الشهر</label>
			<input type="hidden" name="r_month" value="<?php echo $the_month ?>">
		<select class="form-control" style="height: 30px;" disabled>
			<?php
			 $r1 = $conn->query("SELECT * FROM months WHERE ID=".$the_month) or die($conn->error());
			 while ($m1 = $r1->fetch_assoc()) { ?>
			<option value="<?php echo $m1['ID']; ?>"><?php echo $m1['m_name']; ?></option>
			<?php } ?>
		</select>
		</div>
	</div>
			<div class="col col-sm-6">
		<div class="form-group">
			<label>: العام </label>
			<input type="hidden" name="r_year" value="<?php echo $the_year ?>">
			<input autocomplete="off" type="text" class="form-control right1" style="height: 30px;" value="<?php echo $the_year ?>" disabled>
		</div>
		</div>
	</div>
	<div class="row justify-content-center">
	<?php } ?>
	<?php
	if (isset($_GET['edit'])){
	$id=$_GET['edit'];
	$id2=$_GET['edit2'];
	$update = true;
	$r = $_GET['r'];
	$result=$conn->query("SELECT * FROM expensesr WHERE r_year='$id' AND r_month='$id2'") or die($conn->error());
	$result3 = $conn->query("SELECT * FROM months WHERE ID=$id2") or die($conn->error());
	$row3 = $result3->fetch_assoc();
	if (empty($result)){
	}else{ ?>
	<input type="hidden" name="r1" value="<?php echo $r; ?>">
	<div class="col col-sm-6">
	<div class="form-group">
	<label>: الشهر</label>
	<select class="form-control" style="height: 30px;" disabled>
		<option value="<?php echo $row3['ID']; ?>"><?php echo $row3['m_name']; ?></option>
	</select>
	</div>
	</div>
<div class="col col-sm-6">
<div class="form-group">
	<label>: العام </label>
	<input name="year2" value="<?php echo $id; ?>" class="form-control right1" style="width: 100px;height: 30px;" disabled>
	</div>
</div>
</div>

<div class="row justify-content-center">
	<table class="table">
		<thead class="thead1">
			<tr>
				<th></th>
				<th class="right1">القيمة</th>
				<th class="right1">البند</th>
			</tr>
		</thead>
		<?php while ($row = $result->fetch_assoc()){
				$result1 = $conn->query("SELECT * FROM ritems WHERE ID=".$row['r_item']) or die($conn->error());
				$row1 = $result1->fetch_assoc(); ?>
			<tr class="me">
				<td><input type="hidden" name="id1[]" value="<?php echo $row['ID']; ?>"></td>
				<td><input type="" name="r_amount1[]" class="form-control sm1 cen2" value="<?php echo $row['r_amount'] ?>" autocomplete="off" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57"></td>
				<td class="right1"><?php echo $row1['i_name']; ?></td>
			</tr>
	<?php } ?>
	</table>
	<?php } ?>
<?php
}else{
	$result = $conn->query("SELECT * FROM ritems") or die($conn->error());
	?>
	<table class="table">
		<thead class="thead1">
			<tr>
				<th class="right1">القيمة</th>
				<th class="right1">البند</th>
			</tr>
		</thead>
		<?php while ($row = $result->fetch_assoc()): ?>
			<tr class="me">
				<td><input type="" name="r_amount[]" class="form-control sm1 cen2" autocomplete="off" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57"></td>
				<td class="right1"><input type="hidden" name="r_item[]" value="<?php echo $row['ID']; ?>"><?php echo $row['i_name']; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
<?php } ?>
</div>
		<div class="col col-sm-3">
		<div class="form-group">
			<br>
			<?php 
			if ($update == true):
			?>
			<button type="submit" class="save" name="update">تحديث  <i class="fas fa-sync-alt save1"></i></button>
			<?php if ($r == 1){ ?>
			<a href="reports.php" class="cancel">الغاء<i class="fas fa-times cancel1"></i></a>
			<?php }else{ ?>
			<a href="frok.php" class="cancel">الغاء<i class="fas fa-times cancel1"></i></a>
			<?php } ?>
			<?php else: ?>
				<button type="submit" class="save" name="save">حفظ <i class="fas fa-save save1"></i></button>
				<a href="finance.php" class="cancel">الغاء<i class="fas fa-times cancel1"></i></a>
			<?php endif; ?>
</div>
</div>


	</form>
<?php 
	function pre_r($array){
		echo '<pre>';
		print_r($array);
		echo'</pre>';
	}
?>
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