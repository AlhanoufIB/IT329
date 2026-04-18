<?php
session_start();
include("db_connect.php");

/* check login */
if (!isset($_SESSION['UserID'])) {
    header("Location: Login.php");
    exit();
}

/* get recipe id from URL */
$recipeID = $_GET['id'];
$currentUserID = $_SESSION['UserID'];
$currentUserType = $_SESSION['UserType'];

/* get recipe + creator + category */
$query = "
SELECT recipe.*, user.FirstName, user.LastName, user.ProfilePhoto, recipecategory.CategoryName
FROM recipe
JOIN user ON recipe.UserID = user.UserID
JOIN recipecategory ON recipe.CategoryID = recipecategory.CategoryID
WHERE recipe.RecipeID = $recipeID
";

$result = mysqli_query($conn, $query);
$recipe = mysqli_fetch_assoc($result);

/* get ingredients */
$ingredientsQuery = "SELECT * FROM ingredients WHERE RecipeID = $recipeID";
$ingredientsResult = mysqli_query($conn, $ingredientsQuery);

/* get instructions */
$stepsQuery = "SELECT * FROM instructions WHERE RecipeID = $recipeID ORDER BY StepOrder";
$stepsResult = mysqli_query($conn, $stepsQuery);

/* get comments */
$commentsQuery = "
SELECT comment.*, user.FirstName, user.LastName
FROM comment
JOIN user ON comment.UserID = user.UserID
WHERE comment.RecipeID = $recipeID
ORDER BY comment.date DESC
";
$commentsResult = mysqli_query($conn, $commentsQuery);

/* check if already favourited */
$favouriteQuery = "SELECT * FROM favourites WHERE UserID = $currentUserID AND RecipeID = $recipeID";
$favouriteResult = mysqli_query($conn, $favouriteQuery);
$isFavourite = false;
if (mysqli_num_rows($favouriteResult) > 0) {
    $isFavourite = true;
}

/* check if already liked */
$likeQuery = "SELECT * FROM likes WHERE UserID = $currentUserID AND RecipeID = $recipeID";
$likeResult = mysqli_query($conn, $likeQuery);
$isLiked = false;
if (mysqli_num_rows($likeResult) > 0) {
    $isLiked = true;
}

/* check if already reported */
$reportQuery = "SELECT * FROM report WHERE UserID = $currentUserID AND RecipeID = $recipeID";
$reportResult = mysqli_query($conn, $reportQuery);
$isReported = false;
if (mysqli_num_rows($reportResult) > 0) {
    $isReported = true;
}

