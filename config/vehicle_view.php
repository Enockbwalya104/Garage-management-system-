<?php
session_start(); include "config/db.php";
$id = $_GET['id'];
$row = $conn->query("SELECT v.*, c.name as customer_name, c.phone, c.email FROM vehicles v LEFT JOIN customers c ON v.customer_id=c.id WHERE v.id='$id'")->fetch_assoc();
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container p-4">
<a href="vehicles.php">← Back to Vehicles</a>
<h3 class="mt-3"><?php echo $row['vehicle_name']; ?> - <?php echo $row['number_plate']; ?></h3>
<div class="card p-4 mt-3">
<p><b>Customer:</b> <?php echo $row['customer_name']; ?> | <?php echo $row['phone']; ?> | <?php echo $row['email']; ?></p>
<p><b>Model:</b> <?php echo $row['model']; ?></p>
<p><b>Chassis No:</b> <?php echo $row['chassis_no']; ?></p>
<p><b>Engine No:</b> <?php echo $row['engine_no']; ?></p>
<p><b>Fuel:</b> <?php echo $row['fuel']; ?></p>
<p><b>Color:</b> <?php echo $row['color']; ?></p>
<p><b>Date of Manufacturing:</b> <?php echo $row['manufacture_date']; ?></p>
<button onclick="window.print()" class="btn" style="background:#ff6a00; color:white;">Print</button>
</div></div></body></html>
