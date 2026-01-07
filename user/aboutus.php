<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Beauty Parlour Management System</title>

  <!-- CSS -->
  <link rel="stylesheet" href="style11.css">
  <link rel="stylesheet" href="include/header.css">
  <link rel="stylesheet" href="include/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body>
<?php include('include/header.php');?>

<!--  HEADER BANNER  -->
<div class="header-banner">
  <h1>About Us</h1>
</div>
<!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="dashboard.php">Home</a> > <span>about</span>
    </div>
<!--  SERVICES SECTION  -->
<section class="services-section">
  <div class="service-image">
    <img src="images/ab-3.jpeg" alt="Service Makeup Items">
  </div>

  <div class="services-list">
    <h2>Beauty and success starts here</h2>
    <div class="service-columns">
      <ul>
        <li>Waxing</li>
        <li>Hair Makeup</li>
        <li>Manicure</li>
        <li>Hair Cut</li>
      </ul>
      <ul>
        <li>Facial</li>
        <li>Massage</li>
        <li>Pedicure</li>
        <li>Body Spa</li>
      </ul>
    </div>
  </div>
</section>

<!--  ABOUT MAIN SECTION  -->
<section class="about-main">
  <div class="about-text">
    <h2>About Us</h2>
    <p>
      Our main focus is on quality and hygiene. Our parlour is well equipped
      with advanced technology equipment and provides best quality services.<br><br>
      Our staff is well trained and experienced, offering advanced services in
      Skin, Hair and Body Shaping that will provide you with a luxurious
      experience that leaves you relaxed and stress-free.<br><br>
      We specialize in bridal makeup, fashion hair coloring, facials,
      hairstyles, and complete beauty solutions.
    </p>
  </div>

  <div class="about-image">
    <img src="images/ab-2.jpeg" alt="Beauty Products">
  </div>
</section>

<?php include ('include/footer.php');?>


</body>
</html>
