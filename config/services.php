<?php
session_start(); include "config/db.php";
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit; }
if(isset($_POST['add'])){
  $conn->query("INSERT INTO services (job_no, customer_id, vehicle_id, service_date, job_type, description, status, amount) VALUES ('{$_POST['job_no']}','{$_POST['customer_id']}','{$_POST['vehicle_id']}','{$_POST['service_date']}','{$_POST['job_type']}','{$_POST['description']}','{$_POST['status']}','{$_POST['amount']}')");
  header("Location: services.php"); exit;
}
if(isset($_GET['delete'])){ $conn->query("DELETE FROM services WHERE id='{$_GET['delete']}'"); header("Location: services.php"); exit; }
$services = $conn->query("SELECT s.*, c.name as cust, v.vehicle_name FROM services s LEFT JOIN customers c ON s.customer_id=c.id LEFT JOIN vehicles v ON s.vehicle_id=v.id ORDER BY s.id DESC");
$customers = $conn->query("SELECT * FROM customers");
$vehicles = $conn->query("SELECT * FROM vehicles");
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container-fluid"><div class="row">
<?php include "sidebar.php"; ?>
<div class="col-md-10 p-4">
<h3>Services</h3>
<form method="POST" class="row mb-3">
<input name="job_no" placeholder="Job No e.g JOB-001" class="form-control col m-1" required>
<select name="customer_id" class="form-control col m-1"><?php while($c=$customers->fetch_assoc()) echo "<option value='{$c['id']}'>{$c['name']}</option>"; ?></select>
<select name="vehicle_id" class="form-control col m-1"><?php while($v=$vehicles->fetch_assoc()) echo "<option value='{$v['id']}'>{$v['vehicle_name']} - {$v['number_plate']}</option>"; ?></select>
<input type="date" name="service_date" class="form-control col m-1" value="<?php echo date('Y-m-d'); ?>">
<select name="job_type" class="form-control col m-1"><option>Oil Change</option><option>Full Service</option><option>Brake Service</option><option>Engine Repair</option><option>Body Work</option><option>Other</option></select>
<input name="description" placeholder="Description" class="form-control col m-1">
<select name="status" class="form-control col m-1"><option>Pending</option><option>In Progress</option><option>Completed</option></select>
<input name="amount" placeholder="Amount" class="form-control col m-1">
<button name="add" class="btn col m-1" style="background:#ff6a00; color:white;">Add</button>
</form>
<table class="table table-bordered"><tr><th>Job No</th><th>Customer</th><th>Vehicle</th><th>Date</th><th>Type</th><th>Status</th><th>Amount</th><th>Action</th></tr>
<?php while($r=$services->fetch_assoc()) echo "<tr><td>{$r['job_no']}</td><td>{$r['cust']}</td><td>{$r['vehicle_name']}</td><td>{$r['service_date']}</td><td>{$r['job_type']}</td><td>{$r['status']}</td><td>{$r['amount']}</td><td><a href='services.php?delete={$r['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete?\")'>Delete</a></td></tr>"; ?>
</table>
</div></div></div></body></html>
