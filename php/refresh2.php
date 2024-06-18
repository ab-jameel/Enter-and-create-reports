<?php
require_once '../connect.php';
$result = $conn->query("SELECT * FROM axis") or die($conn->error());
while ($row = $result->fetch_assoc()) {
	echo "<option>";
	echo $row['a_name'];
	echo "</option>";
 }
 ?>