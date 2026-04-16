<?php
require_once 'my_recipes_backend.php';
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

      <div class="recipes-table-container">
        <table class="recipes-table">
          <thead>
            <tr>
              <th>Recipe</th>
              <th>Ingredients</th>
              <th>Instructions</th>
              <th>Video</th>
              <th>Likes</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>

          <tbody>
            <?php if (empty($recipe_data['recipes'])): ?>
            <tr>
              <td colspan="7" style="text-align: center; padding: 40px;">
                <p>You haven't added any recipes yet.</p>
                <a href="AddRecipe.php" class="btn btn-primary">Add Your First Recipe</a>
              </td>
            </tr>
            <?php else: ?>
              <?php foreach ($recipe_data['recipes'] as $recipe): ?>
              <tr>
                <td>
                  <div class="recipe-info">
                    <?php 
                    $image_path = !empty($recipe['PhotoFileName']) 
                      ? "../images/" . htmlspecialchars($recipe['PhotoFileName']) 
                      : "../images/default-recipe.jpg";
                    ?>
                    <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($recipe['Name']); ?>" class="recipe-thumb" />
                    <a href="ViewRecipe.php?id=<?php echo $recipe['RecipeID']; ?>" class="recipe-name"><?php echo htmlspecialchars($recipe['Name']); ?></a>
                  </div>
                </td>
                <td>
                  <ul class="ingredients-list">
                    <?php if (empty($recipe['ingredients'])): ?>
                      <li>No ingredients added</li>
                    <?php else: ?>
                      <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                        <li><?php echo htmlspecialchars($ingredient['ingredientName']); ?><?php echo !empty($ingredient['ingredientQuantity']) ? ' - ' . htmlspecialchars($ingredient['ingredientQuantity']) : ''; ?></li>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </ul>
                </td>
                <td>
                  <ol class="instructions-list">
                    <?php if (empty($recipe['instructions'])): ?>
                      <li>No instructions added</li>
                    <?php else: ?>
                      <?php foreach ($recipe['instructions'] as $instruction): ?>
                        <li><?php echo htmlspecialchars($instruction); ?></li>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </ol>
                </td>
                <td>
                  <?php if (!empty($recipe['VideoPathName'])): ?>
                    <?php 
                    // Check if it's a URL or a file path
                    $videoLink = $recipe['VideoPathName'];
                    if (!filter_var($videoLink, FILTER_VALIDATE_URL)) {
                      // It's a file, prepend the videos directory
                      $videoLink = "../videos/" . $videoLink;
                    }
                    ?>
                    <a href="<?php echo htmlspecialchars($videoLink); ?>" target="_blank" class="video-link" rel="noopener">
                      ▶ Watch Video
                    </a>
                  <?php else: ?>
                    <span style="color: #999;">No video</span>
                  <?php endif; ?>
                </td>
                <td class="likes-count"><?php echo $recipe['likes_count']; ?></td>
                <td>
                  <a href="EditRecipe.php?id=<?php echo $recipe['RecipeID']; ?>" class="btn btn-edit">Edit</a>
                </td>
                <td>
                  <button class="btn btn-delete" onclick="deleteRecipe(<?php echo $recipe['RecipeID']; ?>)">Delete</button>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="stats-summary">
        <div class="stat-card">
          <h3>Total Recipes</h3>
          <p class="stat-number"><?php echo $recipe_data['total_recipes']; ?></p>
        </div>
        <div class="stat-card">
          <h3>Total Likes</h3>
          <p class="stat-number"><?php echo number_format($recipe_data['total_likes']); ?></p>
        </div>
      </div>
    </main>

        <footer>
  <div class="footer-content">
    <p class="copy">© 2026 Ramadan's Table · All rights reserved <br> Contact: info@RamadanTable.sa | +966 50 000 0000</p>
  </div>
</footer>
  </div>

  <script>
  function deleteRecipe(recipeId) {
    if (confirm('Are you sure you want to delete this recipe? This action cannot be undone.')) {
      const formData = new FormData();
      formData.append('recipe_id', recipeId);
      
      fetch('delete_recipe.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Recipe deleted successfully!');
          location.reload();
        } else {
          alert('Error: ' + (data.error || 'Failed to delete recipe'));
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the recipe.');
      });
    }
  }
  </script>
</body>
</html>
