<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - BPMS</title>
    <link rel="stylesheet" href="style33.css">
    <link rel="stylesheet" href="include/header.css">
    <link rel="stylesheet" href="include/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<?php include('include/header.php');?>

    <!-- Banner Section -->
    <section class="banner">
        <div class="banner-content">
            <h1>Contact Us</h1>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="dashboard.php">Home</a> > <span>Contact</span>
    </div>

    <!-- Main Contact Section -->
    <section class="contact-section">

        <!-- Left Info -->
        <div class="contact-info">
            <div class="box">
                <h3> Call Us</h3>
                <p>+1- 2415903</p>
            </div>

            <div class="box">
                <h3> Email Us</h3>
                <p>parlour01@gmail.com</p>
            </div>

            <div class="box">
                <h3> Address</h3>
                <p>Thamel, 16 Kathmandu Nepal</p>
            </div>

            <div class="box">
                <h3> Time</h3>
                <p>10:00 am to 7:30 pm</p>
            </div>
        </div>

        <!-- Right Contact Form -->
        <form class="contact-form">
            <div class="row">
                <input type="text" placeholder="First Name">
                <input type="text" placeholder="Last Name">
            </div>

            <div class="row">
                <input type="text" placeholder="Phone">
                <input type="email" placeholder="Email">
            </div>

            <textarea placeholder="Message"></textarea>

            <button type="submit">Send Message</button>
        </form>

    </section>

 <?php include ('include/footer.php');?>

</body>
</html>
