<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'db_connect.php';

$name = $_POST['recipeName'];
$category = $_POST['Category'];
$description = $_POST['Description'];
$photoName = $_FILES['RecipePhoto']['name'];
$tempName = $_FILES['RecipePhoto']['tmp_name'];
move_uploaded_file($tempName, "../images/" . $photoName);
$userID = $_SESSION['UserID'];
$videoName = NULL;

if (isset($_FILES['VideoOrURL']) && $_FILES['VideoOrURL']['error'] == 0) {
    $videoName = $_FILES['VideoOrURL']['name'];
    $tempVideo = $_FILES['VideoOrURL']['tmp_name'];
    move_uploaded_file($tempVideo, "../videos/" . $videoName);
}

$sql = "INSERT INTO recipe (UserID, CategoryID, Name, description, PhotoFileName, VideoPathName)
VALUES ('$userID','$category','$name','$description','$photoName','$videoName')";
$conn->query($sql);
$recipeID = $conn->insert_id;
if(isset($_POST['ingredientName'])){
    foreach($_POST['ingredientName'] as $i => $ingredient){
        $quantity = $_POST['ingredientQuantity'][$i];
        $sql = "INSERT INTO ingredients (RecipeID, ingredientName, ingredientQuantity)
        VALUES ('$recipeID','$ingredient','$quantity')";
        $conn->query($sql);
    }
}
if(isset($_POST['Instruction'])){
    foreach($_POST['Instruction'] as $step => $instruction){
        $order = $step + 1;
        $sql = "INSERT INTO instructions (RecipeID, Step, StepOrder)
        VALUES ('$recipeID','$instruction','$order')";
        $conn->query($sql);
    }
}
header("Location: MyRecipes.php");
exit();
?>