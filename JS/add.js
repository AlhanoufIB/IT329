

function addIngredient() {
    const ingredientsDiv = document.getElementById('Ingredients');
  const row=document.createElement('div');
  row.className='ingredient-row';
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'ingredient';
    input.placeholder = 'Name';
    input.required = true;
   const quantityInput = document.createElement('input');
    quantityInput.type = 'text';
    quantityInput.name = 'quantity';
    quantityInput.placeholder = 'Quantity';
    quantityInput.required = true;


    row.appendChild(input);
    row.appendChild(quantityInput);
    ingredientsDiv.appendChild(row);

}








function addInstruction(){
    const instructionsDiv = document.getElementById('Instructions');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'instruction';
    input.placeholder = 'Next Step';
    input.style.display = 'block';
    input.style.marginTop = '8px';
    input.required = true;
    instructionsDiv.appendChild(input);
}
function redirecttoRecipes(event) {
    event.preventDefault();
    alert("Recipe added successfully!");
    window.location.href = "MyRecipes.html";
   
}
document.addEventListener("DOMContentLoaded", function () {
    addIngredient();
});
