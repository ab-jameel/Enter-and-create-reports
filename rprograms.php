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
		width: 165px;
	}
</style>
	<title>تقرير البرامج الدعوية</title>
<?php 
require_once 'php/rprograms_proccess.php';
if (isset($_SESSION['id'])){
require_once'connect.php';
require_once'php/premissions.php';
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 10") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];


if (isset($_GET['edit'])){
$rprograms = $edit;
}

if ($call == 1 and $rprograms == 1){
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
	      <li class="nav-item active">
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
	$result10 = $conn->query("SELECT * FROM rprograms ORDER BY ID DESC") or die($conn->error());
	$num10 = mysqli_num_rows($result10);
	if ($num10 > 0){
		$row10 = $result10->fetch_assoc();
		$the_year = $row10['b_year'];
		$the_month = $row10['b_month'];
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
	<form action="php/rprograms_proccess.php" method="POST">
		<?php if (isset($_GET['edit'])) {
		}else{ ?>
		<div class="col col-sm-6">
		<div class="form-group">
			<label>: الشهر</label>
			<input type="hidden" name="b_month" value="<?php echo $the_month ?>">
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
			<input type="hidden" name="b_year" value="<?php echo $the_year ?>">
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
	$result=$conn->query("SELECT * FROM rprograms WHERE b_year='$id' AND b_month='$id2'") or die($conn->error());
	$result3 = $conn->query("SELECT * FROM months WHERE ID=$id2") or die($conn->error());
	$row3 = $result3->fetch_assoc();
	if (empty($result)){
	}else{ ?>
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
	<input name="year2" value="<?php echo $id; ?>" class="form-control right1" style="width: 100px;height: 30px;" disabled>
	</div>
</div>
</div>

<div class="row justify-content-center">
	<table class="table">
		<thead class="thead1">
			<tr>
				<th></th>
				<th class="cen2">عدد البرامج الاذاعية</th>
				<th class="cen2">عدد الخطب</th>
				<th class="cen2">عدد المهتدين</th>
				<th class="cen2">عدد الحضور التقريبي</th>
				<th class="cen2">عدد المناظرات</th>
				<th class="cen2">مكان المناظرة</th>
				<th class="right1">اسم الفرقة</th>
			</tr>
		</thead>
		<?php 
		$t = 1;
		while ($row = $result->fetch_assoc()){
				$result1 = $conn->query("SELECT * FROM groups WHERE ID=".$row['b_group']) or die($conn->error());
				$row1 = $result1->fetch_assoc(); ?>
			<tr class="me">
				<?php $x = $t * 6;?>
				<td><input type="hidden" name="b_markaz1[]" value="<?php echo $row1['markaz_name']; ?>"><input type="hidden" name="id1[]" value="<?php echo $row['ID']; ?>"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_countt1[]" class="form-control cen2" value="<?php echo $row['b_countt'] ?>" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_countk1[]" value="<?php echo $row['b_countk'] ?>" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_countm1[]" class="form-control cen2" value="<?php echo $row['b_countm'] ?>" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_attend1[]" value="<?php echo $row['b_attend'] ?>" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_countr1[]" value="<?php echo $row['b_countr'] ?>" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_place1[]" class="form-control cen2" value="<?php echo $row['b_place'] ?>" autocomplete="off"></td>
				<td class="right1"><input type="hidden" name="b_group1[]" value="<?php echo $row1['ID']; ?>"><?php echo $row1['group_name']; ?></td>
				<?php $t++; ?>
			</tr>
	<?php } ?>
	</table>
	<?php } ?>
<?php
}else{
	$result = $conn->query("SELECT * FROM groups WHERE the_year='".$the_year."' ORDER BY markaz_name ASC") or die($conn->error());
	?>
	<table class="table">
		<thead class="thead1">
			<tr>
				<th></th>
				<th class="cen2">عدد البرامج الاذاعية</th>
				<th class="cen2">عدد الخطب</th>
				<th class="cen2">عدد المهتدين</th>
				<th class="cen2">عدد الحضور التقريبي</th>
				<th class="cen2">عدد المناظرات</th>
				<th class="cen2">مكان المناظرة</th>
				<th class="right1">اسم الفرقة</th>
			</tr>
		</thead>
		<?php 
		$t = 1;
		while ($row = $result->fetch_assoc()): ?>
			<tr class="me">
				<?php $x = $t * 6;?>
				<td><input type="hidden" name="b_markaz[]" value="<?php echo $row['markaz_name']; ?>"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_countt[]" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_countk[]" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_countm[]" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_attend[]" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_countr[]" class="form-control cen2" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off"></td>
				<td class="sm1"><input type="" tabindex="<?php echo $x; $x--?>" name="b_place[]" class="form-control cen2" autocomplete="off"></td>
				<td class="right1"><input type="hidden" name="b_group[]" value="<?php echo $row['ID']; ?>"><?php echo $row['group_name']; ?></td>
				<?php $t++; ?>
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
			<a href="crok.php" class="cancel">الغاء<i class="fas fa-times cancel1"></i></a>
			<?php } ?>
			<?php else: ?>
				<button type="submit" class="save" name="save">حفظ <i class="fas fa-save save1"></i></button>
				<a href="call.php" class="cancel">الغاء<i class="fas fa-times cancel1"></i></a>
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