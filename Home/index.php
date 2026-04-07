<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors' , 1);
include('includes/dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beauty Parlour</title>

  <!-- CSS -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="includes/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
<?php include('includes/header.php');?>
  <!-- Slideshow -->
  <div class="slideshow">
    <div class="slide">
      <img src="images/bg1.jpg" alt="Slide 1" />
      <div class="caption">
        
        <h2>Welcome to Our Beauty Parlour</h2>
        <p>Experience the best beauty services with us.</p>
        <a href="login.php" class="btn">Get Appointment</a>
      </div>
    </div>

    <div class="slide">
      <img src="images/bg2.jpg" alt="Slide 2" />
      <div class="caption">
        <h2>Our Premium Services</h2>
        <p>Professional care for your beauty and wellness.</p>
       <a href="login.php?redirect=appointment" class="btn">Get Appointment</a>
      </div>
    </div>
  </div>

  <section class="parlour">
    <h1>Our Salon is Most Popular</h1>
    <p>Anua Hair and Beauty Salon offers a wide range of beauty services.</p>

    <div class="row">
      <div class="parlour-col">
        <img src="images/hair-cut.jpg" alt="Hair-cut and Styling" />
        <h2>Hair Cut and Styling</h2>
        <p>Professional haircuts and styling for all hair types.</p>
        <p class="price">Cost of Service: rs.500</p>
         <a href="services.php" class="btn">Read More</a>
        <div class="layer"></div>
      </div>

      <div class="parlour-col">
        <img src="images/service3.jpg" alt="Service 2" />
        <h2>Glowskin Facial</h2>
        <p>Exclusive facial for radiant skin.</p>
        <p class="price">Cost of Service: rs.800</p>
        <a href="services.php" class="btn">Read More</a>
        <div class="layer"></div>
      </div>

      <div class="parlour-col">
        <img src="images/service1.png" alt="Service 3" />
        <h2>Advanced Hair Treatment</h2>
        <p>Professional hair treatment for healthy and shiny hair.</p>
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
      <a href="login.php?redirect=appointment" class="btn">Get Appointment</a>
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

<?php include('includes/footer.php');?>
</body>
</html>
