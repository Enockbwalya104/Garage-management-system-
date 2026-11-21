<?php
session_start();
include "config/db.php";
if(isset($_POST['login'])){
    $u = $_POST['username']; $p = $_POST['password'];
    $res = $conn->query("SELECT * FROM users WHERE username='$u' AND password='$p'");
    if($res->num_rows > 0){
        $_SESSION['user'] = $u;
        header("Location: dashboard.php"); exit;
    } else { $error = "Wrong username or password"; }
}
?>
<!DOCTYPE html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body style="background:#f5f5f5;">
<div class="container mt-5" style="max-width:400px;">
<div class="card p-4">
<h3 style="color:#ff6a00;">GARAGE MASTER</h3>
<p>Login to continue</p>
<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form method="POST">
<input name="username" placeholder="Username" class="form-control mb-2" value="admin">
<input type="password" name="password" placeholder="Password" class="form-control mb-2" value="admin123">
<button name="login" class="btn w-100" style="background:#ff6a00; color:white;">Login</button>
</form></div></div></body></html>
