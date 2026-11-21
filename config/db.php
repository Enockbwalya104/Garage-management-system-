<?php
$conn = new mysqli("localhost", "root", "", "garage_master");
if($conn->connect_error){ die("Connection failed: ".$conn->connect_error); }
?>
