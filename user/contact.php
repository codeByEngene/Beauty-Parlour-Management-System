<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Assuming your user-side connection file is in the 'include' or 'includes' folder
include('include/dbconnection.php'); 

// 1. FETCH DYNAMIC CONTENT FROM ADMIN UPDATES
// This selects the exact row the Admin updates (WHERE PageType='contactus')
$ret = mysqli_query($con, "SELECT * FROM tblpages WHERE PageType='contactus'");
$row = mysqli_fetch_array($ret);

// 2. HANDLE ENQUIRY FORM SUBMISSION
if(isset($_POST['submit'])) {
    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $phone   = mysqli_real_escape_string($con, $_POST['phone']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Link inquiry to logged-in user if session exists
    $uid = (isset($_SESSION['uid']) && !empty($_SESSION['uid'])) ? $_SESSION['uid'] : "NULL";

    $query = mysqli_query($con,
        "INSERT INTO tblcontact(UserId, Name, Phone, Email, Message)
         VALUES ($uid, '$name', '$phone', '$email', '$message')"
    );

    if ($query) {
        echo "<script>alert('Your message was sent successfully!');</script>";
        echo "<script>window.location='contact.php'</script>";
    } else {
        echo "<script>alert('Error sending message. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['PageTitle']; ?> | BPMS</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="include/header.css">
    <link rel="stylesheet" href="include/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<?php include('include/header.php'); ?>

<div class="banner">
    <div class="banner-content">
        <h1><?php echo $row['PageTitle']; ?></h1>
    </div>
</div>

<section class="contact-section">
    <div class="contact-info">
        <div class="box">
            <h3><i class="fa fa-phone" style="color:#f1921d;"></i> Call Us</h3>
            <p><?php echo $row['MobileNumber']; ?></p>
        </div>

        <div class="box">
            <h3><i class="fa fa-envelope" style="color:#f1921d;"></i> Email Us</h3>
            <p><?php echo $row['Email']; ?></p>
        </div>

        <div class="box">
            <h3><i class="fa fa-map-marker-alt" style="color:#f1921d;"></i> Address</h3>
            <p><?php echo $row['PageDescription']; ?></p>
        </div>

        <div class="box">
            <h3><i class="fa fa-clock" style="color:#f1921d;"></i> Working Hours</h3>
            <p><?php echo $row['Timing']; ?></p>
        </div>
    </div>

    <form class="contact-form" method="POST"> 
        <div class="row">
            <input type="text" name="name" placeholder="Your Name" required>
        </div>

        <div class="row">
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <textarea name="message" placeholder="How can we help you?" required></textarea>

        <button type="submit" name="submit">Send Message</button>
    </form>
</section>

<?php include ('include/footer.php'); ?>

</body>
</html>