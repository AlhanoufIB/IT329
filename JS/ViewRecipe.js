// Phase 1: simple front-end comment add (newest -> oldest)

const openBtn = document.getElementById("OpenComment");
const modal = document.getElementById("CommentModal");
const closeBtn = document.getElementById("CloseModal");
const cancelBtn = document.getElementById("CancelModal");
const form = document.getElementById("CommentForm");
const text = document.getElementById("CommentText");
const list = document.getElementById("CommentsList");

function openModal() {
    modal.classList.remove("Hidden");
    text.value = "";
    text.focus();
}

function closeModal() {
    modal.classList.add("Hidden");
}

openBtn.addEventListener("click", openModal);
closeBtn.addEventListener("click", closeModal);
cancelBtn.addEventListener("click", closeModal);

form.addEventListener("submit", function (e) {
    e.preventDefault();

    const value = text.value.trim();
    if (value === "") return;

    const box = document.createElement("div");
    box.className = "CommentBox";
    box.innerHTML = `
        <div class="CommentTop">
            <strong>You</strong>
            <span class="MutedText">Just now</span>
        </div>
        <p></p>
    `;
    box.querySelector("p").textContent = value;

    // Newest comment appears first
    list.prepend(box);
    closeModal();
});

// Close modal when clicking outside
modal.addEventListener("click", function (e) {
    if (e.target === modal) {
        closeModal();
    }
});
