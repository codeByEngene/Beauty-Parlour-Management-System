/**
 * The above JavaScript functions are designed to validate user input for a form, including restrictions on input types, password strength, and matching passwords, with a final validation function to check for any errors before form submission.
 * @param e - The `e` parameter in the functions `restrictToLetters` and `restrictToNumbers` represents the event object that is passed when an event occurs, such as a key press. This object contains information about the event, including the key code of the key that was pressed (which can be accessed
 * @returns The `validateForm` function is returning a boolean value. It returns `true` if all the form fields pass validation checks, and it returns `false` if any of the validation checks fail.
 */
function restrictToLetters(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    let error = document.getElementById("nameError");

    if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32) {
        error.textContent = ""; 
        return true;
    }
    error.style.color = "#e74c3c"; 
    error.textContent = "Numbers and symbols are not allowed!";
    return false; 
}

function restrictToNumbers(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    var input = document.getElementById("mobilenumber").value;
    let error = document.getElementById("phoneError");

    if (charCode >= 48 && charCode <= 57) {
        if (input.length >= 10) {
            error.textContent = "Maximum 10 digits allowed.";
            return false; 
        }
        error.textContent = ""; 
        return true;
    }
    error.style.color = "#e74c3c";
    error.textContent = "Letters and symbols are not allowed!";
    return false;
}

function validatePass() {
    let pass = document.getElementById("password").value;
    let error = document.getElementById("passError");
    
    if (pass.length === 0) {
        error.textContent = "";
        return;
    }

    let hasLetters = /[a-zA-Z]/.test(pass);
    let hasNumbers = /\d/.test(pass);
    let hasSpecial = /[!@#$%^&*]/.test(pass);

    if (pass.length < 6) {
        error.style.color = "#e74c3c";
        error.textContent = "Password is too short (min 6 characters).";
    } else if (pass.length < 10 || !(hasLetters && hasNumbers && hasSpecial)) {
        error.style.color = "#f39c12";
        error.textContent = "Use characters with a symbol (e.g. @, #, $) to make it strong.";
    } else {
        error.style.color = "#27ae60"; 
        error.textContent = "Great! That is a strong password.";
    }
    // Check match whenever the original password changes
    validateConfirmPass();
}

// New function for Confirm Password
function validateConfirmPass() {
    let pass = document.getElementById("password").value;
    let confirm = document.getElementById("repeatpassword").value;
    let error = document.getElementById("confirmPassError");

    if (confirm === "") {
        error.textContent = "";
        return false;
    }

    if (pass !== confirm) {
        error.style.color = "#e74c3c";
        error.textContent = "Passwords do not match!";
        return false;
    } else {
        error.style.color = "#27ae60";
        error.textContent = "Passwords match.";
        return true;
    }
}

function validateName() {
    let name = document.getElementById("fullname").value;
    let error = document.getElementById("nameError");
    if(name.length >= 2) error.textContent = ""; 
}

function validateEmail() {
    let email = document.getElementById("email").value;
    let error = document.getElementById("emailError");
    let regex = /^\S+@\S+\.\S+$/;
    if (email === "") {
        error.textContent = "";
    } else if (!regex.test(email)) {
        error.style.color = "#e74c3c";
        error.textContent = "Please enter a valid email (e.g. name@mail.com).";
    } else {
        error.textContent = "";
    }
}

function validatePhone() {
    let phone = document.getElementById("mobilenumber").value;
    let error = document.getElementById("phoneError");
    if(phone.length === 0) {
        error.textContent = "";
    } else if(phone.length < 10) {
        error.style.color = "#e74c3c";
        error.textContent = "Phone number must be 10 digits.";
    } else {
        error.textContent = "";
    }
}

function validateForm() {
    validateName();
    validateEmail();
    validatePhone();
    validatePass();
    let isMatch = validateConfirmPass(); // Added match check

    const errors = ["nameError", "emailError", "phoneError", "passError", "confirmPassError"];
    for (let id of errors) {
        let msg = document.getElementById(id).textContent;
        if (msg.includes("not allowed") || msg.includes("too short") || msg.includes("valid email") || msg.includes("not match")) {
            alert("Please correct the errors before submitting.");
            return false;
        }
    }
    return true;
}

    // Toggle for the first Password field
    document.querySelector('#togglePassword').addEventListener('click', function () {
        const passwordInput = document.querySelector('#password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
    
    // Toggle for the Confirm Password field (Add this part)
    document.querySelector('#toggleConfirmPassword').addEventListener('click', function () {
        const confirmInput = document.querySelector('#repeatpassword');
        const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });