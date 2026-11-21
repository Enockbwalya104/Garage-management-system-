<?php
session_start(); include "config/db.php";
if(!isset($_SESSION['user'])){ header("Location: index.php"); exit; }
if(isset($_POST['add'])){
  $conn->query("INSERT INTO jobcards (jobcard_no, service_id, mechanic, work_done, status) VALUES ('{$_POST['jobcard_no']}','{$_POST['service_id']}','{$_POST['mechanic']}','{$_POST['work_done']}','Open')");
  header("Location: jobcard.php"); exit;
}
if(isset($_GET['close'])){ $conn->query("UPDATE jobcards SET status='Closed' WHERE id='{$_GET['close']}'"); header("Location: jobcard.php"); exit; }
$jcs = $conn->query("SELECT j.*, s.job_no FROM jobcards j LEFT JOIN services s ON j.service_id=s.id ORDER BY j.id DESC");
$services = $conn->query("SELECT * FROM services");
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container-fluid"><div class="row">
<?php include "sidebar.php"; ?>
<div class="col-md-10 p-4">
<h3>JobCard</h3>
<form method="POST" class="row mb-3">
<input name="jobcard_no" placeholder="JobCard No e.g JC-001" class="form-control col m-1" required>
<select name="service_id" class="form-control col m-1"><?php while($s=$services->fetch_assoc()) echo "<option value='{$s['id']}'>{$s['job_no']}</option>"; ?></select>
<input name="mechanic" placeholder="Mechanic Name" class="form-control col m-1">
<input name="work_done" placeholder="Work Done" class="form-control col m-1">
<button name="add" class="btn col m-1" style="background:#ff6a00; color:white;">Create JobCard</button>
</form>
<table class="table table-bordered"><tr><th>JobCard No</th><th>Service Job</th><th>Mechanic</th><th>Work Done</th><th>Status</th><th>Action</th></tr>
<?php while($r=$jcs->fetch_assoc()){ echo "<tr><td>{$r['jobcard_no']}</td><td>{$r['job_no']}</td><td>{$r['mechanic']}</td><td>{$r['work_done']}</td><td>{$r['status']}</td><td><a href='jobcard.php?close={$r['id']}' class='btn btn-sm btn-success'>Close</a> <a href='jobcard_view.php?id={$r['id']}' class='btn btn-sm btn-info'>View/Print</a></td></tr>"; } ?>
</table>
</div></div></div></body></html>
