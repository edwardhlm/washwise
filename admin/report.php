<?php include "../config.php";
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
$q = mysqli_query($conn, "SELECT orders.*, users.name as uname FROM orders JOIN users ON orders.user_id=users.id WHERE status='Delivered' ORDER BY id DESC");
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) as s FROM orders WHERE status='Delivered'"))["s"];
?>
<html><head><title>Report</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="navbar"><div class="logo">WashWise Admin</div><div><a href="dashboard.php">Dashboard</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container"><div class="card"><h2>Income Report</h2>
<p>Total income: <b class="price">Rp <?php echo (int) $total; ?></b></p>
<?php if (mysqli_num_rows($q) == 0) { ?>
<p class="empty">No delivered orders yet. Income will appear here.</p>
<?php } else { ?>
<table><tr><th>ID</th><th>Customer</th><th>Total</th><th>Date</th></tr>
<?php while($o=mysqli_fetch_assoc($q)){ echo "<tr><td>".(int)$o["id"]."</td><td>".e($o["uname"])."</td><td class='price'>Rp ".(int)$o["total_price"]."</td><td>".e($o["order_date"])."</td></tr>"; } ?>
</table>
<?php } ?></div></div>
</body></html>
