<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="include/header.css">
  <link rel="stylesheet" href="include/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body>
<?php include('include/header.php');?>
<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-overlay">
        <h1>Book Appointment</h1>
        <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            Hic fuga sit illo modi aut aspernatur tempore laboriosam.
        </p>
    </div>
</section>

<!-- BREADCRUMB -->
<div class="breadcrumb">
    <a href="dashboard.php">Home</a> <span>›</span> <span>Book Appointment</span>
</div>

<!-- APPOINTMENT SECTION -->
<section class="appointment">
    <div class="container">

        <!-- LEFT INFO -->
        <div class="info">
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <div>
                    <h4>Call Us</h4>
                    <p>+1-</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <h4>Email Us</h4>
                    <p>parlour01@gmail.com</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-location-dot"></i>
                <div>
                    <h4>Address</h4>
                    <p>Kathmandu 16,Sorakhutte<br>Nepal</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fas fa-clock"></i>
                <div>
                    <h4>Time</h4>
                    <p>10:30 am to 7:30 pm</p>
                </div>
            </div>
        </div>

        <!-- RIGHT FORM -->
        <div class="form-box">
            <form>
                <label>Appointment Date</label>
                <input type="date">

                <label>Appointment Time</label>
                <input type="time">

                <label>Message</label>
                <textarea placeholder="Message"></textarea>

                <button type="submit">Make an Appointment</button>
            </form>
        </div>

    </div>
</section>
<?php include ('include/footer.php');?>
</body>
</html>
