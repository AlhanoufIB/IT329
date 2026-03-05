<?php
session_start();
include 'db_connect.php';

$userID = $_SESSION['user_id'];
$recipeID = $_GET['recipeID'];

$query = "DELETE FROM Favourites WHERE userID =$userID  AND recipeID = $recipeID";
$result = mysqli_query($conn, $query);


header("Location: User.php");
exit();
?>
