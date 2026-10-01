<html>
<head><title>Login - WashWise</title><link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
<div class="navbar"><div class="logo">WashWise Laundry</div><div><a href="index.php">Home</a><a href="register.php">Register</a></div></div>
<div class="container">
<div class="card">
<h2>Login</h2>
<form action="process.php?action=login" method="POST" onsubmit="return checkLogin()">
Username<br><input type="text" name="username" id="u" required><br>
Password<br><input type="password" name="password" id="p" required><br>
<button class="btn btn-blue" type="submit">Login</button>
<a href="register.php" class="btn btn-beige">Register</a>
</form>
<p>Admin demo: create user with role admin in phpMyAdmin, or run: INSERT INTO users(name,username,password,role) VALUES('Admin','admin','...','admin')</p>
</div>
</div>
<script>
function checkLogin() {
  if (document.getElementById("u").value == "" || document.getElementById("p").value == "") {
    alert("Please fill all fields");
    return false;
  }
  return true;
}
</script>
</body>
</html>
