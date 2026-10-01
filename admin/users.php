<?php include "../config.php";
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
$q = mysqli_query($conn, "SELECT * FROM users WHERE role='customer'");
?>
<html><head><title>Users</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="navbar"><div class="logo">WashWise Admin</div><div><a href="dashboard.php">Dashboard</a><a href="orders.php">Orders</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container"><div class="card"><h2>Customers</h2>
<table><tr><th>Name</th><th>Phone</th><th>Address</th><th>Username</th></tr>
<?php while($u=mysqli_fetch_assoc($q)){ echo "<tr><td>".$u["name"]."</td><td>".$u["phone"]."</td><td>".$u["address"]."</td><td>".$u["username"]."</td></tr>"; } ?>
</table></div></div>
</body></html>
