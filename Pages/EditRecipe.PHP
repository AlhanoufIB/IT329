<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'db_connect.php';
$recipeID = $_GET['id'];
$sql = "SELECT * FROM recipe WHERE RecipeID = '$recipeID'";
$result = $conn->query($sql);
$recipe = $result->fetch_assoc();
$ingredients_sql = "SELECT * FROM ingredients WHERE RecipeID = '$recipeID'";
$ingredients = $conn->query($ingredients_sql);
$instructions_sql = "SELECT * FROM instructions WHERE RecipeID = '$recipeID' ORDER BY StepOrder";
$instructions= $conn->query($instructions_sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<script src="JS/add.js" defer></script>
        <style>
            @import url("../CSS/Main.css");
            @import url("../CSS/AddEdit.css");
</style>
        <title>Ramadan's Table | Edit Recipe</title>


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
            <a href="index.html">Home</a> › <a href="MyRecipes.html">My Recipes</a> › Edit Recipe
        </div>
        <main>

<div class="add">
    <h1>Edit Recipe</h1>
<form action="update_recipe_process.php" method="POST" class="AddRecipeForm" enctype="multipart/form-data">
<input type="hidden" name="recipeID" value="<?php echo $recipeID; ?>">
    <label for="recipeName">Recipe Name:</label><br>
    <input type="text" id="recipeName" name="recipeName" value="<?php echo $recipe['Name']; ?>"required><br><br>


    <label for="Category">Category:</label><br>
    <select id="Category" name="Category" required>
        <option value="" disabled selected hidden>Select a Category</option>
        
  <?php
$sql = "SELECT CategoryID, CategoryName FROM recipecategory";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

$selected = ($row['CategoryID'] == $recipe['CategoryID']) ? "selected" : "";

echo "<option value='{$row['CategoryID']}' $selected>{$row['CategoryName']}</option>";

}
?>
        
    </select><br><br>

    <label for="Description">Description:</label><br>
    <textarea id="Description" name="Description"  rows="4" required><?php echo $recipe['description']; ?></textarea><br><br>


    <label for="RecipePhoto">Upload Photo:</label><br>
    <input type="file" class="RecipePhoto" name="RecipePhoto" accept="image/*"  ><br><br>
<p> <strong>Current Photo:</strong></p>
    <img src="images/<?php echo $recipe['PhotoFileName']; ?>" alt="Recipe Photo" class="CurrentRecipePhoto">

   <label>Ingredients:</label><br>
     <div id="Ingredients">
<?php
while($ingredient= $ingredients->fetch_assoc()){
?>
   <div class="ingredient-row">
        <input type="text" name="ingredientName[]" placeholder="Ingredient 1" value="<?php echo $ingredient['ingredientName']; ?>" required>
        <input type="text" name="ingredientQuantity[]" placeholder="Quantity" value="<?php echo $ingredient['ingredientQuantity']; ?>" required>
    </div>
    <?php
}
?>
    </div>
 <button type="button" class="secondery" onclick="addIngredient()" >Add Ingredient</button><br><br>
    


    <label>Instructions:</label>
    <div id="Instructions">
        <?php
while($Step= $instructions->fetch_assoc()){
?>
        <input type="text" name="Instruction[]" placeholder="Step 1" value="<?php echo $Step['Step']; ?>" required><br><br>
 <?php
}
?>
    </div>
<button type="button" class="secondery" onclick="addInstruction()">Add Instruction</button><br><br>



<label for="VideoOrURL">Upload Video</label><br>
<input type="file" id="VideoOrURL" name="VideoOrURL" accept="video/*" ><br><br>
<?php
if(!empty($recipe['VideoPathName'])){
    ?>
<p> <strong>Current video:</strong></p>


<video width="320" height="240" class="current-video" controls>
  <source src="videos/<?php echo $recipe['VideoPathName']; ?>" type="video/mp4">
  Your browser does not support the video tag. 
</video>
<?php
}
?>
<label for="URL">or URL:</label><br>
<input type="text" id="URL" name="URL" placeholder="https://www.youtube.com/..." value="<?php echo $recipe['VideoPathName']; ?>"><br><br>


<button type="submit" class="submit">Update Recipe</button>
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