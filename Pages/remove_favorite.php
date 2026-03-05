<?php
session_start();
include 'db_connect.php';

$userID = $_SESSION['UserID'];
$recipeID = $_GET['recipeID'];

$query = "DELETE FROM Favourites WHERE UserID =$userID  AND recipeID = $recipeID";
$result = mysqli_query($conn, $query);


header("Location: User.php");
exit();
?>
