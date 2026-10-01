<?php include "../config.php";
if (!isset($_SESSION["user_id"])) { header("Location: ../login.php"); exit; }
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='" . (int)$_SESSION["user_id"] . "'"));
?>
<html><head><title>My Profile - WashWise</title><link rel="stylesheet" href="../style.css"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
<div class="navbar"><div class="logo">WashWise</div><div><a href="dashboard.php">Home</a><a href="profile.php" class="active">Profile</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container" id="main"><div class="card">
<p class="eyebrow">Account</p>
<h2>My Profile</h2>
<span class="accent-bar"></span>
<form action="../process.php?action=update_profile" method="POST">
Name<br><input type="text" name="name" value="<?php echo e($u["name"]); ?>"><br>
Phone<br><input type="text" name="phone" value="<?php echo e($u["phone"]); ?>"><br>
Address<br><textarea name="address"><?php echo e($u["address"]); ?></textarea>
<button class="btn btn-blue" type="submit">Save</button>
</form></div></div>
</body></html>
