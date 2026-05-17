<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_connect.php';

if (!isset($_SESSION['UserID'])) {
    echo "false";
    exit();
}

if (!isset($_POST['id'])) {
    echo "false";
    exit();
}

$recipeID = intval($_POST['id']);
$userID = intval($_SESSION['UserID']);

$stmt = $conn->prepare("SELECT * FROM recipe WHERE RecipeID = ? AND UserID = ?");
$stmt->bind_param("ii", $recipeID, $userID);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    echo "false";
    exit();
}

$recipe = $result->fetch_assoc();
$stmt->close();

$tables = ["ingredients", "instructions", "comment", "likes", "favourites", "report"];

foreach ($tables as $table) {
    $stmt = $conn->prepare("DELETE FROM `$table` WHERE RecipeID = ?");
    $stmt->bind_param("i", $recipeID);
    $stmt->execute();
    $stmt->close();
}

$stmt = $conn->prepare("DELETE FROM recipe WHERE RecipeID = ? AND UserID = ?");
$stmt->bind_param("ii", $recipeID, $userID);
$deleted = $stmt->execute();
$stmt->close();

if ($deleted && !empty($recipe['PhotoFileName'])) {
    $photoPath = '../images/' . $recipe['PhotoFileName'];

    if (file_exists($photoPath)) {
        unlink($photoPath);
    }
}

if ($deleted && !empty($recipe['VideoPathName']) && !filter_var($recipe['VideoPathName'], FILTER_VALIDATE_URL)) {
    $videoPath = '../videos/' . $recipe['VideoPathName'];

    if (file_exists($videoPath)) {
        unlink($videoPath);
    }
}

if ($deleted) {
    echo "true";
} else {
    echo "false";
}

$conn->close();
exit();
?>