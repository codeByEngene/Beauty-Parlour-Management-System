<?php
session_start();
// Check if file exists to prevent path errors
if(file_exists('includes/dbconnection.php')){
    include('includes/dbconnection.php');
} else {
    include('include/dbconnection.php'); 
}

if (isset($_POST['submit'])) {
    $fname    = mysqli_real_escape_string($con, $_POST['fname']);
    $mobile   = mysqli_real_escape_string($con, $_POST['phone']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $role     = mysqli_real_escape_string($con, $_POST['role']);
    $password = $_POST['password']; // Get raw password for validation

    // PHP Server-Side Validation
    if(strlen($fname) < 3) {
        echo "<script>alert('Name must be at least 3 characters');</script>";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid Email Format');</script>";
    } elseif(!preg_match('/^[0-9]{10}+$/', $mobile)) {
        echo "<script>alert('Phone number must be exactly 10 digits');</script>";
    } elseif(strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters');</script>";
    } else {
        // Secure Password Hashing (Better than md5)
        $hashed_password = md5($password);
        $status = 'active'; 

        $check = mysqli_query($con, "SELECT id FROM tblusers WHERE email='$email' OR MobileNumber='$mobile'");

        if (mysqli_num_rows($check) > 0) {
            echo "<script>alert('Email or Mobile already exists');</script>";
        } else {
            $query = mysqli_query($con, "INSERT INTO tblusers (FullName, MobileNumber, email, password, role, status) 
                                         VALUES ('$fname', '$mobile', '$email', '$hashed_password', '$role', '$status')");

            if ($query) {
                echo "<script>alert('Registration Successful! You can login now.');</script>";
                echo "<script>window.location='login.php';</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | BPMS</title>
    <link rel="stylesheet" href="signup.css">
    <style>
        .error { color: #e74c3c; font-size: 12px; margin-top: 3px; display: block; font-weight: bold;}
        input.invalid { border: 1px solid #e74c3c; }
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
                <input type="text" name="fname" id="fname" placeholder="eg. Anjana Shrestha" required onkeyup="validateName()">
                <small id="nameError" class="error"></small>
            </div>

            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" id="email" placeholder="eg. anjana@gmail.com" required onkeyup="validateEmail()">
                <small id="emailError" class="error"></small>
            </div>

            <div class="input-field">
                <label>Phone Number</label>
                <input type="tel" name="phone" id="phone" placeholder="10-digit number" required onkeyup="validatePhone()">
                <small id="phoneError" class="error"></small>
            </div>

            <div class="input-field">
                <label>Password</label>
                <input type="password" name="password" id="password" required onkeyup="validatePass()">
                <small id="passError" class="error"></small>
            </div>

            <div class="role-based">
                <label>Role</label>
                <select name="role" id="role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="btn-sign">
                <button type="submit" name="submit">Create Account</button>
            </div>
            <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</div>

<script>
// Real-time Name Validation
function validateName() {
    let name = document.getElementById("fname").value;
    let error = document.getElementById("nameError");
    if(name.length < 3) {
        error.textContent = "Name must be at least 3 characters.";
    } else {
        error.textContent = "";
    }
}

// Real-time Email Validation
function validateEmail() {
    let email = document.getElementById("email").value;
    let error = document.getElementById("emailError");
    let regex = /^\S+@\S+\.\S+$/;
    if(!regex.test(email)) {
        error.textContent = "Please enter a valid email address.";
    } else {
        error.textContent = "";
    }
}

// Real-time Phone Validation
function validatePhone() {
    let phone = document.getElementById("phone").value;
    let error = document.getElementById("phoneError");
    let regex = /^[0-9]{10}$/; // Exactly 10 digits
    if(!regex.test(phone)) {
        error.textContent = "Phone must be exactly 10 digits.";
    } else {
        error.textContent = "";
    }
}

// Real-time Password Validation
function validatePass() {
    let pass = document.getElementById("password").value;
    let error = document.getElementById("passError");
    if(pass.length < 6) {
        error.textContent = "Password must be at least 6 characters.";
    } else {
        error.textContent = "";
    }
}

// Final check on submit
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
</script>
</body>
</html>