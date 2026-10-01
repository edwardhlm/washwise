<?php include "../config.php";
if (!isset($_SESSION["user_id"])) { header("Location: ../login.php"); exit; }
$services = mysqli_query($conn, "SELECT * FROM services");
?>
<html><head><title>New Order</title><link rel="stylesheet" href="../style.css"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
<div class="navbar"><div class="logo">WashWise</div><div><a href="dashboard.php">Home</a><a href="my_orders.php">My Orders</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container"><div class="card">
<h2>New Order</h2>
<form action="../process.php?action=add_order" method="POST">
Service<br>
<select name="service_id" id="svc" onchange="calc()" required>
<?php while($s=mysqli_fetch_assoc($services)){ echo "<option value='".$s["id"]."' data-price='".$s["price_per_kg"]."'>".$s["name"]." - Rp ".$s["price_per_kg"]."/kg</option>"; } ?>
</select>
Weight (kg estimate)<br><input type="number" step="0.5" min="1" name="weight" id="w" value="1" oninput="calc()" required><br>
<p>Estimated total: <b id="total">Rp 0</b></p>
Type<br><select name="service_type"><option value="pickup">Pickup + Delivery</option><option value="dropoff">Drop-off</option></select>
Pickup date<br><input type="date" name="pickup_date"><br>
Pickup address<br><textarea name="pickup_address"></textarea>
Notes for admin<br><textarea name="notes" placeholder="ex: separate white clothes"></textarea>
<button class="btn btn-blue" type="submit">Submit Order</button>
</form>
</div></div>
<script>
function calc(){
  var sel = document.getElementById("svc");
  var price = sel.options[sel.selectedIndex].getAttribute("data-price");
  var w = document.getElementById("w").value;
  document.getElementById("total").innerText = "Rp " + (price * w);
}
calc();
</script>
</body></html>
