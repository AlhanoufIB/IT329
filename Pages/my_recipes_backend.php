<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['UserID'];

// Fetch all recipes for the logged-in user with their details
$query = "SELECT r.RecipeID, r.Name, r.description, r.PhotoFileName, r.VideoPathName,
          (SELECT COUNT(*) FROM likes WHERE RecipeID = r.RecipeID) as likes_count
          FROM recipe r
          WHERE r.UserID = ?
          ORDER BY r.RecipeID DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$recipes = [];

while ($row = $result->fetch_assoc()) {
    $recipe_id = $row['RecipeID'];
    
    // Fetch ingredients for this recipe
    $ingredients_query = "SELECT ingredientName, ingredientQuantity 
                         FROM ingredients 
                         WHERE RecipeID = ? 
                         ORDER BY IngredientID";
    $ing_stmt = $conn->prepare($ingredients_query);
    $ing_stmt->bind_param("i", $recipe_id);
    $ing_stmt->execute();
    $ing_result = $ing_stmt->get_result();
    
    $ingredients = [];
    while ($ing_row = $ing_result->fetch_assoc()) {
        $ingredients[] = $ing_row;
    }
    $ing_stmt->close();
    
    // Fetch instructions for this recipe
    $instructions_query = "SELECT Step 
                          FROM instructions 
                          WHERE RecipeID = ? 
                          ORDER BY StepOrder";
    $inst_stmt = $conn->prepare($instructions_query);
    $inst_stmt->bind_param("i", $recipe_id);
    $inst_stmt->execute();
    $inst_result = $inst_stmt->get_result();
    
    $instructions = [];
    while ($inst_row = $inst_result->fetch_assoc()) {
        $instructions[] = $inst_row['Step'];
    }
    $inst_stmt->close();
    
    // Add all data to recipe array
    $row['ingredients'] = $ingredients;
    $row['instructions'] = $instructions;
    $recipes[] = $row;
}

$stmt->close();

// Calculate total recipes and total likes
$total_recipes = count($recipes);
$total_likes = 0;
foreach ($recipes as $recipe) {
    $total_likes += $recipe['likes_count'];
}

// Store data for the view
$recipe_data = [
    'recipes' => $recipes,
    'total_recipes' => $total_recipes,
    'total_likes' => $total_likes
];

$conn->close();
?>
