<?php
session_start(); include "config/db.php";
$id=$_GET['id'];
$q = $conn->query("SELECT q.*, c.name as cust, c.phone, v.vehicle_name, v.number_plate FROM quotations q LEFT JOIN customers c ON q.customer_id=c.id LEFT JOIN vehicles v ON q.vehicle_id=v.id WHERE q.id='$id'")->fetch_assoc();
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container p-4">
<a href="quotation.php">← Back</a>
<div class="card p-4 mt-3">
<h3 style="color:#ff6a00;">GARAGE MASTER - QUOTATION</h3>
<p><b>Quote No:</b> <?php echo $q['quotation_no']; ?> | <b>Date:</b> <?php echo $q['created_at']; ?></p>
<p><b>Customer:</b> <?php echo $q['cust']; ?> - <?php echo $q['phone']; ?></p>
<p><b>Vehicle:</b> <?php echo $q['vehicle_name']; ?> (<?php echo $q['number_plate']; ?>)</p>
<hr>
<p><b>Job:</b> <?php echo $q['job_type']; ?></p>
<p><b>Description:</b> <?php echo $q['description']; ?></p>
<h4>Total: K <?php echo $q['amount']; ?></h4>
<p><b>Status:</b> <?php echo $q['status']; ?></p>
<button onclick="window.print()" class="btn" style="background:#ff6a00; color:white;">Print</button>
</div></div></body></html>
