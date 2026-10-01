<?php include "../config.php";
if (!isset($_SESSION["user_id"])) { header("Location: ../login.php"); exit; }
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='".$_SESSION["user_id"]."'"));
?>
<html><head><title>Profile</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="navbar"><div class="logo">WashWise</div><div><a href="dashboard.php">Home</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container"><div class="card">
<h2>My Profile</h2>
<form action="../process.php?action=update_profile" method="POST">
Name<br><input type="text" name="name" value="<?php echo $u["name"]; ?>"><br>
Phone<br><input type="text" name="phone" value="<?php echo $u["phone"]; ?>"><br>
Address<br><textarea name="address"><?php echo $u["address"]; ?></textarea>
<button class="btn btn-blue" type="submit">Save</button>
</form></div></div>
</body></html>
