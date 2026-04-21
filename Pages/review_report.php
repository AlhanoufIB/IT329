<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['UserID'])) {
    header("Location: Login.php?error=Please-log-in-first.");
    exit();
}


if ($_SESSION['UserType'] != "admin") {
    header("Location: Login.php?error=Unauthorized-access.Please-log-in-with-an-admin-account.");
    exit();
}

$recipeID = $_POST['recipe_id'];
$reportID = $_POST['report_id'];
$action = $_POST['action'];


$recipeQuery = "SELECT * FROM recipe WHERE RecipeID = $recipeID";
$recipeResult = mysqli_query($conn, $recipeQuery);
$recipe = mysqli_fetch_assoc($recipeResult);

$userID = $recipe['UserID'];


if ($action == "block") {

   
    $userQuery = "SELECT * FROM user WHERE UserID = $userID";
    $userResult = mysqli_query($conn, $userQuery);
    $user = mysqli_fetch_assoc($userResult);


    $checkBlockedQuery = "SELECT * FROM blockeduser WHERE Email = '" . $user['Email'] . "'";
    $checkBlockedResult = mysqli_query($conn, $checkBlockedQuery);

    if (mysqli_num_rows($checkBlockedResult) == 0) {
        $insertBlockedQuery = "
        INSERT INTO blockeduser (FirstName, LastName, Email)
        VALUES ('" . $user['FirstName'] . "', '" . $user['LastName'] . "', '" . $user['Email'] . "')
        ";
        mysqli_query($conn, $insertBlockedQuery);
    }

  
    $userRecipesQuery = "SELECT * FROM recipe WHERE UserID = $userID";
    $userRecipesResult = mysqli_query($conn, $userRecipesQuery);

    while($userRecipe = mysqli_fetch_assoc($userRecipesResult)) {
        $oneRecipeID = $userRecipe['RecipeID'];

   
        if ($userRecipe['PhotoFileName'] != "") {
            $photoPath = "../images/" . $userRecipe['PhotoFileName'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

      
        if (isset($userRecipe['VideoPathName']) && $userRecipe['VideoPathName'] != "") {
            $videoPath = "../videos/" . $userRecipe['VideoPathName'];
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
        }

        mysqli_query($conn, "DELETE FROM ingredients WHERE RecipeID = $oneRecipeID");
        mysqli_query($conn, "DELETE FROM instructions WHERE RecipeID = $oneRecipeID");
        mysqli_query($conn, "DELETE FROM comment WHERE RecipeID = $oneRecipeID");
        mysqli_query($conn, "DELETE FROM likes WHERE RecipeID = $oneRecipeID");
        mysqli_query($conn, "DELETE FROM favourites WHERE RecipeID = $oneRecipeID");
        mysqli_query($conn, "DELETE FROM report WHERE RecipeID = $oneRecipeID");
    }

    mysqli_query($conn, "DELETE FROM recipe WHERE UserID = $userID");
    mysqli_query($conn, "DELETE FROM user WHERE UserID = $userID");
}


if ($action == "dismiss") {
    mysqli_query($conn, "DELETE FROM report WHERE ReportID = $reportID");
}

header("Location: Admin.PHP");
exit();
?>