<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'maktab';
$conn=new mysqli($servername ,$username ,$password ,$dbname ) or die(mysql_error($conn));
$conn->set_charset('utf8');
?>