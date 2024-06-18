<?php
require_once '../connect.php';

if (isset($_POST['name'])){
$name = $_POST['name'];
$name = ltrim($name);
if ($name !== ''){
$res = $conn->query("SELECT * FROM programs WHERE p_name LIKE '$name'") or die($conn->error());
$num = mysqli_num_rows($res);
if ($num > 0){
	echo '<div class="alert alert-danger" role="alert">';
	echo 'برنامج <strong>'.$name.'</strong> مضاف مسبقا';
	echo '<i class="fas fa-exclamation i2"></i>';
	echo '</div>';
}else{
$conn->query("INSERT INTO programs (p_name) VALUES('$name')") or die($conn->error());
echo '<div class="alert alert-success" role="alert">';
echo 'تم اضافة برنامج <strong>'.$name.'</strong> بنجاح ';
echo '<i class="fas fa-check i2"></i>';
echo '</div>';
}
}else{
	echo '<div class="alert alert-danger" role="alert">';
	echo 'الرجاء تعبئة الحقل';
	echo '<i class="fas fa-exclamation i2"></i>';
	echo '</div>';
}}

if (isset($_POST['name2'])){
$name = $_POST['name2'];
$name = ltrim($name);
if ($name !== ''){
$res = $conn->query("SELECT * FROM axis WHERE a_name LIKE '$name'") or die($conn->error());
$num = mysqli_num_rows($res);
if ($num > 0){
	echo '<div class="alert alert-danger" role="alert">';
	echo 'محور <strong>'.$name.'</strong> مضاف مسبقا';
	echo '<i class="fas fa-exclamation i2"></i>';
	echo '</div>';
}else{
$conn->query("INSERT INTO axis (a_name) VALUES('$name')") or die($conn->error());
echo '<div class="alert alert-success" role="alert">';
echo 'تم اضافة محور <strong>'.$name.'</strong> بنجاح ';
echo '<i class="fas fa-check i2"></i>';
echo '</div>';
}}else{
	echo '<div class="alert alert-danger" role="alert">';
	echo 'الرجاء تعبئة الحقل';
	echo '<i class="fas fa-exclamation i2"></i>';
	echo '</div>';
}}

if (isset($_POST['name3'])){
$name = $_POST['name3'];
$name = ltrim($name);
if ($name !== ''){
$res = $conn->query("SELECT * FROM ctype WHERE t_name LIKE '$name'") or die($conn->error());
$num = mysqli_num_rows($res);
if ($num > 0){
	echo '<div class="alert alert-danger" role="alert">';
	echo 'نوع <strong>'.$name.'</strong> مضاف مسبقا';
	echo '<i class="fas fa-exclamation i2"></i>';
	echo '</div>';
}else{
$conn->query("INSERT INTO ctype (t_name) VALUES('$name')") or die($conn->error());
echo '<div class="alert alert-success" role="alert">';
echo 'تم اضافة نوع <strong>'.$name.'</strong> بنجاح ';
echo '<i class="fas fa-check i2"></i>';
echo '</div>';
}}else{
	echo '<div class="alert alert-danger" role="alert">';
	echo 'الرجاء تعبئة الحقل';
	echo '<i class="fas fa-exclamation i2"></i>';
	echo '</div>';
}}

if (isset($_POST['c_year'])){
$c_year = $_POST['c_year'];
$c_year = ltrim($c_year);
$result = $conn->query("SELECT * FROM marakez WHERE myear='$c_year'") or die($conn->error());
$num = mysqli_num_rows($result);
if ($num > 0){
	echo "<option>";
	echo "</option>";
while ($row = $result->fetch_assoc()) {
	echo "<option value=".$row['ID'].">";
	echo $row['mname'];
	echo "</option>";
 }
}}

?>