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

	<style type="text/css">
	*{
		font-family: arial;
	}

	.save{
		float: left;
	}
	</style>
	<title>سعر الصرف</title>

<?php 
require_once 'php/exchange_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 24") or die($conn->error());
$row1 = $result1->fetch_assoc();
$edit = $row1['p_edit'];


if (isset($_GET['edit'])){
$exchange = $edit;
$id = $_GET['edit'];
}

if ($manage == 1 and $exchange == 1){
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
<?php
$result5 = $conn->query("SELECT * FROM exchange ORDER BY e_year DESC") or die($conn->error());
$row5 = $result5->fetch_assoc();
$num5 = mysqli_num_rows($result5);
if ($num5 > 0) {
$result = $conn->query("SELECT * FROM exchange WHERE e_year='".$row5['e_year']."'ORDER BY e_month ASC") or die($conn->error());
}else{
$result = $conn->query("SELECT * FROM exchange") or die($conn->error());
}
$num = mysqli_num_rows($result);
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
<table class="table">
	<thead class="thead1">
		<tr>
			<th class="right1">اجراءات</th>
			<th class="right1">سعر الصرف</th>
			<th class="right1">الشهر</th>
			<th class="right1">السنة</th>
		</tr>
	</thead>
	<?php while ($row = $result->fetch_assoc()){
		$result1 = $conn->query("SELECT * FROM months WHERE ID=".$row['e_month']) or die($conn->error());
		$row1 = $result1->fetch_assoc();
	 ?>
	<tr class="me">
		<td>
			<?php if ($edit == 1){ ?>
			<a href="exchange.php?edit=<?php echo $row['ID']; ?>"><i class="fas fa-pencil-alt i1"></i></a>
			<?php } ?>
		</td>
		<td class="right1"><?php echo $row['e_price']; ?></td>
		<td class="right1"><?php echo $row1['m_name']; ?></td>
		<td class="right1"><?php echo $row['e_year']; ?></td>
	</tr>
<?php }
$result = $conn->query("SELECT * FROM exchange ORDER BY e_year DESC") or die($conn->error());
$row = $result->fetch_assoc();
 ?>
	<tr>
		<td colspan="4" class="add">
		<button data-toggle="modal" data-target="#mymodel" class="bt1 save">اضافة سنة<i class="fas fa-plus save1"></i></button>
		</td>
	</tr>
</table>
</div>
</div>

<form action="php/exchange_proccess.php" method="POST">
<div id="mymodel" class="modal fade right1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="justify-content-between">
				<button type="button" class="close" data-dismiss="modal" style="float: left;">&times;</button>
				</div>
				<h3 class="modal-title">اضافة سنة</h3>
			</div>
			<div class="modal-body">
				<div class="half1 ha1">
				<p class="block1"> :العام</p>
				<?php if ($num !==0){?>
				<input type="text" class="right1" value="<?php	$r3 = $row['e_year']+1;
					echo $r3;?>" disabled>
				<input type="hidden" name="e_year" value="<?php	echo $r3;?>">
				<?php }else{ ?>
				<input type="text" class="right1" name="e_year" autocomplete="off">
				<?php } ?>
			</div>
			<div class="half1">
				<p class="block1"> :سعر الصرف</p>
				<input type="text" name="e_price" class="right1" autocomplete="off" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57">
				<br>
			</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="submit" class="save" name="save">حفظ <i class="fas fa-save save1"></i></button>
			</div>
		</div>
		
	</div>
	
</div>
</form>

<form action="php/exchange_proccess.php" method="POST">
<div id="mymodel1" class="modal fade right1" role="dialog" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="justify-content-start">
				<a href="exchange.php" class="a1">&times;</a>
				</div>
				<div class="justify-content-end">
				<h3 class="modal-title">تعديل سعر الصرف</h3>
				</div>
			</div>
			<div class="modal-body">
				<div class="half1 ha1">
				<p class="block1"> :الشهر</p>
				<input type="text" name="e_year1" class="right1" autocomplete="off" value="<?php echo $e_month; ?>" disabled>
				<input type="hidden" name="id" value="<?php echo $id; ?>">
			</div>
			<div class="half1">
				<p class="block1"> :سعر الصرف</p>
				<input type="text" name="e_price1" class="right1" value="<?php echo $e_price; ?>" autocomplete="off" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57">
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
	if (window.location.href.indexOf("edit=") > 0) {
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