<?php
session_start(); include "config/db.php";
$id=$_GET['id'];
$j = $conn->query("SELECT j.*, s.job_no, s.service_date FROM jobcards j LEFT JOIN services s ON j.service_id=s.id WHERE j.id='$id'")->fetch_assoc();
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container p-4">
<a href="jobcard.php">← Back</a>
<div class="card p-4 mt-3">
<h3 style="color:#ff6a00;">GARAGE MASTER - JOB CARD</h3>
<p><b>JobCard No:</b> <?php echo $j['jobcard_no']; ?> | <b>Service Job:</b> <?php echo $j['job_no']; ?></p>
<p><b>Mechanic:</b> <?php echo $j['mechanic']; ?></p>
<p><b>Work Done:</b> <?php echo $j['work_done']; ?></p>
<p><b>Status:</b> <?php echo $j['status']; ?></p>
<p><b>Date:</b> <?php echo $j['service_date']; ?></p>
<button onclick="window.print()" class="btn" style="background:#ff6a00; color:white;">Print</button>
</div></div></body></html>
