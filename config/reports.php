<?php
session_start(); include "config/db.php";
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit; }
$total_customers = $conn->query("SELECT COUNT(*) as c FROM customers")->fetch_assoc()['c'];
$total_vehicles = $conn->query("SELECT COUNT(*) as c FROM vehicles")->fetch_assoc()['c'];
$total_services = $conn->query("SELECT COUNT(*) as c FROM services")->fetch_assoc()['c'];
$total_revenue = $conn->query("SELECT SUM(total) as s FROM invoices WHERE payment_status='Paid'")->fetch_assoc()['s'];
$unpaid = $conn->query("SELECT SUM(total) as s FROM invoices WHERE payment_status='Unpaid'")->fetch_assoc()['s'];
$pending_services = $conn->query("SELECT COUNT(*) as c FROM services WHERE status='Pending'")->fetch_assoc()['c'];
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container-fluid"><div class="row">
<?php include "sidebar.php"; ?>
<div class="col-md-10 p-4">
<h3>Reports</h3>
<div class="row">
<div class="col-md-4"><div class="card p-3 mb-3"><h5>Total Customers</h5><h2><?php echo $total_customers; ?></h2></div></div>
<div class="col-md-4"><div class="card p-3 mb-3"><h5>Total Vehicles</h5><h2><?php echo $total_vehicles; ?></h2></div></div>
<div class="col-md-4"><div class="card p-3 mb-3"><h5>Total Services</h5><h2><?php echo $total_services; ?></h2></div></div>
<div class="col-md-4"><div class="card p-3 mb-3" style="border:2px solid green;"><h5>Total Revenue (Paid)</h5><h2>K <?php echo $total_revenue ? $total_revenue : 0; ?></h2></div></div>
<div class="col-md-4"><div class="card p-3 mb-3" style="border:2px solid red;"><h5>Unpaid Amount</h5><h2>K <?php echo $unpaid ? $unpaid : 0; ?></h2></div></div>
<div class="col-md-4"><div class="card p-3 mb-3"><h5>Pending Services</h5><h2><?php echo $pending_services; ?></h2></div></div>
</div>
<button onclick="window.print()" class="btn" style="background:#ff6a00; color:white;">Print Report</button>
</div></div></div></body></html>
