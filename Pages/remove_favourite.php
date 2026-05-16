<?php
session_start();
include 'db_connect.php';

$userID = $_SESSION['UserID'];
$recipeID = intval($_GET['recipeID']);

$query = "DELETE FROM Favourites WHERE UserID = $userID AND RecipeID = $recipeID";
$result = mysqli_query($conn, $query);

echo $result ? 'true' : 'false';
?>