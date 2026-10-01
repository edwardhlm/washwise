<?php include "../config.php";
if (!isset($_SESSION["user_id"])) { header("Location: ../login.php"); exit; }
$id = (int) $_SESSION["user_id"];
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM orders WHERE user_id='$id'"))["c"];
$wait = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM orders WHERE user_id='$id' AND status!='Delivered'"))["c"];
$points = floor($total / 5);
?>
<html><head><title>Dashboard - WashWise</title><link rel="stylesheet" href="../style.css"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
<div class="navbar"><div class="logo">WashWise - <?php echo e($_SESSION["name"]); ?></div>
<div><a href="dashboard.php" class="active">Home</a><a href="new_order.php">New Order</a><a href="my_orders.php">My Orders</a><a href="profile.php">Profile</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container">
<div class="card">
<p class="eyebrow">Where Your Laundry Belongs</p>
<h2>Hello, <?php echo e($_SESSION["name"]); ?>!</h2>
<span class="accent-bar"></span>
<p style="color:var(--muted);">Semua kebutuhan laundry Anda di satu tempat. Pesan, lacak, dan chat admin langsung.</p>
<img src="../img/machines.jpg" alt="Our washroom machines" class="hero-img">
<div class="stat-grid">
<div class="stat-card light"><div class="num"><?php echo $total; ?></div><div class="lbl">Total Orders</div></div>
<div class="stat-card"><div class="num"><?php echo $wait; ?></div><div class="lbl">Active</div></div>
<div class="stat-card light"><div class="num"><?php echo $points; ?></div><div class="lbl">Points</div></div>
</div>
<p style="font-size:13px;color:var(--faint);">1 point every 5 orders - kami melayani dengan sepenuh hati.</p>
<a href="new_order.php" class="btn btn-blue">Pesan Penjemputan -></a>
<a href="my_orders.php" class="btn btn-beige">Lihat Pesanan</a>
</div>
</div>
</body></html>
