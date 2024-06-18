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
		width: 150px;
	}
</style>
	<title>مسيرات الرواتب</title>
<?php 
require_once 'php/salary_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 2") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];


if (isset($_GET['edit'])){
$salary = $edit;
}

if ($learn == 1 and $salary == 1){
?>

	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
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
	      <li class="nav-item active">
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
<?php } endif;
	$result10 = $conn->query("SELECT * FROM salary ORDER BY ID DESC") or die($conn->error());
	$num10 = mysqli_num_rows($result10);
	if ($num10 > 0){
		$row10 = $result10->fetch_assoc();
		$the_year = $row10['s_year'];
		$the_month = $row10['s_month'];
		if ($the_month == 12){
			$the_year = $the_year+1;
			$the_month = 1;
		}else{
			$the_month = $the_month+1;
		}
	}else{
		$the_month = 1;
		$the_year = date('Y');
	}?>
</div>
<br>
<div class="container1">
<div class="row justify-content-center">
	<form action="php/salary_proccess.php" method="POST">
		<?php if (isset($_GET['edit'])) {
		}else{ ?>
		<div class="col col-sm-6">
		<div class="form-group">
			<label>: الشهر</label>
			<input type="hidden" name="s_month" value="<?php echo $the_month ?>">
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
			<input type="hidden" name="s_year" value="<?php echo $the_year ?>">
			<input type="text" class="form-control right1" style="height: 30px;" value="<?php echo $the_year ?>" disabled>
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
	$result = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM marakez INNER JOIN salary ON marakez.ID = salary.s_markaz WHERE salary.s_year='$id' AND salary.s_month='$id2' ORDER BY ID DESC") or die($conn->error());
	$result3 = $conn->query("SELECT * FROM months WHERE ID=$id2") or die($conn->error());
	$row3 = $result3->fetch_assoc(); ?>
	<input type="hidden" name="r1" value="<?php echo $_GET['r'] ?>">
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
	<input value="<?php echo $id; ?>" class="form-control right1" style="width: 100px;align-self: right; height: 30px;" disabled>
	</div>
</div>
</div>
<div class="row justify-content-center">
	<table class="table cen1">
		<thead>
			<?php
			while ($row = $result->fetch_assoc()) { ?>
			<th colspan="2" class="cen1"><?php echo $row['mname'] ?></th>
			<?php } ?>
			<th></th>
		</thead>
		<thead class="thead1">
			<?php
			$result = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM marakez INNER JOIN salary ON marakez.ID = salary.s_markaz WHERE salary.s_year='$id' AND salary.s_month='$id2' ORDER BY ID DESC") or die($conn->error());
			$num = mysqli_num_rows($result);
			$num1 = $num * 2;
			$t = 1;
			while ($row = $result->fetch_assoc()) { ?>
			<th class="cen2">المستحق الشهري</th>
			<th class="rig1 cen2">العدد</th>
			<?php } ?>
			<th class="right1">البند</th>
		</thead>
		<?php 
			$result=$conn->query("SELECT DISTINCT sitems.ID, sitems.i_name FROM sitems INNER JOIN salary ON sitems.ID = salary.s_item WHERE salary.s_year='$id' AND salary.s_month='$id2'") or die($conn->error());
			while ($row = $result->fetch_assoc()) { ?>
			<tr class="me">
			<?php
			$result2 = $conn->query("SELECT DISTINCT marakez.ID, marakez.mname FROM marakez INNER JOIN salary ON marakez.ID = salary.s_markaz WHERE salary.s_year='$id' AND salary.s_month='$id2' ORDER BY ID DESC") or die($conn->error());
			$x = $t * $num1;
			while ($row2 = $result2->fetch_assoc()) {
			$result3 = $conn->query("SELECT * FROM salary WHERE s_year='$id' AND s_month='$id2' AND s_markaz='".$row2['ID']."' AND s_item='".$row['ID']."'") or die($conn->error());
			$row3 = $result3->fetch_assoc(); ?>
			<td><input type="hidden" name="id1[]" value="<?php echo $row3['ID']; ?>"><input type="" name="s_every1[]" tabindex="<?php echo $x; $x--?>" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off" value="<?php echo $row3['s_every']; ?>" style="width: 100%;padding: 0;"></td>
			<td class="rig1"><input type="" class="form-control cen2" name="s_num1[]" tabindex="<?php echo $x; $x--?>" autocomplete="off" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" value="<?php echo $row3['s_num']; ?>" style="width: 100%;padding: 0;"></td>
			<?php $t++; } ?>
				<td class="right1"><?php echo $row['i_name']; ?></td>
			</tr>
		<?php } ?>
	</table>
	<?php
	}else{
	$result = $conn->query("SELECT * FROM marakez WHERE myear='".$the_year."' ORDER BY ID DESC") or die($conn->error());
	$result2 = $conn->query("SELECT * FROM sitems") or die($conn->error());
	?>
	<table class="table cen1">
		<thead>
			<?php while ($row = $result->fetch_assoc()) { ?>
			<th colspan="2" class="cen1"><?php echo $row['mname'] ?></th>
			<?php } ?>
			<th></th>
		</thead>
		<thead class="thead1">
			<?php
			$result = $conn->query("SELECT * FROM marakez WHERE myear='".$the_year."' ORDER BY ID DESC") or die($conn->error());
			$num = mysqli_num_rows($result);
			$num1 = $num * 2;
			$t = 1;
			while ($row = $result->fetch_assoc()) {
			?>
			<th class="cen2">المستحق الشهري</th>
			<th class="rig1 cen2">العدد</th>
			<?php } ?>
			<th class="right1">البند</th>
		</thead>
		<?php while ($row2 = $result2->fetch_assoc()): ?>
			<tr class="me">
			<?php
			$result = $conn->query("SELECT * FROM marakez WHERE myear='".$the_year."' ORDER BY ID DESC") or die($conn->error());
			$x = $t * $num1;
			while ($row = $result->fetch_assoc()) {
			?>
			<td><input type="hidden" name="s_markaz[]" value="<?php echo $row['ID']; ?>"><input type="" name="s_every[]" tabindex="<?php echo $x; $x--?>" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off" style="width: 100%;padding: 0;"></td>
			<td class="rig1"><input type="" class="form-control cen2" name="s_num[]" tabindex="<?php echo $x; $x--?>" autocomplete="off" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" style="width: 100%;padding: 0;"><input type="hidden" name="s_item[]" value="<?php echo $row2['ID']; ?>"></td>
			<?php $t++; } ?>
				<td class="right1"><?php echo $row2['i_name']; ?></td>
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
			<a href="lrok.php" class="cancel">الغاء<i class="fas fa-times cancel1"></i></a>
			<?php } ?>
			<?php else: ?>
				<button type="submit" class="save" name="save">حفظ <i class="fas fa-save save1"></i></button>
				<a href="learn.php" class="cancel">الغاء<i class="fas fa-times cancel1"></i></a>
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