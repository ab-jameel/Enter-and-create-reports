<?php 
require_once '../connect.php';
$result = $conn->query("SELECT * FROM ctype") or die($conn->error());
while ($row = $result->fetch_assoc()) {
	echo "<option>";
	echo $row['t_name'];
	echo "</option>";
 }
 ?>