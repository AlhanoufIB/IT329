<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_connect.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: Login.php?error=Please-log-in-to-access-your-account.");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: MyRecipes.php");
    exit();
}

$recipeID = $_GET['id'];

// Fetch recipe to get file names before deleting
$result = $conn->query("SELECT * FROM recipe WHERE RecipeID = $recipeID");
if (!$result || $result->num_rows === 0) {
    header("Location: MyRecipes.php");
    exit();
}
$recipe = $result->fetch_assoc();

// Delete all associated data
$conn->query("DELETE FROM ingredients WHERE RecipeID = $recipeID");
$conn->query("DELETE FROM instructions WHERE RecipeID = $recipeID");
$conn->query("DELETE FROM comment WHERE RecipeID = $recipeID");
$conn->query("DELETE FROM likes WHERE RecipeID = $recipeID");
$conn->query("DELETE FROM favourites WHERE RecipeID = $recipeID");
$conn->query("DELETE FROM report WHERE RecipeID = $recipeID");

// Delete the recipe itself
$conn->query("DELETE FROM recipe WHERE RecipeID = $recipeID");

// Delete photo from server
if (!empty($recipe['PhotoFileName'])) {
    unlink('../images/' . $recipe['PhotoFileName']);
}

// Delete video from server (only if it's a file, not a URL)
if (!empty($recipe['VideoPathName']) && !str_starts_with($recipe['VideoPathName'], 'http')) {
    unlink('../videos/' . $recipe['VideoPathName']);
}

header("Location: MyRecipes.php");
exit();
?>