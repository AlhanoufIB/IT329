<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    
    if (!isset($_SESSION['UserID'])) {
        header("Location: Login.php?error=Please-log-in-to-access-your-account.");
        exit();
    }

    if($_SESSION['UserType']  == 'admin') {
        header("Location: Login.php?error=Unauthorized-access.Please-log-in-with-a-user-account.");
        exit();
    }

    include 'db_connect.php';
    $user_id = $_SESSION['UserID'];

    //getting user info
    $query1 = "SELECT * FROM User WHERE UserID = $user_id";
    $result1 = mysqli_query($conn, $query1);
    $user = mysqli_fetch_assoc($result1);

    //getting user recipes count
    $query2 = "SELECT COUNT(*) as total_recipes FROM Recipe WHERE UserID = $user_id";
    $result2 = mysqli_query($conn, $query2);
    $recipeCount = mysqli_fetch_assoc($result2);

    //getting user likes count
    $query3 = "SELECT COUNT(*) as total_likes FROM Likes l
    JOIN Recipe r ON l.RecipeID = r.RecipeID
    WHERE r.UserID = $user_id";
    $result3 = mysqli_query($conn, $query3);
    $likeCount = mysqli_fetch_assoc($result3);

    //getting user categories
    $query4 = "SELECT * FROM RecipeCategory";
    $result4 = mysqli_query($conn, $query4);
    $category =  mysqli_fetch_all($result4, MYSQLI_ASSOC);

    //getting all recipes(POST will get filtered recipes by category, GET will get all recipes)
    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['categoryID'])) {
        $categoryID=intval($_POST['categoryID']);
        
        $query5 = "SELECT r.*, u.FirstName, u.LastName, u.ProfilePhoto as userPhoto,
        c.CategoryName, COUNT(l.UserID) as likeCount
        FROM Recipe r
        JOIN User u ON r.UserID = u.UserID
        JOIN RecipeCategory c ON r.CategoryID = c.CategoryID
        LEFT JOIN Likes l on r.RecipeID=l.RecipeID
        WHERE r.CategoryID = $categoryID
        GROUP BY r.RecipeID";

        $result5 = mysqli_query($conn, $query5);
    }
    else{
        $query5 = "SELECT r.*, u.FirstName, u.LastName, u.ProfilePhoto as userPhoto,
        c.CategoryName, COUNT(l.UserID) as likeCount
        FROM recipe r
        JOIN user u ON r.UserID = u.UserID
        JOIN recipecategory c ON r.categoryID = c.CategoryID
        LEFT JOIN likes l on r.RecipeID=l.RecipeID
        GROUP BY r.RecipeID";

        $result5 = mysqli_query($conn, $query5);
    }
    if ($result5) {
        $recipes = mysqli_fetch_all($result5, MYSQLI_ASSOC);
    } else {
        $recipes = [];
    }


    $query6="SELECT r.* FROM Recipe r JOIN Favourites f ON r.RecipeID = f.recipeID WHERE f.UserID = $user_id";
    $result6 = mysqli_query($conn, $query6);
    if ($result6) {
        $favoriteRecipes = mysqli_fetch_all($result6, MYSQLI_ASSOC);
    } else {
        $favoriteRecipes = [];
    }


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ramadan's Table | Account </title>
        <link rel="stylesheet" href="../CSS/Main.css">
        <link rel="stylesheet" href="../CSS/UserPage.css">
    </head>
    <body class="UserPage">
        <header>
            <div class="topnav">
                <div class="logo"> <img src="../images/logo.png" alt="Logo" class="logoimg"> Ramadan's Table</div>
                    <nav>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="MyRecipes.php">My Recipes</a></li>
                            <li><a href="AddRecipe.php">Add Recipe</a></li>
                            <li><a href="User.php">Account</a></li>
                        </ul>
                    </nav>
            </div>
        </header>

        <div class="breadcrumb">
            <a href="index.php">Home</a> › User Page
        </div>
        
        <main>
            <?php echo '<span class="WelcomeUser">Welcome ' . $user['FirstName'] . '!</span>'; ?>
            

            <div class="UserInfo">
                <div id="UserPersonalInfo">
                    <?php echo '<img src="../images/' . $user['ProfilePhoto'] . '" alt="User Image" class="UserImg">'; ?>
                    <h2>Your Information</h2>
                    <div class="Info">

                        <?php echo "<h3>" . $user['FirstName'] . ' ' . $user['LastName'] . "</h3>"; ?>
                        <?php echo "<h3>" . $user['Email'] . "</h3>"; ?>
                        
                    </div>
                </div>
                <div id="User-MyRecipes">
                    <h2><a href="MyRecipes.php" class="RecipeURL">Your Recipes</a></h2>
                    <?php echo '<h3> Total Recipes: ' . $recipeCount['total_recipes'] . ' Recipes</h3>'; ?>
                    <?php echo '<h3> Total Likes: ' . $likeCount['total_likes'] . ' Likes</h3>'; ?>
                </div>
                
            </div>
            <br>
            
            <div class="AvailableRecipes">
                
                <h2 style="display: inline;">All Available Recipes</h2>
                <div class="FilterContainer">
                    <form method="POST" action="User.php">
                        <select class="CategoryFilter" name="categoryID" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <?php
                                foreach($category as $cat) {
                                    echo '<option value="' . $cat['CategoryID'] . '"' . (isset($_POST['categoryID']) && $_POST['categoryID'] == $cat['CategoryID'] ? ' selected' : '') .
                                    '>' . $cat['CategoryName'] . '</option>';
                                }
                            ?>
                        </select>
                    </form>
                </div>

                
                <table class="RecipeTable">
                    <tr>
                        <th>Recipe Name</th>
                        <th>Recipe Photo</th>
                        <th>Recipe Creator</th>
                        <th>Number of likes</th>
                        <th>Category</th>
                    </tr>
                    <?php if(empty($recipes)) {
                    echo '<tr><td colspan="5">No recipes found.</td></tr>';
                    }
                    else {
                    ?>
                    <?php foreach($recipes as $recipe) {
                                echo '<tr>';
                                echo '<td><a href="ViewRecipe.php?id=' . $recipe['RecipeID'] . '" class="RecipeURL">' . $recipe['Name'] . '</a></td>';
                                echo '<td><img src="../images/' . $recipe['PhotoFileName'] . '" alt="Recipe Photo" class="RecipeImg"></td>';
                                echo '<td><img src="../images/' . $recipe['userPhoto'] . '" alt="Creator Image" class="CreatorImg"><br>' . $recipe['FirstName'] . ' ' . $recipe['LastName'] . '</td>';
                                echo '<td>' . $recipe['likeCount'] . '</td>';
                                echo '<td>' . $recipe['CategoryName'] . '</td>';
                                echo '</tr>';
                            }
                    } ?>
                </table>
            </div>


            <div class="FavoriteRecipes">
                <h2>Your Favorite Recipes</h2>
                <table class="RecipeTable">
                    <tr>
                        <th>Recipe Name</th>
                        <th>Recipe Photo</th>
                        <th>Remove</th>
                    </tr>
                    <?php
                    if(empty($favoriteRecipes)) {
                        echo '<tr><td colspan="3">No favorite recipes found.</td></tr>';
                        }
                    else {
                            foreach($favoriteRecipes as $fav) {
                                echo "<tr>";
                                echo'<td><a href="ViewRecipe.php?id='.$fav['RecipeID']. '" class="RecipeURL">'.$fav['Name'].'</a></td>';
                                echo'<td><img src="../images/'.$fav['PhotoFileName'].'" alt="Recipe Photo" class="RecipeImg"></td>';
                                echo'<td><a href="remove_favorite.php?recipeID='.$fav['RecipeID'].'" class="HeartIcon">♥</a></td>';
                                echo"</tr>";
                            }
                    }
                        ?>
                </table>
            </div>
            <a href="signout.php" class="LogOutUser">Sign Out</a>

        </main>
        <footer>
            <div class="footer-content">
                <p class="copy">© 2026 Ramadan's Table · All rights reserved <br> Contact: info@RamadanTable.sa | +966 50 000 0000 </p>
            </div>
        </footer>
    </body>
</html>