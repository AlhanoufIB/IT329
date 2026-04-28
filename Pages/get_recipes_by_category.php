<?php
session_start();
include 'db_connect.php';

$categoryID = isset($_GET['categoryID']) ? intval($_GET['categoryID']) : 0;

if ($categoryID == 0) {
    $query = "SELECT r.*, u.FirstName, u.LastName, u.ProfilePhoto as userPhoto,
              c.CategoryName, COUNT(l.UserID) as likeCount
              FROM recipe r
              JOIN user u ON r.UserID = u.UserID
              JOIN recipecategory c ON r.CategoryID = c.CategoryID
              LEFT JOIN likes l ON r.RecipeID = l.RecipeID
              GROUP BY r.RecipeID";
    $result = mysqli_query($conn, $query);
} else {
    $query = "SELECT r.*, u.FirstName, u.LastName, u.ProfilePhoto as userPhoto,
              c.CategoryName, COUNT(l.UserID) as likeCount
              FROM recipe r
              JOIN user u ON r.UserID = u.UserID
              JOIN recipecategory c ON r.CategoryID = c.CategoryID
              LEFT JOIN likes l ON r.RecipeID = l.RecipeID
              WHERE r.CategoryID = $categoryID
              GROUP BY r.RecipeID";
    $result = mysqli_query($conn, $query);
}

$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);
echo json_encode($recipes);
?>