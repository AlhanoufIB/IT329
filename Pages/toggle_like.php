<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['UserID'])) {
    echo json_encode(['success' => false, 'error' => 'Please login to like recipes']);
    exit();
}

if (!isset($_POST['recipe_id']) || !is_numeric($_POST['recipe_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid recipe ID']);
    exit();
}

$user_id = $_SESSION['UserID'];
$recipe_id = intval($_POST['recipe_id']);

try {
    $check_stmt = $conn->prepare("SELECT 1 FROM likes WHERE UserID = ? AND RecipeID = ?");
    $check_stmt->bind_param("ii", $user_id, $recipe_id);
    $check_stmt->execute();
    $exists = $check_stmt->get_result()->num_rows > 0;
    $check_stmt->close();
    
    if ($exists) {
        $stmt = $conn->prepare("DELETE FROM likes WHERE UserID = ? AND RecipeID = ?");
        $stmt->bind_param("ii", $user_id, $recipe_id);
        $stmt->execute();
        $stmt->close();
        $liked = false;
    } else {
        $stmt = $conn->prepare("INSERT INTO likes (UserID, RecipeID) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $recipe_id);
        $stmt->execute();
        $stmt->close();
        $liked = true;
    }
    
    $count_stmt = $conn->prepare("SELECT COUNT(*) as count FROM likes WHERE RecipeID = ?");
    $count_stmt->bind_param("i", $recipe_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $likes_count = $count_result->fetch_assoc()['count'];
    $count_stmt->close();
    
    echo json_encode([
        'success' => true,
        'liked' => $liked,
        'likes_count' => $likes_count
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>
