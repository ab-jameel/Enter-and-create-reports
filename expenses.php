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
	<script src="js/jquery-3.4.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/logout.js"></script>
	<script src="https://kit.fontawesome.com/9acd051564.js" crossorigin="anonymous"></script>
	<link rel="icon" type="image/png" href="images/new.bmp"/>

	<title>المصروفات العامة</title>
<?php 
require_once 'php/expenses_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 14") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];
$delete = $row1['p_delete'];


if (isset($_GET['edit'])){
$expenses = $edit;
$id = $_GET['edit'];
}

if ($money == 1 and $expenses == 1){
?>


	<script type="text/javascript">
		function search() {
			var e_date=document.getElementById('e_date').value;
			var d = new Date(e_date);
			var year = d.getFullYear();
			var dataString='e_date='+year;
			$.ajax({
				type:"post",
				url:"php/search.php",
				data:dataString,
				cache:false,
				success:function(html){
				document.getElementById('select1').innerHTML = html;
				}
			});
			return false;
		};
	</script>

	<style type="text/css">
	.save{
		float: left;
		margin-right: 10px;
		margin-top: -30px;
	}
	</style>

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
$result = $conn->query("SELECT YEAR(e_date) AS year FROM expenses ORDER BY e_date DESC") or die($conn->error());
$num = mysqli_num_rows($result);
if ($num > 0){
$row = $result->fetch_assoc();
$last = $row['year'];
$last2 = $last-1;
	$result = $conn->query("SELECT * FROM expenses WHERE YEAR(e_date) = ".$last) or die($conn->error());
}else{
	$result = $conn->query("SELECT * FROM expenses") or die($conn->error());
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

<form action="php/expenses_proccess.php" method="POST">
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
			<label>: البيان</label>
			<input tabindex="5" autocomplete="off" type="text" name="e_notice" class="form-control right1" style="height: 30px;width: 350px;" value="<?php echo $e_notice ?>">
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: البند</label>
			<select tabindex="4" name="e_comparison" id="select1" class="form-control" style="height: 33px; width: 175px;">
				<?php 
				$result1 = $conn->query("SELECT DISTINCT c_program FROM comparison WHERE c_year='".$year."'") or die($conn->error());
				while ($row1 = $result1->fetch_assoc()){
				if ($update == true){
					if ($e_comparison == $row1['c_program']){
					echo "<option selected>";
				}else{
					echo "<option>";
				}
				}else{
					echo "<option>";
				}
				echo $row1['c_program'];
				echo "</option>";
				} ?>
			</select>
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: القيمة </label>
			<input tabindex="3" type="text" class="form-control right1" style="height: 30px; width: 135px;" value="<?php echo $e_amount ?>" name="e_amount" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="off">
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: العملة</label>
			<select tabindex="2" name="e_currency" class="form-control" style="height: 30px; width: 100px;">
				<option <?php if ($update == true){if ($e_currency == 'دولار'){echo 'selected';}} ?>>دولار</option>
				<option <?php if ($update == true){if ($e_currency == 'شلن'){echo 'selected';}} ?>>شلن</option>
			</select>
		</div>
		</div>

		<div class="line margin1">
		<div class="form-group">
			<label>: التاريخ </label>
			<input tabindex="1" type="date" min="<?php echo $last2 ?>-01-01" max="<?php echo $year ?>-12-31" class="form-control right1" style="height: 30px;width: 155px;" value="<?php echo $e_date ?>" name="e_date" id="e_date" onkeyup="return search()">
		</div>
		</div>

	</div>
</form>

<div class="row justify-content-center">
<table class="table">
	<thead class="thead1">
		<tr>
			<th class="right1">اجراءات</th>
			<th class="right1">البيان</th>
			<th class="right1">البند</th>
			<th class="right1">القيمة</th>
			<th class="right1">العملة</th>
			<th class="right1">التاريخ</th>
		</tr>
	</thead>
	<?php while ($row = $result->fetch_assoc()){ ?>
	<tr class="me">
		<td>
			<?php if ($delete == 1){ ?>
			<a href="php/expenses_proccess.php?delete=<?php echo $row['ID']; ?>"><i class="fas fa-trash-alt i1"></i></a>
			<?php } ?>
			<?php if ($edit == 1){ ?>
			<a href="expenses.php?edit=<?php echo $row['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
			<?php } ?>
		</td>
		<td class="right1"><?php echo $row['e_notice']?></td>
		<td class="right1"><?php echo $row['e_comparison']?></td>
		<td class="right1"><?php echo $row['e_amount']?></td>
		<td class="right1"><?php echo $row['e_currency']?></td>
		<td class="right1"><?php echo $row['e_date']?></td>
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