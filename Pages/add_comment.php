<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['UserID'])) {
    header("Location: Login.php");
    exit();
}

if (!isset($_POST['recipe_id']) || !isset($_POST['comment'])) {
    header("Location: User.php");
    exit();
}

$recipeID = $_POST['recipe_id'];
$userID = $_SESSION['UserID'];
$comment = trim($_POST['comment']);

if ($comment == "") {
    header("Location: ViewRecipe.php?id=$recipeID");
    exit();
}

$query = "INSERT INTO comment (RecipeID, UserID, comment, date)
          VALUES ($recipeID, $userID, '$comment', NOW())";

mysqli_query($conn, $query);

header("Location: ViewRecipe.php?id=$recipeID");
exit();
?>