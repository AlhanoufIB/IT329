<?php
session_start();

$conn = new mysqli("localhost", "root", "root", "recipesystem");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['id'])) {
    $_SESSION['id'] = 1;
}

$userId = $_SESSION['id'];

if (isset($_GET['delete'])) {
    $recipeId = (int) $_GET['delete'];

    $checkSql = "SELECT PhotoFileName, VideoPathName FROM recipe WHERE RecipeID = ? AND UserID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $recipeId, $userId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $recipeData = $checkResult->fetch_assoc();

        $tables = ["ingredients", "instructions", "comment", "likes", "favourites", "report"];
        foreach ($tables as $table) {
            $deleteRelated = $conn->prepare("DELETE FROM $table WHERE RecipeID = ?");
            $deleteRelated->bind_param("i", $recipeId);
            $deleteRelated->execute();
        }

        $deleteRecipe = $conn->prepare("DELETE FROM recipe WHERE RecipeID = ? AND UserID = ?");
        $deleteRecipe->bind_param("ii", $recipeId, $userId);
        $deleteRecipe->execute();

        if (!empty($recipeData['PhotoFileName'])) {
            $photoPath = "../images/" . $recipeData['PhotoFileName'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        if (!empty($recipeData['VideoPathName'])) {
            $videoPath = "../videos/" . $recipeData['VideoPathName'];
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
        }
    }

    header("Location: MyRecipes.php");
    exit();
}


$sql = "
    SELECT 
        r.RecipeID,
        r.Name,
        r.description,
        r.PhotoFileName,
        r.VideoPathName,
        COUNT(DISTINCT l.UserID) AS totalLikes
    FROM recipe r
    LEFT JOIN likes l ON r.RecipeID = l.RecipeID
    WHERE r.UserID = ?
    GROUP BY r.RecipeID, r.Name, r.description, r.PhotoFileName, r.VideoPathName
    ORDER BY r.RecipeID DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

/* ===== Total Recipes ===== */
$totalRecipes = 0;
$totalRecipesSql = "SELECT COUNT(*) AS totalRecipes FROM recipe WHERE UserID = ?";
$totalRecipesStmt = $conn->prepare($totalRecipesSql);
$totalRecipesStmt->bind_param("i", $userId);
$totalRecipesStmt->execute();
$totalRecipesResult = $totalRecipesStmt->get_result();
if ($row = $totalRecipesResult->fetch_assoc()) {
    $totalRecipes = $row['totalRecipes'];
}

/* ===== Total Likes ===== */
$totalLikes = 0;
$totalLikesSql = "
    SELECT COUNT(*) AS totalLikes
    FROM likes l
    INNER JOIN recipe r ON l.RecipeID = r.RecipeID
    WHERE r.UserID = ?
";
$totalLikesStmt = $conn->prepare($totalLikesSql);
$totalLikesStmt->bind_param("i", $userId);
$totalLikesStmt->execute();
$totalLikesResult = $totalLikesStmt->get_result();
if ($row = $totalLikesResult->fetch_assoc()) {
    $totalLikes = $row['totalLikes'];
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ramadan's Table | My Recipes</title>
  <link rel="stylesheet" href="../CSS/Main.css">
  <link rel="stylesheet" href="../CSS/MyRecipes.css">
</head>

<body>
  <div class="container">
    <header>
      <div class="topnav">
        <div class="logo">
          <img src="../images/logo.png" alt="Logo" class="logoimg">
          Ramadan's Table
        </div>

        <nav>
          <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="MyRecipes.php">My Recipes</a></li>
            <li><a href="AddRecipe.php">Add Recipe</a></li>
            <li><a href="User.php">Account</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <div class="breadcrumb">
      <a href="index.php">Home</a> › <a href="User.php">User Page</a> › My Recipes
    </div>

    <main>
      <div class="page-header">
        <h2>My Recipes</h2>
        <a href="AddRecipe.php" class="btn btn-primary">+ Add New Recipe</a>
      </div>

      <?php if ($result->num_rows > 0): ?>
        <div class="recipes-table-container">
          <table class="recipes-table">
            <thead>
              <tr>
                <th>Recipe</th>
                <th>Description</th>
                <th>Video</th>
                <th>Likes</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td>
                    <div class="recipe-info">
                      <?php
                        $photo = !empty($row['PhotoFileName'])
                          ? "../images/" . htmlspecialchars($row['PhotoFileName'])
                          : "../images/default.png";
                      ?>

                      <a href="ViewRecipe.php?id=<?php echo $row['RecipeID']; ?>">
                        <img src="<?php echo $photo; ?>" alt="<?php echo htmlspecialchars($row['Name']); ?>" class="recipe-thumb">
                      </a>

                      <a href="ViewRecipe.php?id=<?php echo $row['RecipeID']; ?>" class="recipe-name">
                        <?php echo htmlspecialchars($row['Name']); ?>
                      </a>
                    </div>
                  </td>

                  <td><?php echo htmlspecialchars($row['description']); ?></td>

                  <td>
                    <?php if (!empty($row['VideoPathName'])): ?>
                      <a href="../videos/<?php echo htmlspecialchars($row['VideoPathName']); ?>" target="_blank" class="video-link">
                        ▶ Watch Video
                      </a>
                    <?php else: ?>
                      No Video
                    <?php endif; ?>
                  </td>

                  <td class="likes-count"><?php echo $row['totalLikes']; ?></td>

                  <td>
                    <a href="EditRecipe.php?id=<?php echo $row['RecipeID']; ?>" class="btn btn-edit">Edit</a>
                  </td>

                  <td>
                    <a href="MyRecipes.php?delete=<?php echo $row['RecipeID']; ?>"
                       class="btn btn-delete"
                       onclick="return confirm('Are you sure you want to delete this recipe?');">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="no-recipes-message">
          <p>You have not added any recipes yet.</p>
        </div>
      <?php endif; ?>

      <div class="stats-summary">
        <div class="stat-card">
          <h3>Total Recipes</h3>
          <p class="stat-number"><?php echo $totalRecipes; ?></p>
        </div>

        <div class="stat-card">
          <h3>Total Likes</h3>
          <p class="stat-number"><?php echo $totalLikes; ?></p>
        </div>
      </div>
    </main>

    <footer>
      <div class="footer-content">
        <p class="copy">© 2026 Ramadan's Table · All rights reserved <br> Contact: info@RamadanTable.sa | +966 50 000 0000 </p>
      </div>
    </footer>
  </div>
</body>
</html>