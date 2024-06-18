<?php
require_once '../connect.php';
$result = $conn->query("SELECT * FROM programs") or die($conn->error());
while ($row = $result->fetch_assoc()) {
	echo "<option>";
	echo $row['p_name']; 
	echo "</option>";
 }
 ?>