<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Recipe - Oat Soup</title>

  
  <link rel="stylesheet" href="../CSS/Main.css">
  <link rel="stylesheet" href="../CSS/ViewRecipe.css">
</head>

<body class="ViewRecipePage">
  <header>
    <div class="topnav">
      <div class="logo">
        <img src="../images/logo.png" alt="Logo" class="logoimg"> Ramadan's Table
      </div>
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
    <a href="index.html">Home</a> › <a href="User.html">User Page </a> › Oat Soup
  </div>

  <main>

    <div class="TopButtons">
      <button type="button" class="TopBtn">★ Favourite</button>
      <button type="button" class="TopBtn">♥ Like</button>
      <button type="button" class="TopBtn">⚑ Report</button>
    </div>

    <div class="RecipeMain">
      <h1 class="RecipeName">Oat Soup</h1>
      <img src="../images/Oat-soup.jpg" alt="Oat Soup" class="RecipeBigImg">
    </div>


    <div class="Card">
      <h2>Recipe Creator</h2>
      <div class="CreatorPart">
        <img src="../images/ChefAhmed.jpg" alt="Creator Image" class="CreatorImg">
        <div class="CreatorInfo">
          <h3>Chef Ahmed</h3>
          <p class="Description">Healthy Ramadan Recipes</p>
        </div>
      </div>
    </div>


    <div class="Card">
      <h2>Category & Description</h2>
      <p><strong>Category:</strong> Iftar</p>
      <p>
        A warm and creamy oat soup that is light, filling, and perfect for Iftar.
      </p>
    </div>

 
    <div class="Card">
      <h2>Ingredients</h2>
      <ul class="IngredientList">
     <li><span>Rolled oats</span> <span class="Qty">1 cup</span></li>
<li><span>Minced chicken (or beef)</span> <span class="Qty">250g</span></li>
<li><span>Chicken broth</span> <span class="Qty">5 cups</span></li>
<li><span>Tomato paste</span> <span class="Qty">1 tablespoon</span></li>
<li><span>Onion (finely chopped)</span> <span class="Qty">1 medium</span></li>
<li><span>Garlic (minced)</span> <span class="Qty">2 cloves</span></li>
<li><span>Carrot (finely diced)</span> <span class="Qty">1 small</span></li>
<li><span>Zucchini (small cubes)</span> <span class="Qty">½ cup</span></li>
<li><span>Olive oil</span> <span class="Qty">1 tablespoon</span></li>
<li><span>Salt</span> <span class="Qty">1 teaspoon</span></li>
<li><span>Black pepper</span> <span class="Qty">½ teaspoon</span></li>
<li><span>Cumin</span> <span class="Qty">½ teaspoon</span></li>
<li><span>Ground coriander</span> <span class="Qty">½ teaspoon</span></li>
<li><span>Ground cinnamon</span> <span class="Qty">¼ teaspoon</span></li>
<li><span>Fresh parsley (chopped)</span> <span class="Qty">2 tablespoons</span></li>
<li><span>Lemon juice</span> <span class="Qty">1 tablespoon</span></li>

      </ul>
    </div>


    <div class="Card">
      <h2>Instructions</h2>
      <ol class="StepsList">
     <li>Heat olive oil in a large pot over medium heat.</li>
<li>Add chopped onion and sauté until soft and golden.</li>
<li>Add minced garlic and cook for 30 seconds.</li>
<li>Add minced chicken and cook until fully browned.</li>
<li>Add tomato paste and stir for 1 minute.</li>
<li>Add diced carrot and zucchini and mix well.</li>
<li>Add oats and stir for 1–2 minutes.</li>
<li>Pour in the chicken broth and bring to a boil.</li>
<li>Reduce heat and let it simmer for 15–20 minutes.</li>
<li>Add salt, black pepper, cumin, coriander, and cinnamon.</li>
<li>Simmer for another 5 minutes until thick and creamy.</li>
<li>Add lemon juice and garnish with fresh parsley before serving.</li>

      </ol>
    </div>

  
    <div class="Card">
      <h2>Video</h2>
      <a class="RecipeURL" href="https://youtu.be/UHRNVTMgI5M?si=SAui-STYGr3x__7M" target="_blank">Watch Recipe Tutorial on YouTube</a>
    </div>



    <div class="Card">
      <div class="CommentsHeader">
        <h2>Comments</h2>
        <button type="button" id="AddComment" class="AddCommentBtn">+ Add Comment</button>
      </div>

      <div id="CommentsList">

        <div class="CommentBox">
          <div class="CommentTop">
            <strong>Reem</strong>
            <span class="Description">2 hours ago</span>
          </div>
          <p>This looks delicious 😍</p>
        </div>

        <div class="CommentBox">
          <div class="CommentTop">
            <strong>Haya</strong>
            <span class="Description">Yesterday</span>
          </div>
          <p>Will be making this for Ramadan.</p>
        </div>
      </div>
    </div>


    <a href="User.html" class="BackLink">← Back to User Page</a>

  </main>


  <div id="CommentModal" class="Modal Hidden">
    <div class="ModalBox">
      <div class="ModalHead">
        <h3>Add a Comment</h3>
        <button type="button" id="CloseModal" class="CloseBtn">×</button>
      </div>

      <form id="CommentForm">
        <label for="CommentText">Your comment:</label>
        <textarea id="CommentText" rows="4" required placeholder="Write your comment..."></textarea>

        <div class="ModalActions">
          <button type="submit" class="PostBtn">Post</button>
          <button type="button" id="CancelModal" class="CancelBtn">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <footer>
    <div class="footer-content">
      <p class="copy">© 2026 Ramadan's Table · All rights reserved <br> Contact: info@RamadanTable.sa | +966 50 000 0000 </p>
    </div>
  </footer>
<script src="../JS/ViewRecipe.js"></script>


</body>
</html>
