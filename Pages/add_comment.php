<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'error' => 'Please login to comment']);
    exit();
}

if (!isset($_POST['recipe_id']) || !is_numeric($_POST['recipe_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid recipe ID']);
    exit();
}

if (!isset($_POST['comment']) || empty(trim($_POST['comment']))) {
    echo json_encode(['success' => false, 'error' => 'Comment cannot be empty']);
    exit();
}

$user_id = $_SESSION['UserID'];
$recipe_id = intval($_POST['recipe_id']);
$comment = trim($_POST['comment']);

try {
    $stmt = $conn->prepare("INSERT INTO comment (RecipeID, UserID, comment, date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $recipe_id, $user_id, $comment);
    $stmt->execute();
    $stmt->close();
    
    echo json_encode(['success' => true, 'message' => 'Comment added successfully']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>
