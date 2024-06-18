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
		margin-top: 3px;
	}
</style>
	<title>المراكز</title>

<?php 
require_once 'php/marakez_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 25") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];
$delete = $row1['p_delete'];


if (isset($_GET['edit'])){
$marakez = $edit;
$id = $_GET['edit'];
}

if ($manage == 1 and $marakez == 1){
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
require_once 'connect.php';
$result = $conn->query("SELECT * FROM marakez WHERE myear=".$myear) or die($conn->error());
?>
<div class="container">
<div class="row justify-content-center">
	<form action="php/marakez_proccess.php" method="POST">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
	<div class="col col-sm-3">
	<div class="form-group">
		<br>
		<?php 
		if ($update == true):
		?>
		<button type="submit" tabindex="5" class="save" name="update">تحديث  <i class="fas fa-sync-alt save1"></i></button>
		<?php else: ?>
			<button type="submit" tabindex="4" class="save" name="save">حفظ <i class="fas fa-save save1"></i></button>
		<?php endif; ?>
	</div>
	</div>

		<div class="col col-sm-3">
		<div class="form-group">
			<label>: العام</label>
			<input type="hidden" name="myear" value="<?php echo $myear ?>">
			<input type="text" tabindex="3" class="form-control right1" style="height: 35px;" value="<?php echo $myear ?>" disabled>
		</div>
		</div>

		<div class="col col-sm-3">
		<div class="form-group">
			<label>: نوع المركز</label>
			<select name="mtype" class="form-control" tabindex="2" style="height: 35px;">
			<option value="1" <?php if ($update == true){if ($mtype == 1){echo 'selected';}} ?>>دعوي</option>
			<option value="2" <?php if ($update == true){if ($mtype == 2){echo 'selected';}} ?>>تعليمي</option>
			</select>
		</div>
		</div>

		<div class="col col-sm-3">
		<div class="form-group">
			<label>: اسم المركز</label>
			<input autocomplete="off" tabindex="1" maxlength="20" type="text" name="mname" class="form-control right1" style="height: 35px;" value="<?php echo $mname ?>" placeholder="ادخل اسم المركز">
		</div>
		</div>
	</form>
</div>
<div class="row justify-content-center">
	<table class="table right1">
		<thead class="thead1">
			<tr>
				<th class="right1">اجراءات</th>
				<th class="right1">نوع المركز</th>
				<th class="right1">اسم المركز</th>
				<th class="right1">العام</th>
			</tr>
		</thead>
		<?php while ($row = $result->fetch_assoc()):
			$r1 = $conn->query("SELECT * FROM groups WHERE markaz_name = ".$row['ID']) or die($conn->error());
			$num1 = mysqli_num_rows($r1);
			$r2 = $conn->query("SELECT * FROM rprograms WHERE b_markaz = ".$row['ID']) or die($conn->error());
			$num2 = mysqli_num_rows($r2);
			$r3 = $conn->query("SELECT * FROM comparison WHERE c_markaz = ".$row['ID']) or die($conn->error());
			$num3 = mysqli_num_rows($r3);
			$r4 = $conn->query("SELECT * FROM countc WHERE c_markaz = ".$row['ID']) or die($conn->error());
			$num4 = mysqli_num_rows($r4);
			$r5 = $conn->query("SELECT * FROM debts WHERE d_markaz = ".$row['ID']) or die($conn->error());
			$num5 = mysqli_num_rows($r5);
			$r6 = $conn->query("SELECT * FROM expensesm WHERE e_markaz = ".$row['ID']) or die($conn->error());
			$num6 = mysqli_num_rows($r6);
			$r7 = $conn->query("SELECT * FROM minfo WHERE m_markaz = ".$row['ID']) or die($conn->error());
			$num7 = mysqli_num_rows($r7);
			$r8 = $conn->query("SELECT * FROM portions WHERE p_markaz = ".$row['ID']) or die($conn->error());
			$num8 = mysqli_num_rows($r8);
			$r9 = $conn->query("SELECT * FROM salary WHERE s_markaz = ".$row['ID']) or die($conn->error());
			$num9 = mysqli_num_rows($r9);

			$total = $num1 + $num2 + $num3 + $num4 + $num5 + $num6 + $num7 + $num8 + $num9;
			?>
			<tr class="me">
				<td>
				<?php if ($total == 0 and $delete == 1){ ?>
					<a href="php/marakez_proccess.php?delete=<?php echo $row['ID']; ?>"><i class="fas fa-trash-alt i1"></i></a>
				<?php } ?>
				<?php if ($edit == 1){ ?>
				<a href="marakez.php?edit=<?php echo $row['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
				<?php } ?>
				</td>
				<td><?php if ($row['mtype'] == 1){
					echo 'دعوي';
				}else{
					echo 'تعليمي';
				} ?></td>
				<td><?php echo $row['mname']; ?></td>
				<td><?php echo $row['myear']; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
</div>

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