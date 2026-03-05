<?php
// Login.php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ramadan's Table | Log-in</title>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/style.css">
</head>

<body class="headerandfooter">
<header>
  <div class="topnav">
    <div class="logo"><img src="images/logo.png" alt="Logo" class="logoimg"> Ramadan's Table</div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
      </ul>
    </nav>
  </div>
</header>

<div class="breadcrumb">
  <a href="index.php">Home</a> › <a href="home.php">Entry Page</a> › Log-in
</div>

<main>
  <div class="card">
    <h1>Log-in</h1>

    <?php if (isset($_GET["error"])): ?>
      <p class="msg msg-error">Wrong email or password.</p>
    <?php endif; ?>

    <form action="login_process.php" method="POST">
      <label for="email">Email address</label>
      <input type="email" id="email" name="email" placeholder="name@email.com" required>

      <label for="pass">Password</label>
      <input type="password" id="pass" name="password" placeholder="********" required>

      <!-- No JS: two submit buttons decide the target role -->
      <div class="btn-row">
        <button class="btn btn-primary" type="submit" name="loginType" value="user">Login as User</button>
      </div>

      <div class="form-links">
        New user? <a href="SignUp.php">Sign-up</a>
      </div>
    </form>
  </div>
</main>

<footer>
  <div class="footer-content">
    <p class="copy">© 2026 Ramadan's Table · All rights reserved <br> Contact: info@RamadanTable.sa | +966 50 000 0000</p>
  </div>
</footer>
</body>
</html>