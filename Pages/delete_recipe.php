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

/* Get recipe data first, and make sure this recipe belongs to the logged-in user */
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

/* Delete associated data */
$stmt = $conn->prepare("DELETE FROM ingredients WHERE RecipeID = ?");
$stmt->bind_param("i", $recipeID);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("DELETE FROM instructions WHERE RecipeID = ?");
$stmt->bind_param("i", $recipeID);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("DELETE FROM comment WHERE RecipeID = ?");
$stmt->bind_param("i", $recipeID);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("DELETE FROM likes WHERE RecipeID = ?");
$stmt->bind_param("i", $recipeID);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("DELETE FROM favourites WHERE RecipeID = ?");
$stmt->bind_param("i", $recipeID);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("DELETE FROM report WHERE RecipeID = ?");
$stmt->bind_param("i", $recipeID);
$stmt->execute();
$stmt->close();

/* Delete the recipe itself */
$stmt = $conn->prepare("DELETE FROM recipe WHERE RecipeID = ? AND UserID = ?");
$stmt->bind_param("ii", $recipeID, $userID);
$deleted = $stmt->execute();
$stmt->close();

/* Delete image file */
if ($deleted && !empty($recipe['PhotoFileName'])) {
    $photoPath = '../images/' . $recipe['PhotoFileName'];
    if (file_exists($photoPath)) {
        unlink($photoPath);
    }
}

/* Delete video file if it is not a URL */
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