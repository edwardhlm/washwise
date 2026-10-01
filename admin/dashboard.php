<?php include "../config.php";
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
$today = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM orders WHERE DATE(order_date)=CURDATE()"))["c"];
$wait = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM orders WHERE status='Waiting'"))["c"];
$income = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) as s FROM orders WHERE status='Delivered'"))["s"];
if (!$income) { $income = 0; }
?>
<html><head><title>Admin Dashboard - WashWise</title><link rel="stylesheet" href="../style.css"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
<div class="navbar"><div class="logo">WashWise Admin</div>
<div><a href="dashboard.php">Dashboard</a><a href="orders.php">Orders</a><a href="services.php">Services</a><a href="users.php">Users</a><a href="report.php">Report</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container">
<div class="card">
<p class="eyebrow">Dipercaya dari Tahun ke Tahun</p>
<h2>Welcome Admin</h2>
<span class="accent-bar"></span>
<div class="stat-grid">
<div class="stat-card light"><div class="num"><?php echo $today; ?></div><div class="lbl">Orders Today</div></div>
<div class="stat-card"><div class="num"><?php echo $wait; ?></div><div class="lbl">Waiting</div></div>
<div class="stat-card light"><div class="num" style="font-size:24px;">Rp <?php echo $income; ?></div><div class="lbl">Income</div></div>
</div>
<a href="orders.php" class="btn btn-blue">Kelola Orders -></a>
<a href="report.php" class="btn btn-beige">Income Report</a>
</div>
</div>
</body></html>
