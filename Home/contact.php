<?php
session_start();
include('includes/dbconnection.php');

if(isset($_POST['submit'])) {

    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $phone   = mysqli_real_escape_string($con, $_POST['phone']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $query = mysqli_query($con,
        "INSERT INTO tblcontact(Name, Phone, Email, Message)
         VALUES ('$name','$phone','$email','$message')"
    );

    if ($query) {
        echo "<script>alert('Your message was sent successfully!');</script>";
        echo "<script>window.location='contact.php'</script>";
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - BPMS</title>
    <link rel="stylesheet" href="style3.css">
  <link rel="stylesheet" href="includes/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<?php include('includes/header.php');?>
    <!-- Banner Section -->
    <section class="banner">
        <div class="banner-content">
            <h1>Contact Us</h1>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="index.php">Home</a> > <span>Contact</span>
    </div>

    <!-- Main Contact Section -->
    <section class="contact-section">

        <!-- Left Info -->
        <div class="contact-info">
            <div class="box">
                <h3>Call Us</h3>
                <p>+1-2415903</p>
            </div>

            <div class="box">
                <h3>Email Us</h3>
                <p>parlour@gmail.com</p>
            </div>

            <div class="box">
                <h3> Address</h3>
                <p>Thamel, 16 Kathmandu Nepal</p>
            </div>

            <div class="box">
                <h3>Time</h3>
                <p>10:00 am to 8:30 pm</p>
            </div>
        </div>

        <!-- Right Contact Form -->
        <!-- Right Contact Form -->
<form class="contact-form" method="post" action="">
    <div class="row">
        <input type="text" name="name" placeholder="Name" required>
    </div>

    <div class="row">
        <input type="text" name="phone" placeholder="Phone" required>
        <input type="email" name="email" placeholder="Email" required>
    </div>

    <textarea name="message" placeholder="Message" required></textarea>

    <button type="submit" name="submit">Send Message</button>
</form>

    </section>
 <?php include('includes/footer.php');?>
</body>
</html>
