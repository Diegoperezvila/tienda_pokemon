const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");
const errorDiv = document.getElementById("passwordError");
const submitBtn = document.getElementById("submitBtn");

function validatePassword() {
    if (password.value === confirmPassword.value && password.value !== "") {
        errorDiv.style.display = "none";
        submitBtn.disabled = false;
    } else {
        errorDiv.style.display = "block";
        submitBtn.disabled = true;
    }
}

password.addEventListener("input", validatePassword);
confirmPassword.addEventListener("input", validatePassword);