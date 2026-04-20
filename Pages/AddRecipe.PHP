<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_connect.php';
 session_start();
    
    if (!isset($_SESSION['UserID'])) {
        header("Location: Login.php?error=Please-log-in-to-access-your-account.");
        exit();
    }

    if($_SESSION['UserType']  == 'admin') {
        header("Location: Login.php?error=Unauthorized-access.Please-log-in-with-a-user-account.");
        exit();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<script src="../JS/add.js" defer></script>
        <style>
            @import url("../CSS/Main.css");
            @import url("../CSS/AddEdit.css");
</style>
        <title>Ramadan's Table | Add Recipe</title>


    </head>

    <body class="headerandfooter">
        
        <header>
<div class="topnav">
    <div class="logo"> <img src="../images/logo.png" alt="" class="logoimg"> Ramadan's Table</div>
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
            <a href="index.php">Home</a> › <a href="MyRecipes.php">My Recipes</a> › Add Recipe
        </div>
        <main>

<div class="add">
    <h1>Add Recipe</h1>
<form action="add_recipe_process.php" method="POST" enctype="multipart/form-data"  class="AddRecipeForm" >
    <label for="recipeName">Recipe Name:</label><br>
    <input type="text" id="recipeName" name="recipeName" required><br><br>


    <label for="Category">Category:</label><br>
    <select id="Category" name="Category" required>
        <option value="" disabled selected hidden>Select a category</option>
        <?php

        $sql = "SELECT CategoryID, CategoryName FROM recipecategory";
        $result = $conn->query($sql);

       if($result){
            while($row = $result->fetch_assoc()) {
              ?>   
               <option value="<?php echo $row['CategoryID']; ?>"><?php echo $row['CategoryName']; ?></option>
                <?php
            }
            }
            ?>

        
    </select><br><br>

    <label for="Description">Description:</label><br>
    <textarea id="Description" name="Description" rows="4" required></textarea><br><br>


    <label for="RecipePhoto">Upload Photo:</label><br>
   <input type="file" id="RecipePhoto" name="RecipePhoto" accept="image/*" required><br><br>

   <label>Ingredients:</label><br>
   <div id="Ingredients"></div><br><br>
    <button type="button" class="secondery" onclick="addIngredient()" >Add Ingredient</button><br><br>
    
    <label>Instructions:</label>
    <div id="Instructions">
        <input type="text" name="Instruction[]" placeholder="Step 1" required><br><br>
    </div><br>
<button type="button" class="secondery" onclick="addInstruction()">Add Instruction</button><br><br>



<label for="VideoOrURL">Upload Video</label><br>
<input type="file" id="VideoOrURL" name="VideoOrURL" accept="video/*"><br><br>
<label for="URL">or URL:</label><br>
<input type="text" id="URL" name="URL" placeholder="https://example.com"><br><br>


<button type="submit" class="submit">Submit Recipe</button>
</form>
</div>
        </main>

        <footer>
    <div class="footer-content">
      <p class="copy">© 2026 Ramadan's Table · All rights reserved <br> Contact: info@RamadanTable.sa | +966 50 000 0000 </p>
    </div>
  </footer>
    </body>
</html>