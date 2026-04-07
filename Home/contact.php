<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

// 1. Fetch Contact Page Content
$ret = mysqli_query($con, "SELECT * FROM tblpages WHERE PageType='contactus'");
$row = mysqli_fetch_array($ret);

// 2. Handle Form Submission
if(isset($_POST['submit'])) {
    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $phone   = mysqli_real_escape_string($con, $_POST['phone']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $uid = (isset($_SESSION['uid']) && !empty($_SESSION['uid'])) ? $_SESSION['uid'] : "NULL";

    $query = mysqli_query($con,
        "INSERT INTO tblcontact(UserId, Name, Phone, Email, Message)
         VALUES ($uid, '$name', '$phone', '$email', '$message')"
    );

    if ($query) {
        echo "<script>alert('Your message was sent successfully!');</script>";
        echo "<script>window.location='contact.php'</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Beauty Parlour Management System</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="includes/header.css">
    <link rel="stylesheet" href="includes/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <style>
        /* Real-time Warning Styles */
        .input-group {
            width: 100%;
            margin-bottom: 15px;
            position: relative;
        }
        .input-warning {
            color: #d9534f;
            font-size: 0.8rem;
            margin-top: 4px;
            display: none; /* Hidden by default */
            font-weight: bold;
        }
        input.invalid {
            border: 2px solid #d9534f !important;
        }
        input.valid {
            border: 2px solid #5cb85c !important;
        }
    </style>

    <script>
        function validateInputs() {
            const nameInput = document.getElementById('name');
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');

            // 1. Name Validation: Block numbers/special chars
            nameInput.oninput = function() {
                const warning = document.getElementById('nameWarning');
                if (/[^a-zA-Z\s]/.test(this.value)) {
                    warning.style.display = "block";
                    this.classList.add('invalid');
                } else {
                    warning.style.display = "none";
                    this.classList.remove('invalid');
                }
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            };

            // 2. Phone Validation: Nepal Specific (98/97 and 10 digits)
            phoneInput.oninput = function() {
                const warning = document.getElementById('phoneWarning');
                this.value = this.value.replace(/[^0-9]/g, ''); // Block letters
                
                if (this.value.length > 0 && !/^(98|97)/.test(this.value)) {
                    warning.innerText = "Number must start with 98 or 97";
                    warning.style.display = "block";
                    this.classList.add('invalid');
                } else if (this.value.length > 0 && this.value.length < 10) {
                    warning.innerText = "Enter exactly 10 digits";
                    warning.style.display = "block";
                    this.classList.add('invalid');
                } else {
                    warning.style.display = "none";
                    this.classList.remove('invalid');
                    if(this.value.length === 10) this.classList.add('valid');
                }

                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            };

            // 3. Email Validation: Real-time pattern
            emailInput.oninput = function() {
                const warning = document.getElementById('emailWarning');
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                
                if (this.value.length > 0 && !emailPattern.test(this.value)) {
                    warning.style.display = "block";
                    this.classList.add('invalid');
                    this.classList.remove('valid');
                } else if (this.value.length > 0) {
                    warning.style.display = "none";
                    this.classList.remove('invalid');
                    this.classList.add('valid');
                }
            };
        }

        // Final validation before PHP processing
        function checkForm() {
            const phone = document.getElementById('phone').value;
            const email = document.getElementById('email').value;
            const nepalPattern = /^(98|97)\d{8}$/;
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (!nepalPattern.test(phone)) {
                alert("Please enter a valid 10-digit Nepal mobile number (98/97).");
                return false;
            }
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }
            return true;
        }

        window.onload = validateInputs;
    </script>
</head>
<body>

<?php include('includes/header.php'); ?>

<div class="banner">
    <div class="banner-content">
        <h1>Contact Us</h1>
    </div>
</div>

<section class="contact-section">
    <div class="contact-info">
        <div class="box">
            <h3><i class="fa fa-phone"></i> Call Us</h3>
            <p><?php echo $row['MobileNumber']; ?></p>
        </div>
        <div class="box">
            <h3><i class="fa fa-envelope"></i> Email Us</h3>
            <p><?php echo $row['Email']; ?></p>
        </div>
        <div class="box">
            <h3><i class="fa fa-map-marker-alt"></i> Address</h3>
            <p><?php echo $row['PageDescription']; ?></p>
        </div>
        <div class="box">
            <h3><i class="fa fa-clock"></i> Working Hours</h3>
            <p><?php echo $row['Timing']; ?></p>
        </div>
    </div>

    <form class="contact-form" method="POST" onsubmit="return checkForm()"> 
        <div class="row">
            <div class="input-group">
                <input type="text" name="name" id="name" placeholder="Your Full Name" required>
                <span id="nameWarning" class="input-warning">Please use letters and spaces only.</span>
            </div>
        </div>

        <div class="row">
            <div class="input-group" style="width: 48%;">
                <input type="text" name="phone" id="phone" placeholder="Phone (98XXXXXXXX)" required>
                <span id="phoneWarning" class="input-warning">Invalid Nepal mobile format.</span>
            </div>
            <div class="input-group" style="width: 48%;">
                <input type="email" name="email" id="email" placeholder="Email Address" required>
                <span id="emailWarning" class="input-warning">Enter a valid email (e.g. name@gmail.com).</span>
            </div>
        </div>

        <textarea name="message" placeholder="Type your message here..." required></textarea>

        <button type="submit" name="submit">Send Message</button>
    </form>
</section>

<?php include('includes/footer.php'); ?>

</body>
</html>