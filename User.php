<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: Login.php?error=Please log in to access your account.");
        exit();
    }

    if($_SESSION['userType'] !== 'user') {
        header("Location: Login.php?error=Unauthorized access. Please log in with a user account.");
        exit();
    }

    include 'db_connect.php';
    $user_id = $_SESSION['user_id'];

    //getting user info
    $query1 = "SELECT * FROM User WHERE id = $user_id";
    $result1 = mysqli_query($conn, $query1);
    $user = mysqli_fetch_assoc($result1);

    //getting user recipes count
    $query2 = "SELECT COUNT(*) as total_recipes FROM Recipe WHERE userID = $user_id";
    $result2 = mysqli_query($conn, $query2);
    $recipeCount = mysqli_fetch_assoc($result2);

    //getting user likes count
    $query3 = "SELECT COUNT(*) as total_likes FROM Likes l
    JOIN Recipe r ON l.recipeID = r.id
    WHERE r.userID = $user_id";
    $result3 = mysqli_query($conn, $query3);
    $likeCount = mysqli_fetch_assoc($result3);

    //getting user categories
    $query4 = "SELECT * FROM RecipeCategory";
    $result4 = mysqli_query($conn, $query4);
    $category =  mysqli_fetch_all($result4, MYSQLI_ASSOC);

    //getting all recipes(POST will get filtered recipes by category, GET will get all recipes)
    if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['categoryID'])) {
        $categoryID=intval($_POST['categoryID']);
        $query5 = "SELECT r.*, u.firstName, u.lastName, u.photoFileName as userPhoto, 
        c.categoryName, COUNT(l.userID) as likeCount
        FROM Recipe r
        JOIN User u ON r.userID = u.id
        JOIN RecipeCategory c ON r.categoryID = c.id
        LEFT JOIN Likes l on r.id=l.recipeID
        WHERE r.categoryID = $categoryID
        GROUP BY r.id";

        $result5 = mysqli_query($conn, $query5);
    }
    else{
        $query5 = "SELECT r.*, u.firstName, u.lastName, u.photoFileName as userPhoto,
        c.categoryName, COUNT(l.userID) as likeCount
        FROM Recipe r
        JOIN User u ON r.userID = u.id
        JOIN RecipeCategory c ON r.categoryID = c.id
        LEFT JOIN Likes l on r.id=l.recipeID
        GROUP BY r.id";

        $result5 = mysqli_query($conn, $query5);
    }
    if ($result5) {
        $recipes = mysqli_fetch_all($result5, MYSQLI_ASSOC);
    } else {
        $recipes = [];
    }


    $query6="SELECT r.* FROM Recipe r JOIN Favourites f ON r.id = f.recipeID WHERE f.userID = $user_id";
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
                            <li><a href="index.html">Home</a></li>
                            <li><a href="MyRecipes.html">My Recipes</a></li>
                            <li><a href="AddRecipe.html">Add Recipe</a></li>
                            <li><a href="User.html">Account</a></li>
                        </ul>
                    </nav>
            </div>
        </header>

        <div class="breadcrumb">
            <a href="index.html">Home</a> › User Page
        </div>

        <main>
            <?php echo '<span class="WelcomeUser">Welcome ' . $user['firstName'] . '!</span>'; ?>
            

            <div class="UserInfo">
                <div id="UserPersonalInfo">
                    <?php echo '<img src="../images/' . $user['photoFileName'] . '" alt="User Image" class="UserImg">'; ?>
                    <h2>Your Information</h2>
                    <div class="Info">

                        <?php echo "<h3>" . $user['firstName'] . ' ' . $user['lastName'] . "</h3>"; ?>
                        <?php echo "<h3>" . $user['emailAddress'] . "</h3>"; ?>
                        
                    </div>
                </div>
                <div id="User-MyRecipes">
                    <h2><a href="MyRecipes.html" class="RecipeURL">Your Recipes</a></h2>
                    <?php echo '<h3> Total Recipes: ' . $recipeCount['total_recipes'] . ' Recipes</h3>'; ?>
                    <?php echo '<h3> Total Likes: ' . $likeCount['total_likes'] . ' Likes</h3>'; ?>
                </div>
                
            </div>
            <br>
            
            <div class="AvailableRecipes">
                
                <h2 style="display: inline;">All Available Recipes</h2>
                <div class="FilterContainer">
                    <form method="POST" action="User.php">
                        <select class="CategoryFilter" name="categoryID">
                            <option value="AllCategories">All Categories</option>
                            <?php
                                foreach($category as $cat) {
                                    echo '<option value="' . $cat['id'] . '"' . (isset($_POST['categoryID']) && $_POST['categoryID'] == $cat['id'] ? ' selected' : '') .
                                    '>' . $cat['categoryName'] . '</option>';
                                }

                            ?>
                        </select>
                        <button type="submit" class="CategoryFilter">▽ Filter</button>
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
                                echo '<td><a href="ViewRecipe.php?id=' . $recipe['id'] . '" class="RecipeURL">' . $recipe['name'] . '</a></td>';
                                echo '<td><img src="../images/' . $recipe['photoFileName'] . '" alt="Recipe Photo" class="RecipeImg"></td>';
                                echo '<td><img src="../images/' . $recipe['userPhoto'] . '" alt="Creator Image" class="CreatorImg"><br>' . $recipe['firstName'] . ' ' . $recipe['lastName'] . '</td>';
                                echo '<td>' . $recipe['likeCount'] . '</td>';
                                echo '<td>' . $recipe['categoryName'] . '</td>';
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
                                echo'<td><a href="ViewRecipe.php?id='.$fav['id']. '" class="RecipeURL">'.$fav['name'].'</a></td>';
                                echo'<td><img src="../images/'.$fav['photoFileName'].'" alt="Recipe Photo" class="RecipeImg"></td>';
                                echo'<td><a href="remove_favorite.php?recipeID='.$fav['id'].'" class="HeartIcon">♥</a></td>';
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