/* check if buttons should show */
$showButtons = true;
if ($currentUserID == $recipe['UserID'] || $currentUserType == "admin") {
    $showButtons = false;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $recipe['Name']; ?></title>

  <link rel="stylesheet" href="../CSS/Main.css">
  <link rel="stylesheet" href="../CSS/ViewRecipe.css">
</head>

<body class="ViewRecipePage">

<header>
  <div class="topnav">
    <div class="logo">
      <img src="../images/logo.png" class="logoimg" alt="Logo"> Ramadan's Table
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="MyRecipes.php">My Recipes</a></li>
        <li><a href="AddRecipe.php">Add Recipe</a></li>
        <li><a href="User.php">Account</a></li>
      </ul>
    </nav>
  </div>
</header>

<div class="breadcrumb">
  <a href="index.php">Home</a> ›
  <a href="User.php">User Page</a> ›
  <?php echo $recipe['Name']; ?>
</div>

<main>

<?php if ($showButtons) { ?>
<div class="TopButtons">

  <form action="toggle_favourite.php" method="POST">
    <input type="hidden" name="recipe_id" value="<?php echo $recipeID; ?>">
<button type="submit" class="TopBtn" <?php if ($isFavourite) echo "disabled style='background-color:#cccccc; color:#666666; cursor:not-allowed;'"; ?>>
  ★ Favourite
</button>
  </form>

  <form action="toggle_like.php" method="POST">
    <input type="hidden" name="recipe_id" value="<?php echo $recipeID; ?>">
<button type="submit" class="TopBtn" <?php if ($isLiked) echo "disabled style='background-color:#cccccc; color:#666666; cursor:not-allowed;'"; ?>>
  ♥ Like
</button>
  </form>

  <form action="report_recipe.php" method="POST">
    <input type="hidden" name="recipe_id" value="<?php echo $recipeID; ?>">
<button type="submit" class="TopBtn" <?php if ($isReported) echo "disabled style='background-color:#cccccc; color:#666666; cursor:not-allowed;'"; ?>>
  ⚑ Report
</button>
  </form>

</div>
<?php } ?>

<div class="RecipeMain">
  <h1 class="RecipeName"><?php echo $recipe['Name']; ?></h1>
  <img src="../images/<?php echo $recipe['PhotoFileName']; ?>" class="RecipeBigImg" alt="<?php echo $recipe['Name']; ?>">
</div>

<div class="Card">
  <h2>Recipe Creator</h2>
  <div class="CreatorPart">
    <img src="../images/<?php echo $recipe['ProfilePhoto']; ?>" class="CreatorImg" alt="Creator Image">
    <div class="CreatorInfo">
      <h3><?php echo $recipe['FirstName'] . " " . $recipe['LastName']; ?></h3>
    </div>
  </div>
</div>

<div class="Card">
  <h2>Category & Description</h2>
  <p><strong>Category:</strong> <?php echo $recipe['CategoryName']; ?></p>
  <p><?php echo $recipe['description']; ?></p>
</div>

<div class="Card">
  <h2>Ingredients</h2>
  <ul class="IngredientList">
    <?php while($row = mysqli_fetch_assoc($ingredientsResult)) { ?>
      <li>
        <span><?php echo $row['ingredientName']; ?></span>
        <span class="Qty"><?php echo $row['ingredientQuantity']; ?></span>
      </li>
    <?php } ?>
  </ul>
</div>

<div class="Card">
  <h2>Instructions</h2>
  <ol class="StepsList">
    <?php while($row = mysqli_fetch_assoc($stepsResult)) { ?>
      <li><?php echo $row['Step']; ?></li>
    <?php } ?>
  </ol>
</div>

<?php if ($recipe['VideoPathName'] != "") { ?>
<div class="Card">
  <h2>Video</h2>
  <a class="RecipeURL" href="<?php echo $recipe['VideoPathName']; ?>" target="_blank">Watch Recipe Tutorial on YouTube</a>
</div>
<?php } ?>

<div class="Card">
  <div class="CommentsHeader">
    <h2>Comments</h2>
    <button type="button" id="AddComment" class="AddCommentBtn">+ Add Comment</button>
  </div>

  <div id="CommentsList">
    <?php while($row = mysqli_fetch_assoc($commentsResult)) { ?>
      <div class="CommentBox">
        <div class="CommentTop">
          <strong><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></strong>
          <span class="Description"><?php echo $row['date']; ?></span>
        </div>
        <p><?php echo $row['comment']; ?></p>
      </div>
    <?php } ?>
  </div>
</div>

<?php if ($currentUserType == "admin") { ?>
  <a href="Admin.PHP" class="BackLink">← Back</a>
<?php } else { ?>
  <a href="User.php" class="BackLink">← Back</a>
<?php } ?>

</main>

<div id="CommentModal" class="Modal Hidden">
  <div class="ModalBox">
    <div class="ModalHead">
      <h3>Add a Comment</h3>
      <button type="button" id="CancelModal" class="CancelBtn">Cancel</button>
    </div>

    <form action="add_comment.php" method="POST">
      <input type="hidden" name="recipe_id" value="<?php echo $recipeID; ?>">
      <label for="CommentText">Your comment:</label>
      <textarea id="CommentText" name="comment" rows="4" required></textarea>

      <div class="ModalActions">
        <button type="submit" class="PostBtn">Post</button>
      </div>
    </form>
  </div>
</div>

<script src="/IT329/JS/ViewRecipe.js"></script>
</body>
</html>