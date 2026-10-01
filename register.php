<html>
<head><title>Register - WashWise</title><link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body>
<div class="navbar"><div class="logo">WashWise Laundry</div><div><a href="index.php">Home</a><a href="login.php">Login</a></div></div>
<div class="container">
<div class="card">
<h2>Register</h2>
<form action="process.php?action=register" method="POST">
Name<br><input type="text" name="name" required><br>
Phone<br><input type="text" name="phone" required><br>
Address<br><textarea name="address" required></textarea>
Username<br><input type="text" name="username" required><br>
Password<br><input type="password" name="password" required><br>
<button class="btn btn-blue" type="submit">Register</button>
</form>
</div>
</div>
</body>
</html>
