<?php
session_start();
error_reporting(E_ALL);
include('include/dbconnection.php');

// User login check
if (strlen($_SESSION['uid']) == 0) {
    header('location:logout.php');
} else {

    // Logic to handle form submission
    if(isset($_POST['submit'])) {
        $userid = $_SESSION['uid']; 
        $adate = $_POST['adate'];
        $atime = $_POST['appointment_time'];
        $msg = $_POST['message'];
        
        $serviceid = isset($_GET['serviceid']) ? $_GET['serviceid'] : NULL;
        $aptnumber = mt_rand(100000000, 999999999); 

        // Backend Safety Check: Ensure the time hasn't passed (24-hour format logic)
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');
        $selectedTime = date('H:i', strtotime($atime));

        if($adate == $currentDate && $selectedTime < $currentTime){
            echo "<script>alert('Error: The selected time has already passed. Please choose a future time.');</script>";
        } else {
            $query = mysqli_query($con, "INSERT INTO tblappointment
            (AppointmentNumber, UserID, ServiceId, AptDate, AptTime, Message, Status) 
            VALUES('$aptnumber', '$userid', '$serviceid', '$adate', '$atime', '$msg', 'Pending')");

            if ($query) {
                echo "<script>alert('Appointment sent! Your number is $aptnumber');</script>";
                echo "<script>window.location.href='bookinghistory.php'</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
<div class="centered-container"> <div class="form-box">
<form method="post" id="appointmentForm">
    
    <?php 
    if(isset($_GET['serviceid'])) {
        $sid = $_GET['serviceid'];
        // Join query to get service_name and ensureServiceId is valid
        $get_service = mysqli_query($con, "SELECT service_name FROM services WHERE id='$sid'");
        $res = mysqli_fetch_array($get_service);
        if($res) {
            echo "<p style='color: #d4a373; font-weight: bold; margin-bottom: 15px;'>Selected Service: " . $res['service_name'] . "</p>";
        }
    }
    ?>

    <label>Appointment Date</label>
    <input type="date" name="adate" id="adate" required min="<?php echo date('Y-m-d'); ?>" onchange="filterTime()">

    <label>Appointment Time</label>
    <select name="appointment_time" id="appointment_time" class="appointment-time" required>
        <option value="">Select Time</option>
        <option value="09:00:00">9:00 AM</option>
        <option value="10:00:00">10:00 AM</option>
        <option value="10:30:00">10:30 AM</option>
        <option value="11:00:00">11:00 AM</option>
        <option value="11:30:00">11:30 AM</option>
        <option value="12:00:00">12:00 PM</option>
        <option value="12:30:00">12:30 PM</option>
        <option value="13:00:00">1:00 PM</option>
        <option value="13:30:00">1:30 PM</option>
        <option value="14:00:00">2:00 PM</option>
        <option value="14:30:00">2:30 PM</option>
        <option value="15:00:00">3:00 PM</option>
        <option value="15:30:00">3:30 PM</option>
        <option value="16:00:00">4:00 PM</option>
        <option value="16:30:00">4:30 PM</option>
        <option value="17:00:00">5:00 PM</option>
        <option value="17:30:00">5:30 PM</option>
        <option value="18:00:00">6:00 PM</option>
        <option value="18:30:00">6:30 PM</option>
        <option value="19:00:00">7:00 PM</option>
    </select>

    <label>Message</label>
    <textarea name="message" placeholder="Any special requests?"></textarea>

    <button type="submit" name="submit">Make an Appointment</button>
</form>
</div>

</div>
</section>

<?php include('include/footer.php');?>

<script>
function filterTime() {
    const dateInput = document.getElementById('adate');
    const timeSelect = document.getElementById('appointment_time');
    const options = timeSelect.options;
    
    // Get current system time
    const today = new Date();
    // Parse selected date
    const selectedDateStr = dateInput.value;
    const selectedDate = new Date(selectedDateStr);
    
    // Check if the selected date is today
    const isToday = today.toDateString() === selectedDate.toDateString();
    
    const currentHour = today.getHours();
    const currentMinutes = today.getMinutes();

    // Loop through options, skipping the "Select Time" placeholder
    for (let i = 1; i < options.length; i++) {
        if (isToday) {
            // Extract HH:mm from the option value (24-hour format)
            const [optHour, optMin] = options[i].value.split(':');
            const parsedOptHour = parseInt(optHour);
            const parsedOptMin = parseInt(optMin);
            
            // If the option time has already passed
            if (parsedOptHour < currentHour || (parsedOptHour === currentHour && parsedOptMin <= currentMinutes)) {
                options[i].style.display = 'none'; // Hide the past time
                options[i].disabled = true;
            } else {
                options[i].style.display = 'block'; // Show future times
                options[i].disabled = false;
            }
        } else {
            // If it's a future date, show all options
            options[i].style.display = 'block';
            options[i].disabled = false;
        }
    }
    
    // Reset selection if the currently selected time becomes hidden/disabled
    if (timeSelect.selectedOptions[0] && timeSelect.selectedOptions[0].disabled) {
        timeSelect.value = "";
    }
}

// Run once on load to ensure accuracy
window.onload = filterTime;
</script>

</body>
</html>
<?php } ?>