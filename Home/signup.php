<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection logic
if(file_exists('includes/dbconnection.php')){
    include('includes/dbconnection.php');
} else {
    // Fallback if the folder name is different
    @include('include/dbconnection.php'); 
}

if (isset($_POST['submit'])) {
    $fname      = mysqli_real_escape_string($con, $_POST['fullname']); 
    $mobile     = mysqli_real_escape_string($con, $_POST['mobilenumber']); 
    $email      = mysqli_real_escape_string($con, $_POST['email']);
    $password   = $_POST['password'];
    $repeatpass = $_POST['repeatpassword']; 
    $role       = "user"; 

    // Server-side validation (PHP)
    if(strlen($fname) < 2) {
        echo "<script>alert('Name must be at least 2 characters');</script>";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid Email Format');</script>";
    } elseif(!preg_match('/^9[78][0-9]{8}$/', $mobile)) {
        echo "<script>alert('Please enter a valid 10-digit mobile number starting with 98 or 97');</script>";
    } elseif(strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters');</script>";
    } elseif($password !== $repeatpass) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $hashed_password = md5($password);
        $check = mysqli_query($con, "SELECT id FROM tblusers WHERE email='$email' OR MobileNumber='$mobile'");

        if (mysqli_num_rows($check) > 0) {
            echo "<script>alert('Email or Mobile already exists');</script>";
        } else {
            $query = mysqli_query($con, "INSERT INTO tblusers (FullName, MobileNumber, email, password, role) 
                                         VALUES ('$fname', '$mobile', '$email', '$hashed_password', '$role')");
            if ($query) {
                echo "<script>alert('Registration Successful!'); window.location='login.php';</script>";
            } else {
                echo "<script>alert('Error. Please try again.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | BPMS</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .error { color: #e74c3c; font-size: 12px; margin-top: 3px; display: block; font-weight: bold;}
        .input-field { position: relative; margin-bottom: 15px; }
        .fa-eye { position: absolute; right: 10px; top: 38px; cursor: pointer; color: #7f8c8d; }
    </style>
</head>
<body>
<div id="signup">
    <div class="img">
        <div class="logo">
            <h1>Beauty Parlour<br>Management System</h1>
        </div>
    </div>
    <div id="form-wrapper">
        <form method="POST" id="signupForm" onsubmit="return validateForm()">
            <h1 class="title">Sign Up</h1>
            
            <div class="input-field">
                <label>Full Name</label>
                <input type="text" name="fullname" id="fullname" placeholder="Anjana Shrestha" required 
                       onkeypress="return restrictToLetters(event)" onkeyup="validateName()">
                <small id="nameError" class="error"></small>
            </div>

            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" id="email" placeholder="eg. anjana@gmail.com" required onkeyup="validateEmail()">
                <small id="emailError" class="error"></small>
            </div>

            <div class="input-field">
                <label>Phone Number</label>
                <input type="tel" name="mobilenumber" id="mobilenumber" placeholder="98XXXXXXXX" maxlength="10" required 
                       onkeypress="return restrictToNumbers(event)" onkeyup="validatePhone()">    
                <small id="phoneError" class="error"></small>
            </div>

            <div class="input-field">
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required onkeyup="validatePass()">
                <i class="fa fa-eye" id="togglePassword"></i>
                <small id="passError" class="error"></small>
            </div>
 
            <div class="input-field"> 
                <label>Confirm Password</label>
                <input type="password" name="repeatpassword" id="repeatpassword" placeholder="Confirm your password" required onkeyup="validateConfirmPass()">
                <i class="fa fa-eye" id="toggleConfirmPassword"></i>
                <small id="confirmPassError" class="error"></small>
            </div>

            <div class="btn-sign">
                <button type="submit" name="submit">Create Account</button>
            </div>
            <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</div>

<script>
// --- Input Restrictions ---
function restrictToLetters(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    let error = document.getElementById("nameError");
    if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode == 32) {
        error.textContent = ""; 
        return true;
    }
    error.textContent = "Numbers and symbols are not allowed!";
    return false; 
}

function restrictToNumbers(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    var input = document.getElementById("mobilenumber").value;
    let error = document.getElementById("phoneError");

    if (charCode >= 48 && charCode <= 57) {
        // ALLOW up to 10 digits. Block 11th.
        if (input.length >= 10) {
            return false; 
        }
        error.textContent = ""; 
        return true;
    }
    error.textContent = "Letters and symbols are not allowed!";
    return false;
}

// --- Real-time Validation ---
function validateName() {
    let name = document.getElementById("fullname").value;
    let error = document.getElementById("nameError");
    error.textContent = (name.length >= 2) ? "" : "Name too short."; 
}

function validateEmail() {
    let email = document.getElementById("email").value;
    let error = document.getElementById("emailError");
    let regex = /^\S+@\S+\.\S+$/;
    error.textContent = (regex.test(email)) ? "" : "Please enter a valid email. For example: anjana@gmail.com";
}

function validatePhone() {
    let phone = document.getElementById("mobilenumber").value;
    let error = document.getElementById("phoneError");
    let nepalRegex = /^9[78]\d{8}$/;

    if (phone.length < 10) {
        error.style.color = "#e74c3c";
        error.textContent = "Phone number must be 10 digits.";
    } else if (!nepalRegex.test(phone)) {
        error.style.color = "#e74c3c";
        error.textContent = "Invalid Mobile number (must start with 98 or 97).";
    } else {
        error.style.color = "#2ecc71";
        error.textContent = "Valid Mobile number.";
    }
}

function validatePass() {
    let pass = document.getElementById("password").value;
    let error = document.getElementById("passError");
    if (pass.length < 6) {
        error.style.color = "#e74c3c";
        error.textContent = "Password too short (min 6).";
    } else {
        error.style.color = "#27ae60";
        error.textContent = "Strong password.";
    }
    validateConfirmPass();
}

function validateConfirmPass() {
    let pass = document.getElementById("password").value;
    let confirm = document.getElementById("repeatpassword").value;
    let error = document.getElementById("confirmPassError");
    if (confirm === "") return false;

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

// --- Final Form Check ---
function validateForm() {
    validateName(); validateEmail(); validatePhone(); validatePass();
    
    const errors = ["nameError", "emailError", "phoneError", "passError", "confirmPassError"];
    for (let id of errors) {
        let msg = document.getElementById(id).textContent;
        if (msg !== "" && !msg.includes("match") && !msg.includes("Strong") && !msg.includes("Valid")) {
            alert("Please correct the errors: " + msg);
            return false;
        }
    }
    return true;
}

// --- Password Visibility Toggles ---
document.querySelector('#togglePassword').addEventListener('click', function () {
    const input = document.querySelector('#password');
    input.type = input.type === 'password' ? 'text' : 'password';
    this.classList.toggle('fa-eye-slash');
});

document.querySelector('#toggleConfirmPassword').addEventListener('click', function () {
    const input = document.querySelector('#repeatpassword');
    input.type = input.type === 'password' ? 'text' : 'password';
    this.classList.toggle('fa-eye-slash');
});
</script>
</body>
</html>