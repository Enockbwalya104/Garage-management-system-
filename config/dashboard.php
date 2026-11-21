<?php
session_start(); include "config/db.php";
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit; }
$total = $conn->query("SELECT COUNT(*) as c FROM services")->fetch_assoc()['c'];
$completed = $conn->query("SELECT COUNT(*) as c FROM services WHERE status='Completed'")->fetch_assoc()['c'];
$open = $conn->query("SELECT COUNT(*) as c FROM services WHERE status!='Completed'")->fetch_assoc()['c'];
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container-fluid"><div class="row">
<?php include "sidebar.php"; ?>
<div class="col-md-10 p-4">
<h3>Dashboard</h3>
<p>Opening Hours: <b>Mon-Fri: 9:00 AM - 7:00 PM | Sat: 9:00 AM - 6:00 PM | Sun: 10:00 AM - 1:00 PM</b></p>
<div class="row mb-3">
<div class="col-md-4"><div class="card p-3"><h5>Total Services</h5><h2><?php echo $total; ?></h2></div></div>
<div class="col-md-4"><div class="card p-3"><h5>Completed</h5><h2><?php echo $completed; ?></h2></div></div>
<div class="col-md-4"><div class="card p-3"><h5>Open</h5><h2><?php echo $open; ?></h2></div></div>
</div>
<div class="card p-3">
<h5>Calendar - <?php echo date('F Y'); ?></h5>
<input type="text" id="searchCal" placeholder="Search customer / plate..." class="form-control mb-2" onkeyup="filterCal()">
<table class="table table-bordered" id="calTable">
<tr><th>Date</th><th>Job No</th><th>Customer</th><th>Vehicle</th><th>Status</th></tr>
<?php
$cal = $conn->query("SELECT s.*, c.name, v.vehicle_name FROM services s LEFT JOIN customers c ON s.customer_id=c.id LEFT JOIN vehicles v ON s.vehicle_id=v.id ORDER BY s.service_date DESC LIMIT 10");
while($c=$cal->fetch_assoc()){
  $color = $c['status']=='Completed' ? 'background:#d4edda;' : 'background:#fff3cd;';
  echo "<tr style='$color'><td>{$c['service_date']}</td><td>{$c['job_no']}</td><td>{$c['name']}</td><td>{$c['vehicle_name']}</td><td>{$c['status']}</td></tr>";
}
?>
</table>
<p class="text-muted"><span style="background:#d4edda; padding:2px 8px;">Green = Completed</span> <span style="background:#fff3cd; padding:2px 8px;">Yellow = Open / In Progress</span></p>
</div></div></div></div>
<script>
function filterCal(){
  let q = document.getElementById('searchCal').value.toLowerCase();
  document.querySelectorAll('#calTable tr').forEach((row,i)=>{
    if(i==0) return;
    row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
  });
}
</script>
</body></html>
