<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Beauty Parlor Management System</title>
  <link rel="stylesheet" href="style2.css">
  <link rel="stylesheet" href="includes/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <?php include('includes/header.php');?>
 
  <main class="service-grid">
    <div class="service-card">
      <img src="images/Hair Highlights.jpeg" alt="Hair Highlights">
      <h2>Hair Highlights</h2>
      <p>Enhance your hair with professional highlights for a stunning look.</p>
      <p class="price">Cost of Service: rs.1200</p>
      <a href="signup.php" class="btn">Get Appointment</a>
    </div>

    <div class="service-card">
      <img src="images/fruit.jpg" alt="Fruit Facial">
      <h2>Fruit Facial</h2>
      <p>Natural fruit-based facial for glowing skin.</p>
      <p class="price">Cost of Service: rs.500</p>
      <a href="signup.php" class="btn">Get Appointment</a>
    </div>

    <div class="service-card">
      <img src="./images/Acne Treatment Facial.jpeg" alt="Acne Treatment Facial">
      <h2>Acne Treatment Facial</h2>
      <p>Specialized facial treatment for acne-prone skin.</p>
      <p class="price">Cost of Service: rs.500</p>
      <a href="signup.php" class="btn">Get Appointment</a>
    </div>

    <div class="service-card">
      <img src="images/aroma.jpeg" alt="Aroma Oil Massage">
      <h2>Aroma Oil Massage Therapy</h2>
      <p>A relaxing massage using aromatic oils for full-body rejuvenation.</p>
      <p class="price">Cost of Service: rs.100</p>
      <a href="signup.php" class="btn">Get Appointment</a>
    </div>

     <div class="service-card">
      <img src="images/pedicure.jpg" alt="Normal Pedicure">
      <h2>Normal Pedicure</h2>
      <p>A normal pedicure service includes nail trimming, shaping, cuticle care, and a foot massage, finished with a polish application.</p>
      <p class="price">Cost of Service: rs.300</p>
      <a href="signup.php" class="btn">Get Appointment</a>
    </div>

     <div class="service-card"> 
      <img src="images/Deluxe Pedicure.jpg" alt="Deluxe pedicure">
      <h2>Deluxe Pedicure</h2>
      <p>A deluxe pedicure includes all the services of a basic pedicure, plus additional treatments like a longer foot massage, callus removal, exfoliation, and a hydrating mask for your feet and calves.</p>
      <p class="price">Cost of Service: rs.600</p>
      <a href="signup.php" class="btn">Get Appointment</a>
    </div>

     <div class="service-card">
      <img src="images/Gel Manicure.jpeg" alt="Deluxe Menicure">
      <h2>Deluxe manicure</h2>
      <p>A deluxe manicure is a premium nail service that includes standard manicure steps plus extra pampering like an exfoliation scrub, hydrating hand mask, and a longer massage to moisturize and relax the hands.</p>
      <p class="price">Cost of Service: rs.600</p>
      <a href="signup.php" class="btn">Get Appointment</a>
    </div>

     <div class="service-card">
      <img src="images/Full Body Massage.jpeg" alt="Body Spa">
      <h2>Body Spa</h2>
      <p>A body spa is a wellness treatment that focuses on relaxing, rejuvenating, and restoring the body and mind through a variety of therapeutic services.</p>
      <p class="price">Cost of Service: rs.1500</p>
      <a href="signup.php" class="btn">Get Appointment</a>
    </div>

    <div class="service-card">
      <img src="images/layer.jpg" alt="Hair Cut">
      <h2>Layer Hair cut</h2>
      <p>This versatile style is used to add volume to fine hair, reduce bulk in thick hair, and frame the face.</p>
      <p class="price">Cost of Service: rs.250</p>
      <a href="signup.php" class="btn">Get Appointment</a>
    </div>
  
</main>
<?php include ('includes/footer.php');?>
</body>
</html>