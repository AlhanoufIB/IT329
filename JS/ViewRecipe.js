let openBtn = document.getElementById("AddComment");
let modal = document.getElementById("CommentModal");
let cancelBtn = document.getElementById("CancelModal");

function openModal() {
  modal.classList.remove("Hidden");
}

function closeModal() {
  modal.classList.add("Hidden");
}

openBtn.addEventListener("click", openModal);
cancelBtn.addEventListener("click", closeModal);

modal.addEventListener("click", function (event) {
  if (event.target === modal) {
    closeModal();
  }
});