<?php include "../config.php";
if (!isset($_SESSION["user_id"])) { header("Location: ../login.php"); exit; }
$id = (int) $_SESSION["user_id"];
$q = mysqli_query($conn, "SELECT orders.*, services.name as sname FROM orders JOIN services ON orders.service_id=services.id WHERE orders.user_id='$id' ORDER BY orders.id DESC");
?>
<html><head><title>My Orders</title><link rel="stylesheet" href="../style.css"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
<div class="navbar"><div class="logo">WashWise</div><div><a href="dashboard.php">Home</a><a href="new_order.php">New Order</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container"><div class="card">
<h2>My Orders</h2>
<?php if (mysqli_num_rows($q) == 0) { ?>
<p class="empty">You have no orders yet. <a href="new_order.php">Create your first order</a>.</p>
<?php } else { ?>
<table><tr><th>ID</th><th>Service</th><th>Total</th><th>Status</th><th>Action</th></tr>
<?php while($o=mysqli_fetch_assoc($q)){
echo "<tr><td>".(int)$o["id"]."</td><td>".e($o["sname"])."</td><td class='price'>Rp ".(int)$o["total_price"]."</td><td><span class='badge b-".e($o["status"])."'>".e($o["status"])."</span></td><td><a href='order_detail.php?id=".(int)$o["id"]."'>Detail</a></td></tr>";
} ?>
</table>
<?php } ?>
</div></div>
</body></html>
