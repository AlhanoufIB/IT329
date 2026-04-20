<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['UserID'])) {
        header("Location: Login.php?error=Please-log-in-to-access-your-account.");
        exit();
    }

if (!isset($_POST['recipe_id']) || !is_numeric($_POST['recipe_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid recipe ID']);
    exit();
}

$recipe_id = intval($_POST['recipe_id']);
$user_id = $_SESSION['UserID'];

$conn->begin_transaction();

try {
   $check_query = "SELECT RecipeID, PhotoFileName, VideoPathName FROM recipe WHERE RecipeID = ? AND UserID = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ii", $recipe_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    throw new Exception("Recipe not found or you don't have permission to delete it");
}

$recipe = $result->fetch_assoc();
$photo_file = $recipe['PhotoFileName'];
$video_file = $recipe['VideoPathName'];
$stmt->close();

if (!empty($photo_file)) {
    $photo_path = "../images/" . $photo_file;
    if (file_exists($photo_path)) {
        if (!unlink($photo_path)) {
            throw new Exception("Failed to delete image file");
        }
    }
}

if (!empty($video_file)) {
    $video_path = "../videos/" . $video_file;
    if (file_exists($video_path)) {
        if (!unlink($video_path)) {
            throw new Exception("Failed to delete video file");
        }
    }
}
    $delete_likes = "DELETE FROM likes WHERE RecipeID = ?";
    $stmt = $conn->prepare($delete_likes);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();
    
    $delete_comments = "DELETE FROM comment WHERE RecipeID = ?";
    $stmt = $conn->prepare($delete_comments);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();
    
    $delete_favourites = "DELETE FROM favourites WHERE RecipeID = ?";
    $stmt = $conn->prepare($delete_favourites);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();
    
    $delete_reports = "DELETE FROM report WHERE RecipeID = ?";
    $stmt = $conn->prepare($delete_reports);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();
    
    $delete_ingredients = "DELETE FROM ingredients WHERE RecipeID = ?";
    $stmt = $conn->prepare($delete_ingredients);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();
    
    $delete_instructions = "DELETE FROM instructions WHERE RecipeID = ?";
    $stmt = $conn->prepare($delete_instructions);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();
    
    $delete_recipe = "DELETE FROM recipe WHERE RecipeID = ?";
    $stmt = $conn->prepare($delete_recipe);
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $stmt->close();
    

    $conn->commit();
    
    echo json_encode(['success' => true, 'message' => 'Recipe deleted successfully']);
    
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>