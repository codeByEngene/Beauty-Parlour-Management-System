<?php
session_start();
error_reporting(E_ALL);
include('include/dbconnection.php');

// User login check
if (strlen($_SESSION['uid']) == 0) {
    header('location:logout.php');
} else {

if(isset($_POST['submit'])) {

    $userid = $_SESSION['uid']; 
    $adate = $_POST['adate'];
    $atime = $_POST['appointment_time']; // FIXED
    $msg = $_POST['message'];

    $aptnumber = mt_rand(100000000, 999999999); 

    $query = mysqli_query($con, "INSERT INTO tblappointment
    (AppointmentNumber, UserID, AptDate, AptTime, Message, Status) 
    VALUES('$aptnumber', '$userid', '$adate', '$atime', '$msg', 'Pending')");

    if ($query) {
        echo "<script>alert('Appointment sent! Your number is $aptnumber');</script>";
        echo "<script>window.location.href='bookinghistory.php'</script>";
    } else {
        echo "<script>alert('Something went wrong.');</script>";
    }
}
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

</head>
<body>

<?php include('include/header.php');?>

<section class="hero">
    <div class="hero-overlay">
        <h1>Book Appointment</h1>
        <p>Book your service today and enjoy the best salon experience.</p>
    </div>
</section>

<div class="breadcrumb">
    <a href="dashboard.php">Home</a> › Book Appointment
</div>

<section class="appointment">
<div class="container">

<div class="info">
    <div class="info-item">
        <i class="fas fa-phone"></i>
        <div>
            <h4>Call Us</h4>
            <p>+977-98XXXXXXXX</p>
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
            <p>Kathmandu 16, Sorakhutte, Nepal</p>
        </div>
    </div>
</div>

<div class="form-box">
<form method="post">

<label>Appointment Date</label>
<input type="date" name="adate" required min="<?php echo date('Y-m-d'); ?>">

<label>Appointment Time</label>
<select name="appointment_time" class="appointment-time" required>

<option value="">Select Time</option>

<option value="9:00 AM">9:00 AM</option>
<option value="10:00 AM">10:00 AM</option>
<option value="10:30 AM">10:30 AM</option>
<option value="11:00 AM">11:00 AM</option>
<option value="11:30 AM">11:30 AM</option>
<option value="12:00 PM">12:00 PM</option>
<option value="12:30 PM">12:30 PM</option>
<option value="1:00 PM">1:00 PM</option>
<option value="1:30 PM">1:30 PM</option>
<option value="2:00 PM">2:00 PM</option>
<option value="2:30 PM">2:30 PM</option>
<option value="3:00 PM">3:00 PM</option>
<option value="3:30 PM">3:30 PM</option>
<option value="4:00 PM">4:00 PM</option>
<option value="4:30 PM">4:30 PM</option>
<option value="5:00 PM">5:00 PM</option>
<option value="5:30 PM">5:30 PM</option>
<option value="6:00 PM">6:00 PM</option>
<option value="6:30 PM">6:30 PM</option>
<option value="7:00 PM">7:00 PM</option>

</select>

<label>Message</label>
<textarea name="message" placeholder="Any special requests?"></textarea>

<button type="submit" name="submit">Make an Appointment</button>

</form>
</div>

</div>
</section>

<?php include('include/footer.php');?>

</body>
</html>
<?php } ?>