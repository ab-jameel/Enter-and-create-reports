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

	<title>اعداد المهتدين</title>
<?php 
require_once 'php/countc_proccess.php';
if (isset($_SESSION['id'])){
$username1 = $_SESSION['kusername'];
$email1 = $_SESSION['kemail'];
$id = $_SESSION['id'];
require_once'connect.php';
require_once'php/premissions.php';

$result1 = $conn->query("SELECT * FROM premissions WHERE p_user = $id AND p_page = 5") or die($conn->error());
$row1 = $result1->fetch_assoc();

if ($learn == 1 and $countc == 1){
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
	$result10 = $conn->query("SELECT * FROM countc ORDER BY ID DESC") or die($conn->error());
	$num10 = mysqli_num_rows($result10);
	if ($num10 > 0){
		$row10 = $result10->fetch_assoc();
		$the_year = $row10['c_year'];
		$the_month = $row10['c_month'];
	}
?>
</div>
<br>
<div class="container">
	<div class="row justify-content-center">
		<div class="col col-sm-2">
		<div class="form-group">
			<label>: الشهر</label>
			<select class="form-control" style="height: 30px;" disabled>
				<?php
				 $r1 = $conn->query("SELECT * FROM months WHERE ID=".$the_month) or die($conn->error());
				 while ($m1 = $r1->fetch_assoc()) { ?>
				<option value="<?php echo $m1['ID']; ?>"><?php echo $m1['m_name']; ?></option>
				<?php } ?>
			</select>
		</div>
		</div>
		
		<div class="col col-sm-2">
		<div class="form-group">
			<label>: العام </label>
			<input type="text" class="form-control right1" style="height: 30px;" value="<?php echo $the_year ?>" disabled>
		</div>
		</div>
	</div>
<?php
$result=$conn->query("SELECT * FROM countc WHERE c_year='$the_year' AND c_month='$the_month'") or die($conn->error());
?>
<div class="row justify-content-center">
	<table class="table cen2">
		<thead class="thead1">
				<th class="cen2">اعداد طلاب التحفيظ</th>
				<th class="cen2">اعداد المتسربين من الدورات المتقدمة</th>
				<th class="cen2">اعداد الدورات المتقدمة</th>
				<th class="cen2">اعداد المتسربين من المهتدين</th>
				<th class="cen2">اعداد تعليم المهتدين</th>
				<th class="right1">اسم المركز</th>
		</thead>
		<?php 
		while ($row = $result->fetch_assoc()):
				$result1 = $conn->query("SELECT * FROM marakez WHERE ID=".$row['c_markaz']) or die($conn->error());
				$row1 = $result1->fetch_assoc();
			 ?>
			<tr class="me">
				<td><?php echo number_format($row['c_student']); ?></td>
				<td><?php echo number_format($row['c_devl']); ?></td>
				<td><?php echo number_format($row['c_dev']); ?></td>
				<td><?php echo number_format($row['c_learnl']); ?></td>
				<td><?php echo number_format($row['c_learn']); ?></td>
				<td class="right1"><?php echo $row1['mname']; ?></td>
			</tr>
		<?php endwhile; ?>
	</table>

</div>
	
	<div class="row justify-content-start">
	<div class="col col-sm-3">
	<div class="form-group">
		<br>
		<a href="countc.php?edit=<?php echo $the_year; ?>&edit2=<?php echo $the_month; ?>&r=3" class="cancel">تعديل</a>
		<a href="countc_main.php" class="cancel">رجوع</a>
	</div>
	</div>
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