<?php
session_start();
include("db_connect.php");

/* check login */
if (!isset($_SESSION['UserID'])) {
    header("Location: Login.php?error=Please-log-in-first.");
    exit();
}

/* check admin */
if ($_SESSION['UserType'] != "admin") {
    header("Location: Login.php?error=Unauthorized-access.Please-log-in-with-an-admin-account.");
    exit();
}

$adminID = $_SESSION['UserID'];

/* get admin info */
$adminQuery = "SELECT * FROM user WHERE UserID = $adminID";
$adminResult = mysqli_query($conn, $adminQuery);
$admin = mysqli_fetch_assoc($adminResult);

/* get reported recipes in newest report order */
$reportsQuery = "
SELECT report.ReportID, report.RecipeID, recipe.Name, recipe.UserID, user.FirstName, user.LastName, user.ProfilePhoto
FROM report
JOIN recipe ON report.RecipeID = recipe.RecipeID
JOIN user ON recipe.UserID = user.UserID
ORDER BY report.ReportID DESC
";
$reportsResult = mysqli_query($conn, $reportsQuery);

/* get blocked users once only */
$blockedQuery = "
SELECT DISTINCT FirstName, LastName, Email
FROM blockeduser
";
$blockedResult = mysqli_query($conn, $blockedQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramadan's Table | Admin Page</title>

    <link rel="stylesheet" href="../CSS/Main.css">
    <link rel="stylesheet" href="../CSS/Admin.css">
</head>

<body class="AdminPage">

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
    <a href="index.php">Home</a> › <a href="home.php">Entry Page</a> › Admin Page
</div>

<main>

    <div class="AdminTop">
        <span class="WelcomeAdmin">Welcome <?php echo $admin['FirstName']; ?>!</span>
    </div>

    <div class="AdminCard">
        <h2>My Information</h2>
        <p><strong>Name:</strong> <?php echo $admin['FirstName'] . " " . $admin['LastName']; ?></p>
        <p><strong>Email address:</strong> <?php echo $admin['Email']; ?></p>
    </div>

    <div class="AdminCard">
        <h2>Reported Recipes</h2>

        <?php if (mysqli_num_rows($reportsResult) > 0) { ?>
        <table class="RecipeTable">
            <tr>
                <th>Recipe Name</th>
                <th>Recipe Creator</th>
                <th>Action</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($reportsResult)) { ?>
            <tr>
                <td>
                    <a href="ViewRecipe.php?id=<?php echo $row['RecipeID']; ?>" class="RecipeURL">
                        <?php echo $row['Name']; ?>
                    </a>
                </td>
                <td>
                    <img src="../images/<?php echo $row['ProfilePhoto']; ?>" class="CreatorImg" alt="Creator"><br>
                    <?php echo $row['FirstName'] . " " . $row['LastName']; ?>
                </td>
                <td>
                    <form action="review_report.php" method="POST">
                        <input type="hidden" name="recipe_id" value="<?php echo $row['RecipeID']; ?>">
                        <input type="hidden" name="report_id" value="<?php echo $row['ReportID']; ?>">

                        <input type="radio" name="action" value="block" checked> Block User<br>
                        <input type="radio" name="action" value="dismiss"> Dismiss Report<br><br>

                        <button type="submit" class="AdminBtn">Submit</button>
                    </form>
                </td>
            </tr>
            <?php } ?>

        </table>
        <?php } else { ?>
            <p>No reports found.</p>
        <?php } ?>
    </div>

    <div class="AdminCard">
        <h2>Blocked Users List</h2>

        <?php if (mysqli_num_rows($blockedResult) > 0) { ?>
        <table class="RecipeTable BlockedTable">
            <tr>
                <th>Name</th>
                <th>Email Address</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($blockedResult)) { ?>
            <tr>
                <td><?php echo $row['FirstName'] . " " . $row['LastName']; ?></td>
                <td><?php echo $row['Email']; ?></td>
            </tr>
            <?php } ?>

        </table>
        <?php } else { ?>
            <p>No blocked users.</p>
        <?php } ?>
    </div>

    <a href="logout.php" class="LogOutAdmin">Log-out</a>
</main>

<footer>
    <div class="footer-content">
        <p class="copy">© 2026 Ramadan's Table · All rights reserved <br> Contact: info@RamadanTable.sa | +966 50 000 0000 </p>
    </div>
</footer>

</body>
</html>