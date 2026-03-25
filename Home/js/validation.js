// --- 1. KEY RESTRICTION FUNCTIONS ---

// Only allows Letters (A-Z, a-z) and Spaces
function restrictToLetters(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    // Allow: A-Z (65-90), a-z (97-122), Space (32)
    if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32) {
        return true;
    }
    return false; // Blocks numbers and symbols
}

// Only allows Numbers (0-9) and limits to 10 digits
function restrictToNumbers(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    var input = document.getElementById("mobilenumber").value;

    // Allow: 0-9 (48-57)
    if (charCode >= 48 && charCode <= 57) {
        // Check if length is already 10
        if (input.length >= 10) {
            return false; // Blocks the 11th digit
        }
        return true;
    }
    return false; // Blocks letters and symbols
}

// --- 2. VISUAL VALIDATION (ONKEYUP) ---

function validateName() {
    let name = document.getElementById("fullname").value;
    let error = document.getElementById("nameError");
    error.textContent = (name.length > 0 && name.length < 2) ? "Name must be at least 2 characters." : "";
}

function validateEmail() {
    let email = document.getElementById("email").value;
    let error = document.getElementById("emailError");
    let regex = /^\S+@\S+\.\S+$/;
    error.textContent = (email !== "" && !regex.test(email)) ? "Please enter a valid email address." : "";
}

function validatePhone() {
    let phone = document.getElementById("mobilenumber").value;
    let error = document.getElementById("phoneError");
    error.textContent = (phone !== "" && phone.length < 10) ? "Phone must be exactly 10 digits." : "";
}

function validatePass() {
    let pass = document.getElementById("password").value;
    let error = document.getElementById("passError");
    error.textContent = (pass !== "" && pass.length < 6) ? "Password must be at least 6 characters." : "";
}

// Password Visibility
document.querySelector('#togglePassword').addEventListener('click', function () {
    const passwordInput = document.querySelector('#password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});

// Final Submit Check
function validateForm() {
    validateName();
    validateEmail();
    validatePhone();
    validatePass();

    if (document.getElementById("nameError").textContent || 
        document.getElementById("emailError").textContent ||
        document.getElementById("phoneError").textContent || 
        document.getElementById("passError").textContent) {
        alert("Please correct the errors before submitting.");
        return false;
    }
    return true;
}