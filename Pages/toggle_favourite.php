<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'error' => 'Please login to favorite recipes']);
    exit();
}

if (!isset($_POST['recipe_id']) || !is_numeric($_POST['recipe_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid recipe ID']);
    exit();
}

$user_id = $_SESSION['UserID'];
$recipe_id = intval($_POST['recipe_id']);

try {
    $check_stmt = $conn->prepare("SELECT 1 FROM favourites WHERE UserID = ? AND RecipeID = ?");
    $check_stmt->bind_param("ii", $user_id, $recipe_id);
    $check_stmt->execute();
    $exists = $check_stmt->get_result()->num_rows > 0;
    $check_stmt->close();
    
    if ($exists) {
        $stmt = $conn->prepare("DELETE FROM favourites WHERE UserID = ? AND RecipeID = ?");
        $stmt->bind_param("ii", $user_id, $recipe_id);
        $stmt->execute();
        $stmt->close();
        $favorited = false;
    } else {
        $stmt = $conn->prepare("INSERT INTO favourites (UserID, RecipeID) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $recipe_id);
        $stmt->execute();
        $stmt->close();
        $favorited = true;
    }
    
    echo json_encode([
        'success' => true,
        'favorited' => $favorited
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>
