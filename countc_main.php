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
	$result = $conn->query("SELECT DISTINCT c_month, c_year FROM countc INNER JOIN months ON c_month = months.ID WHERE c_year = $the_year ORDER BY c_month ASC") or die($conn->error());
?>
</div>
<br>
<div class="container">

<div class="row justify-content-center">
	<button class="save" style="margin-bottom: 20px; width: 200px; font-weight: bold;" onclick="window.location.href = 'countc.php';">ادخال اعداد المهتدين <i class="fas fa-plus save1"></i></button>
</div>

<div class="row justify-content-center">

	<table class="table right1">
		<thead>
			<th colspan="3" class="right1"><?php echo $the_year; ?></th>
		</thead>
		<thead class="thead1">
			<th class="right1">الاجراءات</th>
			<th class="right1">الحالة</th>
			<th class="right1">الشهر</th>
		</thead>
		<?php while ($row = $result->fetch_assoc()):
			$result2 = $conn->query("SELECT * FROM rok INNER JOIN months ON k_month = months.ID WHERE k_year = $the_year AND r_type = 10 AND k_month = '".$row['c_month']."' ORDER BY k_month ASC") or die($conn->error());
			$result3 = $conn->query("SELECT * FROM rok INNER JOIN months ON k_month = months.ID WHERE k_year = $the_year AND r_type = 5 AND k_month = '".$row['c_month']."' ORDER BY k_month ASC") or die($conn->error());
			$row2 = $result2->fetch_assoc();
			$row3 = $result3->fetch_assoc();
			$num1 = mysqli_num_rows($result3);
			if ($num1 > 0){
			$row2['k_type'] = $row3['k_type'];
			}else{
			$row2['k_type'] = 0;
			}
		?>
			<tr class="me">
			<td class="right1">
				<?php if($row2['k_type'] == 0){ ?>
					<a href="countc.php?edit=<?php echo $row['c_year']; ?>&edit2=<?php echo $row['c_month']; ?>&r=4"><i class="fas fa-pencil-alt i1"></i></a>
				<?php } ?>
			</td>
			<td class="right1"><?php if ($row2['k_type'] == 1){ echo 'معتمد'; }else{ echo 'غير معتمد'; } ?></td>
			<td class="right1"><?php echo $row2['m_name']; ?></td>
			</tr>
		<?php endwhile; ?>

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