<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['UserID'])) {
    header("Location: Login.php");
    exit();
}

$recipeID = $_POST['recipe_id'];
$userID = $_SESSION['UserID'];

/* check if already liked */
$checkQuery = "SELECT * FROM likes WHERE UserID = $userID AND RecipeID = $recipeID";
$checkResult = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($checkResult) == 0) {
    $query = "INSERT INTO likes (UserID, RecipeID) VALUES ($userID, $recipeID)";
    mysqli_query($conn, $query);
}

header("Location: ViewRecipe.php?id=$recipeID");
exit();
?>