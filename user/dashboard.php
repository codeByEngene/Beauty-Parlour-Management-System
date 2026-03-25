<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['bpmsaid']) || strlen($_SESSION['bpmsaid']) == 0) {
    header('location:../index.php'); 
    exit();
}
$fullname = $_SESSION['fullname'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beauty Parlour | User Dashboard</title>

  <link rel="stylesheet" href="style1.css">
  <link rel="stylesheet" href="include/header.css">
  <link rel="stylesheet" href="include/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
<?php 
include('include/header.php');
?>

  <div class="slideshow">
    <div class="slide">
      <img src="images/bg1.jpg" alt="Slide 1" />
      <div class="caption">
        <h2>Welcome, <?php echo htmlspecialchars($fullname); ?></h2>
        <p>Experience the best beauty services with us.</p>
        <a href="../get-appointment.php" class="btn">Get Appointment</a>
      </div>
    </div>

    <div class="slide">
      <img src="images/bg2.jpg" alt="Slide 2" />
      <div class="caption">
        <h2>Our Premium Services</h2>
        <p>Professional care for your beauty and wellness.</p>
        <a href="get-appointment.php" class="btn">Get Appointment</a>
      </div>
    </div>
  </div>

  <section class="parlour">
    <h1>Our Salon Premium Services</h1>
    <p>Anua Hair and Beauty Salon offers a wide range of beauty services.</p>

    <div class="row">
      <div class="parlour-col">
        <img src="images/O3+ Radiant & Glow Bridal Facial.jpg" alt="Service 1" />
        <h2>O3+ Radiant & Glow Bridal Facial</h2>
         <p>The brand focuses on ingredient technology, clinical studies, and providing professional-grade skincare solutions like facial kits, serums, and packs, with a headquarters in Noida, India.</p>
         <p class="price">Cost of Service: rs1200</p>
          <a href="services.php" class="btn">Read More</a>
          <div class="layer"></div>
      </div>

      <div class="parlour-col">
        <img src="images/Fruit Facial.jpg" alt="Service 2" />
        <h2>Fruit Facial</h2>
        <p>Natural fruit-based facial for glowing skin.</p> 
        <p class="price">Cost of Service: rs.500</p>
         <a href="services.php" class="btn">Read More</a>
        <div class="layer"></div>
      </div>

      <div class="parlour-col">
        <img src="images/Charcoal Facial.jpg" alt="Service 3" />
        <h2>Charcoal Facial</h2>
        <p>Deep cleansing facial with activated charcoal.</p> 
        <p class="price">Cost of Service: rs.1000</p>
         <a href="services.php" class="btn">Read More</a>
        <div class="layer"></div>
      </div>
    </div>
  </section>

  <div class="image-container">
    <div class="overlay"></div>
    <div class="text-content">
      <h1>Come Experience the Secrets of Relaxation</h1>
      <h2>
        Best beauty expert at your home and provides beauty salon at home. 
        Home salon provide well trained beauty professionals for beauty services
        at your home including Facial, Clean Up, Bleach, waxing, pedicure, manicure.
      </h2>
      <a href="get-appointment.php" class="btn">Get an Appointment</a>
    </div>
  </div>

  <section class="salon-section">
    <div class="salon-container">
      <div class="salon-image">
        <img src="images/background pic.jpg" alt="hair salon">
      </div>

      <div class="salon-content">
        <h2>Clean and Recommended Hair Salon</h2>
        <p>
          Their array of beauty parlour services include haircuts, hair spas, colouring,
          texturing, styling, waxing, pedicures, manicures, threading, body spa,
          natural facials and more.
        </p>

        <div class="service-list">
          <ul>
            <li>Hair cut with Blow dry</li>
            <li>Color & highlights</li>
            <li>Shampoo & Set</li>
            <li>Blow Dry & Curl</li>
            <li>Advance Hair Color</li>
          </ul>

          <ul>
            <li>Back Massage</li>
            <li>Hair Treatment</li>
            <li>Face Massage</li>
            <li>Skin Care</li>
            <li>Body Therapies</li>
          </ul>
        </div>
      </div>
    </div>
  </section>


 <?php include('include/footer.php');?>

</body>
</html>