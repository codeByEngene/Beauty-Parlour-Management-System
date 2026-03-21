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

    // Check if user is logged in to link their ID
    $uid = (isset($_SESSION['uid']) && !empty($_SESSION['uid'])) ? $_SESSION['uid'] : "NULL";

    $query = mysqli_query($con,
        "INSERT INTO tblcontact(UserId, Name, Phone, Email, Message)
         VALUES ($uid, '$name', '$phone', '$email', '$message')"
    );

    if ($query) {
        echo "<script>alert('Your message was sent successfully!');</script>";
        echo "<script>window.location='contact.php'</script>";
    } else {
        echo "<script>alert('Something went wrong. Error: " . mysqli_error($con) . "');</script>";
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

    <form class="contact-form" method="POST"> 
        <div class="row">
            <input type="text" name="name" placeholder="Your Full Name" required>
        </div>

        <div class="row">
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <textarea name="message" placeholder="Type your message here..." required></textarea>

        <button type="submit" name="submit">Send Message</button>
    </form>
</section>

<?php include('includes/footer.php'); ?>

</body>
</html>