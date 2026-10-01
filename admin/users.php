<?php include "../config.php";
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
$q = mysqli_query($conn, "SELECT * FROM users WHERE role='customer'");
?>
<html><head><title>Users</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="navbar"><div class="logo">WashWise Admin</div><div><a href="dashboard.php">Dashboard</a><a href="orders.php">Orders</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container"><div class="card"><h2>Customers</h2>
<?php if (mysqli_num_rows($q) == 0) { ?>
<p class="empty">No customers registered yet.</p>
<?php } else { ?>
<table><tr><th>Name</th><th>Phone</th><th>Address</th><th>Username</th></tr>
<?php while($u=mysqli_fetch_assoc($q)){ echo "<tr><td>".e($u["name"])."</td><td>".e($u["phone"])."</td><td>".e($u["address"])."</td><td>".e($u["username"])."</td></tr>"; } ?>
</table>
<?php } ?></div></div>
</body></html>
