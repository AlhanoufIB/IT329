<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ramadan's Table | Sign-up</title>

  <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/Main.css">
    
</head>

<body class="headerandfooter">
<header>
  <div class="topnav">
    <div class="logo"><img src="images/logo.png" class="logoimg" alt=""> Ramadan's Table</div>
    <nav><ul><li><a href="index.php">Home</a></li></ul></nav>
  </div>
</header>

<main>
  <div class="card">
    <h1>Sign-up</h1>

    <?php if (isset($_GET["exists"])): ?>
      <p class="msg msg-error">This email is already registered.</p>
    <?php endif; ?>

    <form action="signup_process.php" method="POST" enctype="multipart/form-data">
      <label>First name</label>
      <input type="text" name="FirstName" required>

      <label>Last name</label>
      <input type="text" name="LastName" required>

      <label>Profile image (optional)</label>
      <input type="file" name="ProfileImage" accept="image/*">

      <label>Email</label>
      <input type="email" name="Email" required>

      <label>Password</label>
      <input type="password" name="Password" required>

      <button class="btn btn-primary btn-block" type="submit">Create Account</button>

      <div class="form-links">
        Already have an account? <a href="Login.php">Log-in</a>
      </div>
    </form>
  </div>
</main>
</body>
</html>