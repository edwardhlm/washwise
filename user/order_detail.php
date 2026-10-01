<?php include "../config.php";
if (!isset($_SESSION["user_id"])) { header("Location: ../login.php"); exit; }
$id = $_GET["id"];
$o = mysqli_fetch_assoc(mysqli_query($conn, "SELECT orders.*, services.name as sname FROM orders JOIN services ON orders.service_id=services.id WHERE orders.id='$id'"));
// safety: customer can only open their own order
if (!$o || ($o["user_id"] != $_SESSION["user_id"] && $_SESSION["role"] != "admin")) { header("Location: my_orders.php"); exit; }
$msgs = mysqli_query($conn, "SELECT * FROM messages WHERE order_id='$id' ORDER BY id ASC");
?>
<html><head><title>Order Detail</title><link rel="stylesheet" href="../style.css"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
<div class="navbar"><div class="logo">WashWise</div><div><a href="my_orders.php">Back</a><a href="../process.php?action=logout">Logout</a></div></div>
<div class="container">
<div class="card"><h2>Order #<?php echo $o["id"]; ?> - <?php echo $o["sname"]; ?></h2>
<p>Weight: <?php echo $o["weight"]; ?> kg | Total: Rp <?php echo $o["total_price"]; ?></p>
<p>Status: <span class="badge b-<?php echo $o["status"]; ?>"><?php echo $o["status"]; ?></span></p>
<p>Notes: <?php echo $o["notes"]; ?></p></div>
<div class="card"><h3>Messages with Admin</h3>
<div id="chat">
<?php while($m=mysqli_fetch_assoc($msgs)){ echo "<p><b>".htmlspecialchars($m["sender"]).":</b> ".htmlspecialchars($m["message"])."</p>"; } ?>
</div>
<form id="chatForm" action="/project/process.php?action=send_message" method="POST">
<input type="hidden" name="order_id" value="<?php echo $id; ?>">
<textarea name="message" id="msgInput" required placeholder="Write message..."></textarea>
<button class="btn btn-blue" type="submit">Send</button>
</form></div>
</div>
<script>
// send message without refresh (simple AJAX)
document.getElementById("chatForm").addEventListener("submit", function(e) {
  e.preventDefault();
  var form = this;
  var text = document.getElementById("msgInput").value;
  if (text == "") { return; }
  var data = new FormData(form);
  data.append("ajax", "1");
  fetch(form.action + "&ajax=1", { method: "POST", body: data })
    .then(function(res) { return res.json(); })
    .then(function(out) {
      if (out.ok) {
        var div = document.getElementById("chat");
        var p = document.createElement("p");
        p.innerHTML = "<b>" + out.sender + ":</b> " + out.message.replace(/</g, "&lt;");
        div.appendChild(p);
        document.getElementById("msgInput").value = "";
      } else {
        alert("Failed to send, reloading...");
        window.location.reload();
      }
    })
    .catch(function() { form.submit(); });
});
</script>
</body></html>
