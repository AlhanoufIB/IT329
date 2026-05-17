<?php
session_start();
include("db_connect.php");


if (!isset($_SESSION['UserID'])) {
    header("Location: Login.php");
    exit();
}


$recipeID = $_GET['id'];
$currentUserID = $_SESSION['UserID'];
$currentUserType = $_SESSION['UserType'];


$query = "
SELECT recipe.*, user.FirstName, user.LastName, user.ProfilePhoto, recipecategory.CategoryName
FROM recipe
JOIN user ON recipe.UserID = user.UserID
JOIN recipecategory ON recipe.CategoryID = recipecategory.CategoryID
WHERE recipe.RecipeID = $recipeID";

$result = mysqli_query($conn, $query);
$recipe = mysqli_fetch_assoc($result);


$ingredientsQuery = "SELECT * FROM ingredients WHERE RecipeID = $recipeID";
$ingredientsResult = mysqli_query($conn, $ingredientsQuery);


$stepsQuery = "SELECT * FROM instructions WHERE RecipeID = $recipeID ORDER BY StepOrder";
$stepsResult = mysqli_query($conn, $stepsQuery);

$commentsQuery = "
SELECT comment.*, user.FirstName, user.LastName
FROM comment
JOIN user ON comment.UserID = user.UserID
WHERE comment.RecipeID = $recipeID
ORDER BY comment.date DESC
";
$commentsResult = mysqli_query($conn, $commentsQuery);


$favouriteQuery = "SELECT * FROM favourites WHERE UserID = $currentUserID AND RecipeID = $recipeID";
$favouriteResult = mysqli_query($conn, $favouriteQuery);
$isFavourite = false;
if (mysqli_num_rows($favouriteResult) > 0) {
    $isFavourite = true;
}


$likeQuery = "SELECT * FROM likes WHERE UserID = $currentUserID AND RecipeID = $recipeID";
$likeResult = mysqli_query($conn, $likeQuery);
$isLiked = false;
if (mysqli_num_rows($likeResult) > 0) {
    $isLiked = true;
}

$reportQuery = "SELECT * FROM report WHERE UserID = $currentUserID AND RecipeID = $recipeID";
$reportResult = mysqli_query($conn, $reportQuery);
$isReported = false;
if (mysqli_num_rows($reportResult) > 0) {
    $isReported = true;
}


$showButtons = true;
if ($currentUserID == $recipe['UserID'] || $currentUserType == "admin") {
    $showButtons = false;
}


$videoPath = $recipe['VideoPathName'];
$isURL = false;
$isVideo = false;

if ($videoPath != "") {
    if (str_starts_with($videoPath, "http://") || str_starts_with($videoPath, "https://")) {
        $isURL = true;
    } else {
        $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
        $ext = strtolower(pathinfo($videoPath, PATHINFO_EXTENSION));
        if (in_array($ext, $videoExtensions)) {
            $isVideo = true;
        }
    }
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
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $(document).ready(function () {

    // Favourite Button
    $("#FavouriteBtn").click(function () {
        var recipeID = $(this).data("id");

        $.ajax({
            type: "POST",
            url: "toggle_favourite.php",
            data: { recipe_id: recipeID },
            success: function (response) {
                if (response.trim() === "true") {
                    $("#FavouriteBtn").prop("disabled", true);
                    $("#FavouriteBtn").css({
                        "background-color": "#cccccc",
                        "color": "#666666",
                        "cursor": "not-allowed"
                    });
                }
            }
        });
    });


    // Like Button
    $("#LikeBtn").click(function () {
        var recipeID = $(this).data("id");

        $.ajax({
            type: "POST",
            url: "toggle_like.php",
            data: { recipe_id: recipeID },
            success: function (response) {
                if (response.trim() === "true") {
                    $("#LikeBtn").prop("disabled", true);
                    $("#LikeBtn").css({
                        "background-color": "#cccccc",
                        "color": "#666666",
                        "cursor": "not-allowed"
                    });
                }
            }
        });
    });


    // Report Button
    $("#ReportBtn").click(function () {
        var recipeID = $(this).data("id");

        $.ajax({
            type: "POST",
            url: "report_recipe.php",
            data: { recipe_id: recipeID },
            success: function (response) {
                if (response.trim() === "true") {
                    $("#ReportBtn").prop("disabled", true);
                    $("#ReportBtn").css({
                        "background-color": "#cccccc",
                        "color": "#666666",
                        "cursor": "not-allowed"
                    });
                }
            }
        });
    });


    // Comment Modal
    $("#AddComment").click(function () {
        $("#CommentModal").removeClass("Hidden");
    });

    $("#CancelModal").click(function () {
        $("#CommentModal").addClass("Hidden");
        $("#CommentText").val("");
    });


    // Post Comment
    $("#PostComment").click(function () {
        var comment = $("#CommentText").val().trim();
        var recipeID = $("#CommentRecipeID").val();

        if (comment === "") {
            alert("Please write a comment before posting.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "add_comment.php",
            data: { recipe_id: recipeID, comment: comment },
            success: function (response) {
                if (response.trim() === "true") {
                    $("#CommentModal").addClass("Hidden");
                    $("#CommentText").val("");
                    location.reload();
                }
            }
        });
    });

});
  </script>
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

  <button type="button" id="FavouriteBtn" class="TopBtn" data-id="<?php echo $recipeID; ?>"
    <?php if ($isFavourite) echo "disabled style='background-color:#cccccc; color:#666666; cursor:not-allowed;'"; ?>>
    ★ Favourite
  </button>

  <button type="button" id="LikeBtn" class="TopBtn" data-id="<?php echo $recipeID; ?>"
    <?php if ($isLiked) echo "disabled style='background-color:#cccccc; color:#666666; cursor:not-allowed;'"; ?>>
    ♥ Like
  </button>

  <button type="button" id="ReportBtn" class="TopBtn" data-id="<?php echo $recipeID; ?>"
    <?php if ($isReported) echo "disabled style='background-color:#cccccc; color:#666666; cursor:not-allowed;'"; ?>>
    ⚑ Report
  </button>

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

<?php if ($isURL) { ?>
<div class="Card">
  <h2>Video</h2>
  <a class="RecipeURL" href="<?php echo $videoPath; ?>" target="_blank">Watch Recipe Tutorial on YouTube</a>
</div>

<?php } elseif ($isVideo) { ?>
<div class="Card">
  <h2>Video</h2>
  <video class="RecipeVideo" controls>
    <source src="../videos/<?php echo $videoPath; ?>" type="video/<?php echo strtolower(pathinfo($videoPath, PATHINFO_EXTENSION)); ?>">
    Your browser does not support the video tag.
  </video>
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

    <textarea id="CommentText" name="comment" rows="4" placeholder="Your comment..."></textarea>
    <input type="hidden" id="CommentRecipeID" value="<?php echo $recipeID; ?>">

    <div class="ModalActions">
      <button type="button" id="PostComment" class="PostBtn">Post</button>
    </div>
  </div>
</div>



</body>
</html>