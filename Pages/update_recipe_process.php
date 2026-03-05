<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include 'db_connect.php';


// 1️⃣ Get recipe ID
$recipeID = $_POST['recipeID'];

$name = $_POST['recipeName'];
$category = $_POST['Category'];
$description = $_POST['Description'];
$url = $_POST['URL'];


// 2️⃣ Get current recipe info
$sql = "SELECT * FROM recipe WHERE RecipeID = $recipeID";
$result = $conn->query($sql);
$recipe = $result->fetch_assoc();

$photoName = $recipe['PhotoFileName'];
$videoName = $recipe['VideoPathName'];


// 3️⃣ Check if new photo uploaded
if(!empty($_FILES['RecipePhoto']['name'])){

$photoName = $_FILES['RecipePhoto']['name'];
$tempName = $_FILES['RecipePhoto']['tmp_name'];

move_uploaded_file($tempName, "images/" . $photoName);
}


// 4️⃣ Check if new video uploaded
if(!empty($_FILES['VideoOrURL']['name'])){

$videoName = $_FILES['VideoOrURL']['name'];
$tempVideo = $_FILES['VideoOrURL']['tmp_name'];

move_uploaded_file($tempVideo, "videos/" . $videoName);

}
elseif(!empty($url)){

$videoName = $url;

}


// 5️⃣ Update recipe
$sql = "UPDATE recipe 
SET Name='$name',
CategoryID='$category',
description='$description',
PhotoFileName='$photoName',
VideoPathName='$videoName'
WHERE RecipeID=$recipeID";

$conn->query($sql);


// 6️⃣ Remove old ingredients
$conn->query("DELETE FROM ingredients WHERE RecipeID=$recipeID");


// 7️⃣ Insert ingredients
if(isset($_POST['ingredientName'])){

foreach($_POST['ingredientName'] as $i => $ingredient){

$quantity = $_POST['ingredientQuantity'][$i];

$conn->query("INSERT INTO ingredients (RecipeID, ingredientName, ingredientQuantity)
VALUES ('$recipeID','$ingredient','$quantity')");
}
}


// 8️⃣ Remove old instructions
$conn->query("DELETE FROM instructions WHERE RecipeID=$recipeID");


// 9️⃣ Insert instructions
if(isset($_POST['Instruction'])){

foreach($_POST['Instruction'] as $step => $instruction){

$order = $step + 1;

$conn->query("INSERT INTO instructions (RecipeID, Step, StepOrder)
VALUES ('$recipeID','$instruction','$order')");
}
}


// 🔟 Redirect to My Recipes page
header("Location: MyRecipes.php");
exit();

?>
