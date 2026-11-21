<?php
session_start(); include "config/db.php";
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit; }
if(isset($_POST['add'])){
  $conn->query("INSERT INTO invoices (invoice_no, customer_id, service_id, total, payment_method, payment_status) VALUES ('{$_POST['invoice_no']}','{$_POST['customer_id']}','{$_POST['service_id']}','{$_POST['total']}','{$_POST['payment_method']}','{$_POST['payment_status']}')");
  header("Location: invoices.php"); exit;
}
if(isset($_GET['paid'])){ $conn->query("UPDATE invoices SET payment_status='Paid' WHERE id='{$_GET['paid']}'"); header("Location: invoices.php"); exit; }
$invs = $conn->query("SELECT i.*, c.name as cust, s.job_no FROM invoices i LEFT JOIN customers c ON i.customer_id=c.id LEFT JOIN services s ON i.service_id=s.id ORDER BY i.id DESC");
$customers = $conn->query("SELECT * FROM customers");
$services = $conn->query("SELECT * FROM services");
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container-fluid"><div class="row">
<?php include "sidebar.php"; ?>
<div class="col-md-10 p-4">
<h3>Invoices</h3>
<form method="POST" class="row mb-3">
<input name="invoice_no" placeholder="Invoice No e.g INV-001" class="form-control col m-1" required>
<select name="customer_id" class="form-control col m-1"><?php while($c=$customers->fetch_assoc()) echo "<option value='{$c['id']}'>{$c['name']}</option>"; ?></select>
<select name="service_id" class="form-control col m-1"><?php while($s=$services->fetch_assoc()) echo "<option value='{$s['id']}'>{$s['job_no']} - K{$s['amount']}</option>"; ?></select>
<input name="total" placeholder="Total K" class="form-control col m-1" required>
<select name="payment_method" class="form-control col m-1"><option>Cash</option><option>Mobile Money</option><option>Bank Transfer</option></select>
<select name="payment_status" class="form-control col m-1"><option>Unpaid</option><option>Paid</option></select>
<button name="add" class="btn col m-1" style="background:#ff6a00; color:white;">Create Invoice</button>
</form>
<table class="table table-bordered"><tr><th>Invoice No</th><th>Customer</th><th>Job</th><th>Total</th><th>Method</th><th>Status</th><th>Action</th></tr>
<?php while($r=$invs->fetch_assoc()){ echo "<tr><td>{$r['invoice_no']}</td><td>{$r['cust']}</td><td>{$r['job_no']}</td><td>K{$r['total']}</td><td>{$r['payment_method']}</td><td>{$r['payment_status']}</td><td><a href='invoices.php?paid={$r['id']}' class='btn btn-sm btn-success'>Mark Paid</a> <a href='invoice_view.php?id={$r['id']}' class='btn btn-sm btn-info'>View/Print</a></td></tr>"; } ?>
</table>
</div></div></div></body></html>
