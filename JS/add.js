

function addIngredient() {
    const ingredientsDiv = document.getElementById('Ingredients');
  const row=document.createElement('div');
  row.className='ingredient-row';
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'ingredientName[]';
    input.placeholder = 'Name';
    input.required = true;
   const quantityInput = document.createElement('input');
    quantityInput.type = 'text';
    quantityInput.name = 'ingredientQuantity[]';
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
    input.name = 'Instruction[]';
    input.placeholder = 'Next Step';
    input.style.display = 'block';
    input.style.marginTop = '8px';
    input.required = true;
    instructionsDiv.appendChild(input);
}

document.addEventListener("DOMContentLoaded", function () {
    const ingredients_div=document.getElementById('Ingredients');
    if(ingredients_div && ingredients_div.children.length === 0){
        addIngredient();
    }
});
