<?php
session_start(); include "config/db.php";
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit; }
if(isset($_POST['add'])){
  $conn->query("INSERT INTO quotations (quotation_no, customer_id, vehicle_id, job_type, description, amount, status) VALUES ('{$_POST['quotation_no']}','{$_POST['customer_id']}','{$_POST['vehicle_id']}','{$_POST['job_type']}','{$_POST['description']}','{$_POST['amount']}','Pending')");
  header("Location: quotation.php"); exit;
}
if(isset($_GET['approve'])){ $conn->query("UPDATE quotations SET status='Approved' WHERE id='{$_GET['approve']}'"); header("Location: quotation.php"); exit; }
$qs = $conn->query("SELECT q.*, c.name as cust, v.vehicle_name FROM quotations q LEFT JOIN customers c ON q.customer_id=c.id LEFT JOIN vehicles v ON q.vehicle_id=v.id ORDER BY q.id DESC");
$customers = $conn->query("SELECT * FROM customers");
$vehicles = $conn->query("SELECT * FROM vehicles");
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container-fluid"><div class="row">
<?php include "sidebar.php"; ?>
<div class="col-md-10 p-4">
<h3>Quotation</h3>
<form method="POST" class="row mb-3">
<input name="quotation_no" placeholder="Quote No e.g Q-001" class="form-control col m-1" required>
<select name="customer_id" class="form-control col m-1"><?php while($c=$customers->fetch_assoc()) echo "<option value='{$c['id']}'>{$c['name']}</option>"; ?></select>
<select name="vehicle_id" class="form-control col m-1"><?php while($v=$vehicles->fetch_assoc()) echo "<option value='{$v['id']}'>{$v['vehicle_name']}</option>"; ?></select>
<input name="job_type" placeholder="Job Type" class="form-control col m-1">
<input name="description" placeholder="Description" class="form-control col m-1">
<input name="amount" placeholder="Amount" class="form-control col m-1">
<button name="add" class="btn col m-1" style="background:#ff6a00; color:white;">Create Quote</button>
</form>
<table class="table table-bordered"><tr><th>Quote No</th><th>Customer</th><th>Vehicle</th><th>Job</th><th>Amount</th><th>Status</th><th>Action</th></tr>
<?php while($r=$qs->fetch_assoc()){ echo "<tr><td>{$r['quotation_no']}</td><td>{$r['cust']}</td><td>{$r['vehicle_name']}</td><td>{$r['job_type']}</td><td>{$r['amount']}</td><td>{$r['status']}</td><td><a href='quotation.php?approve={$r['id']}' class='btn btn-sm btn-success'>Approve</a> <a href='quotation_view.php?id={$r['id']}' class='btn btn-sm btn-info'>View/Print</a></td></tr>"; } ?>
</table>
</div></div></div></body></html>
