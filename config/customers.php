<?php
session_start(); include "config/db.php";
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit; }
if(isset($_POST['add'])){ $conn->query("INSERT INTO customers (name, phone, email) VALUES ('{$_POST['name']}','{$_POST['phone']}','{$_POST['email']}')"); header("Location: customers.php"); exit; }
$list = $conn->query("SELECT * FROM customers ORDER BY id DESC");
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container-fluid"><div class="row">
<?php include "sidebar.php"; ?>
<div class="col-md-10 p-4">
<h3>Customers</h3>
<form method="POST" class="row mb-3">
<input name="name" placeholder="Name" class="form-control col m-1" required>
<input name="phone" placeholder="Phone" class="form-control col m-1" required>
<input name="email" placeholder="Email" class="form-control col m-1">
<button name="add" class="btn col m-1" style="background:#ff6a00; color:white;">Add Customer</button>
</form>
<table class="table table-bordered"><tr><th>Name</th><th>Phone</th><th>Email</th></tr>
<?php while($r=$list->fetch_assoc()) echo "<tr><td>{$r['name']}</td><td>{$r['phone']}</td><td>{$r['email']}</td></tr>"; ?>
</table>
</div></div></div></body></html>
