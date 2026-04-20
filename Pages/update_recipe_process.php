<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include 'db_connect.php';

$recipeID = $_POST['recipeID'];
$name = $_POST['recipeName'];
$category = $_POST['Category'];
$description = $_POST['Description'];
$url = $_POST['URL'];

$sql = "SELECT * FROM recipe WHERE RecipeID = $recipeID";
$result = $conn->query($sql);
$recipe = $result->fetch_assoc();

$photoName = $recipe['PhotoFileName'];
$videoName = $recipe['VideoPathName'];

$isFile = !empty($recipe['VideoPathName']) && !str_starts_with($recipe['VideoPathName'], 'http');

// Handle photo
if(!empty($_FILES['RecipePhoto']['name'])){
    if(!empty($recipe['PhotoFileName'])){
        unlink('../images/' . $recipe['PhotoFileName']);
    }
    $photoName = $_FILES['RecipePhoto']['name'];
    $tempName = $_FILES['RecipePhoto']['tmp_name'];
    move_uploaded_file($tempName, "../images/" . $photoName);
}

// Handle video
if(!empty($_FILES['VideoOrURL']['name'])){
    if($isFile){
        unlink('../videos/' . $recipe['VideoPathName']);
    }
    $videoName = $_FILES['VideoOrURL']['name'];
    $tempVideo = $_FILES['VideoOrURL']['tmp_name'];
    move_uploaded_file($tempVideo, "../videos/" . $videoName);
}
elseif(!empty($url)){
    if($isFile){
        unlink('../videos/' . $recipe['VideoPathName']);
    }
    $videoName = $url;
}

// Update recipe
$sql = "UPDATE recipe 
SET Name='$name',
CategoryID='$category',
description='$description',
PhotoFileName='$photoName',
VideoPathName='$videoName'
WHERE RecipeID=$recipeID";

$conn->query($sql);

// Update ingredients
$conn->query("DELETE FROM ingredients WHERE RecipeID=$recipeID");

if(isset($_POST['ingredientName'])){
    foreach($_POST['ingredientName'] as $i => $ingredient){
        $quantity = $_POST['ingredientQuantity'][$i];
        $conn->query("INSERT INTO ingredients (RecipeID, ingredientName, ingredientQuantity)
        VALUES ('$recipeID','$ingredient','$quantity')");
    }
}

// Update instructions
$conn->query("DELETE FROM instructions WHERE RecipeID=$recipeID");

if(isset($_POST['Instruction'])){
    foreach($_POST['Instruction'] as $step => $instruction){
        $order = $step + 1;
        $conn->query("INSERT INTO instructions (RecipeID, Step, StepOrder)
        VALUES ('$recipeID','$instruction','$order')");
    }
}

header("Location: MyRecipes.php");
exit();
?>