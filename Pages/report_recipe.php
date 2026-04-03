<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'error' => 'Please login to report recipes']);
    exit();
}

if (!isset($_POST['recipe_id']) || !is_numeric($_POST['recipe_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid recipe ID']);
    exit();
}

$user_id = $_SESSION['UserID'];
$recipe_id = intval($_POST['recipe_id']);

try {
    $check_stmt = $conn->prepare("SELECT 1 FROM report WHERE UserID = ? AND RecipeID = ?");
    $check_stmt->bind_param("ii", $user_id, $recipe_id);
    $check_stmt->execute();
    $already_reported = $check_stmt->get_result()->num_rows > 0;
    $check_stmt->close();
    
    if ($already_reported) {
        echo json_encode(['success' => false, 'error' => 'You have already reported this recipe']);
        exit();
    }
    
    $stmt = $conn->prepare("INSERT INTO report (UserID, RecipeID) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $recipe_id);
    $stmt->execute();
    $stmt->close();
    
    echo json_encode(['success' => true, 'message' => 'Recipe reported successfully']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>
