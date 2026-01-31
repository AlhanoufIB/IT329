document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const adminBtn = document.getElementById("btnAdmin");

  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      e.preventDefault();
      window.location.href = "User.html";   // Phase 1 redirect
    });
  }

  if (adminBtn) {
    adminBtn.addEventListener("click", () => {
      window.location.href = "Admin.html";  // Phase 1 redirect
    });
  }

  const signupForm = document.getElementById("signupForm");
  if (signupForm) {
    signupForm.addEventListener("submit", (e) => {
      e.preventDefault();
      window.location.href = "User.html";   // Phase 1 redirect
    });
  }
});
