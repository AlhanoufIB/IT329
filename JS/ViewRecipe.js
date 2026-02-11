

let openBtn = document.getElementById("AddComment");
let modal = document.getElementById("CommentModal");
let closeBtn = document.getElementById("CloseModal");
let cancelBtn = document.getElementById("CancelModal");
let form = document.getElementById("CommentForm");
let text = document.getElementById("CommentText");
let list = document.getElementById("CommentsList");

function openModal() {
  modal.classList.remove("Hidden");
  text.value = "";

}

function closeModal() {
  modal.classList.add("Hidden");
}

openBtn.addEventListener("click", openModal);
closeBtn.addEventListener("click", closeModal);
cancelBtn.addEventListener("click", closeModal);

form.addEventListener("submit", function (event) {
  event.preventDefault();

  let value = text.value.trim(); 
  if (value === "") return;


  let box = document.createElement("div");
  box.className = "CommentBox"; 

  let top = document.createElement("div");
  top.className = "CommentTop";

  let name = document.createElement("strong");
  name.textContent = "You";

  let time = document.createElement("span");
  time.className = "Description"; 
  time.textContent = "Just now";

  let p = document.createElement("p");
  p.textContent = value;

  top.appendChild(name);
  top.appendChild(time);

  box.appendChild(top);
  box.appendChild(p);


  list.insertBefore(box, list.firstChild); 

  closeModal();
});


modal.addEventListener("click", function (event) {
  if (event.target === modal) closeModal();
});
