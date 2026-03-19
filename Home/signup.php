<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {

    $fname    = $_POST['fname'];
    $mobile   = $_POST['phone'];
    $email    = $_POST['email'];
    $role     = $_POST['role'];
    $password = md5($_POST['password']);

    $check = mysqli_query($con,
        "SELECT ID FROM tblusers 
         WHERE Email='$email' OR MobileNumber='$mobile'"
    );

    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email or Mobile already exists');</script>";
    } else {

        $query = mysqli_query($con,
            "INSERT INTO tblusers (FullName, MobileNumber, Email, Password, Role)
             VALUES ('$fname', '$mobile', '$email', '$password', '$role')"
        );

        if ($query) {
            echo "<script>alert('Registration Successful');</script>";
            echo "<script>window.location='login.php';</script>";
        } else {
            echo "<script>alert('Something went wrong');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">

    <style>
        .error {
            color: red;
            font-size: 12px;
            margin-top: 3px;
        }
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
        <form method="POST" onsubmit="return validateForm()">

            <h1 class="title">Sign Up</h1>

            <!-- FULL NAME -->
            <div class="input-field">
                <label>Full Name</label>
                <input type="text" name="fname" id="fname" placeholder="eg. Anjana Shrestha" required>
                <small id="nameError" class="error"></small>
            </div>

            <!-- EMAIL -->
            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" id="email" placeholder="eg. anjana@gmail.com" required>
                <small id="emailError" class="error"></small>
            </div>

            <!-- PHONE -->
            <div class="input-field">
                <label>Phone Number</label>
                <input type="tel" name="phone" id="phone" required>
                <small id="phoneError" class="error"></small>
            </div>

            <!-- PASSWORD -->
            <div class="input-field">
                <label>Password</label>
                <input type="password" name="password" id="password" required>
                <small id="passError" class="error"></small>
            </div>

            <!-- ROLE -->
            <div class="role-based">
                <label>Role</label>
                <select name="role" id="role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <small id="roleError" class="error"></small>
            </div>

            <div class="btn-sign">
                <button type="submit" name="submit">Create Account</button>
            </div>

            <p class="login-link">
                Already have an account? <a href="login.php">Login</a>
            </p>

        </form>
    </div>
</div>

<!-- ================= REAL TIME VALIDATION ================= -->

<script>
const nameInput = document.getElementById("fname");
const emailInput = document.getElementById("email");
const phoneInput = document.getElementById("phone");
const passInput  = document.getElementById("password");
const roleInput  = document.getElementById("role");

// NAME validation (no numbers)
nameInput.addEventListener("input", function () {
    const nameError = document.getElementById("nameError");
    const regex = /^[A-Za-z\s]+$/;

    if (!regex.test(this.value)) {
        nameError.textContent = "Name cannot contain numbers or symbols";
    } else {
        nameError.textContent = "";
    }
});

// EMAIL validation
emailInput.addEventListener("input", function () {
    const emailError = document.getElementById("emailError");
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!regex.test(this.value)) {
        emailError.textContent = "Invalid email format";
    } else {
        emailError.textContent = "";
    }
});

// PHONE validation (numbers only)
phoneInput.addEventListener("input", function () {
    const phoneError = document.getElementById("phoneError");
    const regex = /^[0-9]{10,15}$/;

    if (!regex.test(this.value)) {
        phoneError.textContent = "Phone must be 10–15 digits only";
    } else {
        phoneError.textContent = "";
    }
});

// PASSWORD validation
passInput.addEventListener("input", function () {
    const passError = document.getElementById("passError");

    if (this.value.length < 6) {
        passError.textContent = "Password must be at least 6 characters";
    } else {
        passError.textContent = "";
    }
});

// FINAL FORM CHECK
function validateForm() {

    if (document.getElementById("nameError").textContent ||
        document.getElementById("emailError").textContent ||
        document.getElementById("phoneError").textContent ||
        document.getElementById("passError").textContent) {

        alert("Please fix errors before submitting");
        return false;
    }

    return true;
}
</script>

</body>
</html>