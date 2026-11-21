<?php
session_start(); include "config/db.php";
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit; }
if(isset($_GET['delete'])){ $conn->query("DELETE FROM vehicles WHERE id='{$_GET['delete']}'"); header("Location: vehicles.php"); exit; }
if(isset($_POST['add_vehicle'])){
    $conn->query("INSERT INTO vehicles (customer_id, vehicle_name, number_plate, model, chassis_no, engine_no, fuel, color, manufacture_date) VALUES ('{$_POST['customer_id']}','{$_POST['vehicle_name']}','{$_POST['number_plate']}','{$_POST['model']}','{$_POST['chassis_no']}','{$_POST['engine_no']}','{$_POST['fuel']}','{$_POST['color']}','{$_POST['manufacture_date']}')");
    header("Location: vehicles.php"); exit;
}
$customers = $conn->query("SELECT * FROM customers");
$vehicles = $conn->query("SELECT v.*, c.name as customer_name FROM vehicles v LEFT JOIN customers c ON v.customer_id=c.id ORDER BY v.id DESC");
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container-fluid"><div class="row">
<?php include "sidebar.php"; ?>
<div class="col-md-10 p-4">
<h3>Vehicles</h3>
<button class="btn mb-3" style="background:#ff6a00; color:white;" data-bs-toggle="modal" data-bs-target="#addModal">+ Add Vehicle</button>
<table class="table table-bordered">
<tr><th>ID</th><th>Customer</th><th>Vehicle</th><th>Plate</th><th>Model</th><th>Fuel</th><th>Color</th><th>Action</th></tr>
<?php while($row = $vehicles->fetch_assoc()){ ?>
<tr><td><?php echo $row['id']; ?></td><td><?php echo $row['customer_name']; ?></td><td><?php echo $row['vehicle_name']; ?></td><td><?php echo $row['number_plate']; ?></td><td><?php echo $row['model']; ?></td><td><?php echo $row['fuel']; ?></td><td><?php echo $row['color']; ?></td>
<td><a href="vehicle_view.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">View</a> <a href="vehicles.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a></td></tr>
<?php } ?>
</table></div></div></div>
<div class="modal fade" id="addModal"><div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><h5>Add Vehicle</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
<form method="POST"><div class="modal-body">
<select name="customer_id" class="form-control mb-2" required><?php $customers->data_seek(0); while($c=$customers->fetch_assoc()){ echo "<option value='{$c['id']}'>{$c['name']}</option>"; } ?></select>
<input name="vehicle_name" placeholder="Vehicle Name e.g BMW 3 Series" class="form-control mb-2" required>
<input name="number_plate" placeholder="Number Plate" class="form-control mb-2" required>
<input name="model" placeholder="Model e.g 2020" class="form-control mb-2">
<input name="chassis_no" placeholder="Chassis No" class="form-control mb-2">
<input name="engine_no" placeholder="Engine No" class="form-control mb-2">
<select name="fuel" class="form-control mb-2"><option>Petrol</option><option>Diesel</option><option>Hybrid</option><option>Electric</option></select>
<input name="color" placeholder="Color" class="form-control mb-2">
<label>Date of Manufacturing</label><input type="date" name="manufacture_date" class="form-control mb-2">
</div><div class="modal-footer"><button name="add_vehicle" class="btn" style="background:#ff6a00; color:white;">Save</button></div></form>
</div></div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
