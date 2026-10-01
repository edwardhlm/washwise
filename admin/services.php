<?php include "../config.php";
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
// if edit id is set, load that service for the edit form
$edit = null;
if (isset($_GET["edit"])) {
  $eid = (int) $_GET["edit"];
  $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM services WHERE id='$eid'"));
}
$q = mysqli_query($conn, "SELECT * FROM services");
?>
<html><head><title>Services</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="navbar"><div class="logo">WashWise Admin</div><div><a href="dashboard.php">Dashboard</a><a href="orders.php">Orders</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container">
<?php if ($edit) { ?>
<div class="card"><h2>Edit Service #<?php echo (int) $edit["id"]; ?></h2>
<form action="../process.php?action=edit_service" method="POST">
<input type="hidden" name="id" value="<?php echo (int) $edit["id"]; ?>">
Name<br><input type="text" name="name" value="<?php echo e($edit["name"]); ?>" required><br>
Price per kg<br><input type="number" name="price_per_kg" value="<?php echo (int) $edit["price_per_kg"]; ?>" required><br>
Description<br><input type="text" name="description" value="<?php echo e($edit["description"]); ?>"><br>
<button class="btn btn-blue" type="submit">Update</button>
<a href="services.php" class="btn btn-beige">Cancel</a></form></div>
<?php } else { ?>
<div class="card"><h2>Add Service</h2>
<form action="../process.php?action=add_service" method="POST">
Name<br><input type="text" name="name" required><br>
Price per kg<br><input type="number" name="price_per_kg" required><br>
Description<br><input type="text" name="description"><br>
<button class="btn btn-blue" type="submit">Add</button></form></div>
<?php } ?>
<div class="card"><h2>Service List</h2>
<table><tr><th>Name</th><th>Price</th><th>Action</th></tr>
<?php while($s=mysqli_fetch_assoc($q)){
echo "<tr><td>".e($s["name"])."</td><td class='price'>Rp ".(int)$s["price_per_kg"]."</td><td><a href='services.php?edit=".(int)$s["id"]."'>Edit</a> | <a href='../process.php?action=delete_service&id=".(int)$s["id"]."' onclick='return confirm(\"Delete?\")'>Delete</a></td></tr>";
} ?>
</table></div>
</div>
</body></html>
