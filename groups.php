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

	<title>الفرق</title>

<?php 
require_once 'php/groups_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 26") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];
$delete = $row1['p_delete'];


if (isset($_GET['edit'])){
$groups = $edit;
$id = $_GET['edit'];
}

if ($manage == 1 and $groups == 1){
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
<div class="container">
<div class="row justify-content-center">
	<form action="php/groups_proccess.php" method="POST">
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
			<label>: العام </label>
			<input type="hidden" name="the_year" tabindex="3" value="<?php echo $the_year ?>">
			<input type="text" tabindex="3" class="form-control right1" style="height: 30px;" value="<?php echo $the_year ?>" disabled>
		</div>
		</div>
		
		<div class="col col-sm-3">
		<div class="form-group">
			<label>: اسم الفرقة </label>
			<input autocomplete="off" maxlength="20" type="text" tabindex="2" name="group_name" class="form-control right1" style="height: 30px;" value="<?php echo $group_name ?>" placeholder="ادخل اسم الفرقة">
		</div>
		</div>

		<div class="col col-sm-3">
		<div class="form-group">
			<label>: اسم المركز</label>
			<select name="markaz_name" class="form-control" style="height: 30px;" tabindex="1">
<?php
	$result = $conn->query("SELECT * FROM marakez WHERE mtype = 1 AND myear=".$the_year) or die($conn->error());
	while ($row1 = mysqli_fetch_array($result)): ?>
	<option value="<?php echo $row1['ID']; ?>" <?php if ($update == true){
		if ($row1['ID'] == $markaz_name){
			echo "selected";
		}
	} ?>><?php echo $row1['mname']; ?></option>
<?php endwhile; ?>
</select>
		</div>
	</div>
		</div>
<div class="row justify-content-center">
	<?php
	require_once 'connect.php';
	$result = $conn->query("SELECT * FROM groups WHERE the_year=".$the_year) or die($conn->error());
	?>
	<table class="table right1">
		<thead class="thead1">
			<tr>
				<th class="right1">اجراءات</th>
				<th class="right1">العام</th>
				<th class="right1">اسم الفرقة</th>
				<th class="right1">اسم المركز</th>
			</tr>
		</thead>
		<?php while ($row = $result->fetch_assoc()):
			$r1 = $conn->query("SELECT * FROM marakez WHERE ID=".$row['markaz_name']) or die($conn->error());
			$row3 = $r1->fetch_assoc();

			$r2 = $conn->query("SELECT * FROM rprograms WHERE b_group = ".$row['ID']) or die($conn->error());
			$num = mysqli_num_rows($r2);
			  	?>
			<tr class="me">
				<td>
				<?php if ($num == 0 and $delete == 1){ ?>
					<a href="php/groups_proccess.php?delete=<?php echo $row['ID']; ?>"><i class="fas fa-trash-alt i1"></i></a>
				<?php } ?>
				<?php if ($edit == 1){ ?>
					<a href="groups.php?edit=<?php echo $row['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
				<?php } ?>
				</td>
				<td><?php echo $row['the_year']; ?></td>
				<td><?php echo $row['group_name']; ?></td>
				<td><?php echo $row3['mname']; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>
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