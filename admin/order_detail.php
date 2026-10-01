<?php include "../config.php";
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") { header("Location: ../login.php"); exit; }
$id = $_GET["id"];
$o = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE id='$id'"));
$msgs = mysqli_query($conn, "SELECT * FROM messages WHERE order_id='$id' ORDER BY id ASC");
?>
<html><head><title>Chat Order #<?php echo $id; ?></title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="navbar"><div class="logo">WashWise Admin</div><div><a href="orders.php">Back</a></div></div>
<div class="container"><div class="card"><h3>Chat for Order #<?php echo $id; ?></h3>
<div id="chat">
<?php while($m=mysqli_fetch_assoc($msgs)){ echo "<p><b>".htmlspecialchars($m["sender"]).":</b> ".htmlspecialchars($m["message"])." <a href='../process.php?action=delete_message&id=".$m["id"]."&order_id=".$id."' onclick='return confirm(\"Delete this message?\")' style='color:red;font-size:13px;'>Delete</a></p>"; } ?>
</div>
<form id="chatForm" action="/project/process.php?action=send_message" method="POST">
<input type="hidden" name="order_id" value="<?php echo $id; ?>">
<textarea name="message" id="msgInput" required></textarea>
<button class="btn btn-blue" type="submit">Reply</button>
</form></div></div>
<script>
// reply without refresh (simple AJAX)
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
