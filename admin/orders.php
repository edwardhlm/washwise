<?php include "../config.php";
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
$q = mysqli_query($conn, "SELECT orders.*, users.name as uname, services.name as sname FROM orders JOIN users ON orders.user_id=users.id JOIN services ON orders.service_id=services.id ORDER BY orders.id DESC");
?>
<html><head><title>Orders</title><link rel="stylesheet" href="../style.css"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
<div class="navbar"><div class="logo">WashWise Admin</div><div><a href="dashboard.php">Dashboard</a><a href="services.php">Services</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container"><div class="card"><h2>All Orders</h2>
<?php if (mysqli_num_rows($q) == 0) { ?>
<p class="empty">No orders yet. New customer orders will appear here.</p>
<?php } else { ?>
<table><tr><th>ID</th><th>Customer</th><th>Service</th><th>Total</th><th>Status</th><th>Update</th></tr>
<?php while($o=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?php echo (int) $o["id"]; ?></td><td><?php echo e($o["uname"]); ?></td><td><?php echo e($o["sname"]); ?></td><td class="price">Rp <?php echo (int) $o["total_price"]; ?></td>
<td><span class="badge b-<?php echo e($o["status"]); ?>"><?php echo e($o["status"]); ?></span></td>
<td>
<form action="../process.php?action=update_status" method="POST">
<input type="hidden" name="order_id" value="<?php echo (int) $o["id"]; ?>">
<input type="number" step="0.5" name="weight" value="<?php echo e($o["weight"]); ?>" style="width:70px">
<select name="status">
<option <?php if($o["status"]=="Waiting") echo "selected"; ?>>Waiting</option>
<option <?php if($o["status"]=="Picked-up") echo "selected"; ?>>Picked-up</option>
<option <?php if($o["status"]=="Washing") echo "selected"; ?>>Washing</option>
<option <?php if($o["status"]=="Done") echo "selected"; ?>>Done</option>
<option <?php if($o["status"]=="Delivered") echo "selected"; ?>>Delivered</option>
</select>
<button class="btn btn-blue" type="submit">Save</button>
<a href="order_detail.php?id=<?php echo (int) $o["id"]; ?>">Chat</a>
</form>
</td></tr>
<?php } ?>
</table>
<?php } ?></div></div>
</body></html>
