<?php
session_start(); include "config/db.php";
$id=$_GET['id'];
$i = $conn->query("SELECT i.*, c.name as cust, c.phone, c.email, s.job_no, s.job_type FROM invoices i LEFT JOIN customers c ON i.customer_id=c.id LEFT JOIN services s ON i.service_id=s.id WHERE i.id='$id'")->fetch_assoc();
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container p-4">
<a href="invoices.php">← Back</a>
<div class="card p-4 mt-3">
<h3 style="color:#ff6a00;">GARAGE MASTER - INVOICE</h3>
<p><b>Invoice No:</b> <?php echo $i['invoice_no']; ?> | <b>Date:</b> <?php echo $i['created_at']; ?></p>
<p><b>Bill To:</b> <?php echo $i['cust']; ?> - <?php echo $i['phone']; ?> - <?php echo $i['email']; ?></p>
<p><b>Job:</b> <?php echo $i['job_no']; ?> - <?php echo $i['job_type']; ?></p>
<hr>
<h4>Total Due: K <?php echo $i['total']; ?></h4>
<p><b>Payment Method:</b> <?php echo $i['payment_method']; ?></p>
<p><b>Status:</b> <?php echo $i['payment_status']; ?></p>
<button onclick="window.print()" class="btn" style="background:#ff6a00; color:white;">Print Invoice</button>
</div></div></body></html>
