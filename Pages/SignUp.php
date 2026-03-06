<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ramadan's Table | Sign-up</title>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/style.css">
  <link rel="stylesheet" href="../CSS/Main.css">
</head>

<body class="headerandfooter auth-page">
<header>
  <div class="topnav">
    <div class="logo">
      <img src="../images/logo.png" alt="Logo" class="logoimg"> Ramadan's Table
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
      </ul>
    </nav>
  </div>
</header>

<div class="breadcrumb">
  <a href="index.php">Home</a> › <a href="home.php">Entry Page</a> › Sign-up
</div>

<main>
  <div class="card">
    <h1>Sign-up</h1>
    <p>All fields are required except profile image.</p>

    <?php if (isset($_GET["exists"])): ?>
      <p class="msg msg-error">This email is already registered.</p>
    <?php elseif (isset($_GET["blocked"])): ?>
      <p class="msg msg-error">This email is blocked.</p>
    <?php elseif (isset($_GET["error"])): ?>
      <p class="msg msg-error">Something went wrong. Please try again.</p>
    <?php endif; ?>

    <form action="signup_process.php" method="POST" enctype="multipart/form-data">
      <label for="fn">First name</label>
      <input type="text" id="fn" name="FirstName" required>

      <label for="ln">Last name</label>
      <input type="text" id="ln" name="LastName" required>

      <label for="img">Profile image (optional)</label>
      <input type="file" id="img" name="ProfileImage" accept="image/*">

      <label for="em">Email address</label>
      <input type="email" id="em" name="Email" required>

      <label for="pw">Password</label>
      <input type="password" id="pw" name="Password" required>

      <button class="btn btn-primary btn-block" type="submit">Create Account</button>

      <div class="form-links">
        Already have an account? <a href="Login.php">Log-in</a>
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