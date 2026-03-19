<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

if (!isset($_SESSION['bpmsaid']) || strlen($_SESSION['bpmsaid']) == 0) {
    header('location:../index.php'); 
    exit();
} else {
    // Queries to fetch real data
    $totalcustomers = mysqli_num_rows(mysqli_query($con, "SELECT id FROM tblusers WHERE Role='user'"));
    $totalappointment = mysqli_num_rows(mysqli_query($con, "SELECT ID FROM tblappointment"));
    $totalacceptedapt = mysqli_num_rows(mysqli_query($con, "SELECT ID FROM tblappointment WHERE Status='Accepted'"));
    $totalrejectedapt = mysqli_num_rows(mysqli_query($con, "SELECT ID FROM tblappointment WHERE Status='Rejected'"));
    $totalservices = mysqli_num_rows(mysqli_query($con, "SELECT ID FROM services"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>BPMS Admin Panel - Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content" style="margin-left: 280px; transition: 0.3s; padding: 120px 20px 20px 20px;">
  
  <div style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
    <h2 style="margin: 0; color: #333; font-family: 'Roboto Condensed', sans-serif; font-size: 24px;">
       <i class=""></i> Admin Dashboard Overview
    </h2>
  </div>

  <div class="row">
    <div class="card card1">
      <div class="card-text">
        <p>Total</p>
        <h1>Customers</h1>
      </div>
      <div class="count count1">
        <p><?php echo $totalcustomers; ?></p>
      </div>
    </div>

    <div class="card card3">
      <div class="card-text">
        <p>Total</p>
        <h1>Appointments</h1>
      </div>
      <div class="count count3">
        <p><?php echo $totalappointment; ?></p>
      </div>
    </div>

    <div class="card" style="background-color: #2ecc71;">
      <div class="card-text">
        <p>Total</p>
        <h1>Accepted</h1>
      </div>
      <div class="count" style="background-color: #27ae60; width:30%; height:100%; display:flex; justify-content:center; align-items:center;">
        <p style="font-size:45px; margin:0;"><?php echo $totalacceptedapt; ?></p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="card" style="background-color: #e74c3c;">
      <div class="card-text">
        <p>Total</p>
        <h1>Rejected</h1>
      </div>
      <div class="count" style="background-color: #c0392b; width:30%; height:100%; display:flex; justify-content:center; align-items:center;">
        <p style="font-size:45px; margin:0;"><?php echo $totalrejectedapt; ?></p>
      </div>
    </div>

    <div class="card" style="background-color: #9b59b6;">
      <div class="card-text">
        <p>Total</p>
        <h1>Services</h1>
      </div>
      <div class="count" style="background-color: #8e44ad; width:30%; height:100%; display:flex; justify-content:center; align-items:center;">
        <p style="font-size:45px; margin:0;"><?php echo $totalservices; ?></p>
      </div>
    </div>

    <div class="card" style="background-color: #1abc9c;">
      <div class="card-text">
        <p>Total</p>
        <h1>Sales</h1>
      </div>
      <div class="count" style="background-color: #16a085; width:30%; height:100%; display:flex; justify-content:center; align-items:center;">
        <p style="font-size:45px; margin:0;">0</p>
      </div>
    </div>
  </div>

</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>