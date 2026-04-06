<?php
session_start();
error_reporting(E_ALL);
include('include/dbconnection.php');

if (strlen($_SESSION['uid']) == 0) {
    header('location:logout.php');
} else {
    // --- NEW: AJAX Check (Doesn't affect UI) ---
    if (isset($_POST['check_availability'])) {
        $adate = mysqli_real_escape_string($con, $_POST['date']);
        $atime = mysqli_real_escape_string($con, $_POST['time']);
        $checkSlot = mysqli_query($con, "SELECT id FROM tblappointment WHERE AptDate='$adate' AND AptTime='$atime' AND Status != 'Rejected'");
        echo (mysqli_num_rows($checkSlot) > 0) ? "taken" : "available";
        exit();
    }

    if(isset($_POST['submit'])) {
        $userid = $_SESSION['uid']; 
        $adate = $_POST['adate'];
        $atime = $_POST['appointment_time'];
        $msg = mysqli_real_escape_string($con, $_POST['message']); 
        $serviceid = isset($_GET['serviceid']) ? $_GET['serviceid'] : NULL;
        $aptnumber = mt_rand(100000000, 999999999); 

        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        
        if($adate < $currentDate || ($adate == $currentDate && $atime <= $currentTime)){
            echo "<script>alert('Error: You cannot book an appointment in the past.');</script>";
        } 
        elseif(empty($serviceid)) {
            echo "<script>alert('Please select a service before booking.');</script>";
        } 
        else {
            $query = mysqli_query($con, "INSERT INTO tblappointment (AppointmentNumber, UserID, ServiceId, AptDate, AptTime, Message, Status) VALUES('$aptnumber', '$userid', '$serviceid', '$adate', '$atime', '$msg', 'Pending')");
            if ($query) {
                echo "<script>alert('Appointment sent! Your number is $aptnumber');</script>";
                echo "<script>window.location.href='bookinghistory.php'</script>";
            }
        }
    }
}
$existingDate = isset($_GET['date']) ? $_GET['date'] : '';
$existingTime = isset($_GET['time']) ? $_GET['time'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Appointment | BPMS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style4.css">
<link rel="stylesheet" href="include/header.css">
<link rel="stylesheet" href="include/footer.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
.modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); backdrop-filter: blur(3px); }
.modal-content { background-color: #fff; margin: 10% auto; padding: 30px; border-radius: 15px; width: 90%; max-width: 450px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.3); position: relative; animation: slideDown 0.3s ease-out; }
@keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.modal-content h3 { color: #b5838d; margin-bottom: 10px; font-size: 24px; }
.close-modal { position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; color: #888; }
.btn-select-main { background-color: #b5838d; color: white; width: 100%; padding: 14px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 16px; margin-bottom: 15px; transition: 0.3s; }
.btn-select-main:hover { background-color: #a6737c; }
.selected-service-box { background: #fdf6f0; border: 1px solid #e8a598; padding: 15px; border-radius: 8px; color: #b5838d; font-weight: 600; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
.form-box button[name="submit"] { background: #b5838d !important; }
.form-box button[name="submit"]:hover { background: #a6737c !important; }
.warn-text { color: #e74c3c; font-size: 13px; display: none; margin-bottom: 10px; font-weight: bold; }
</style>
</head>
<body>
<?php include('include/header.php');?>
<section class="hero"><div class="hero-overlay"><h1>Book Appointment</h1><p>Your beauty journey starts here.</p></div></section>
<div class="breadcrumb"><a href="dashboard.php">Home</a> › Book Appointment</div>
<section class="appointment">
<div class="centered-container"> 
<div class="form-box">
<form method="post" id="appointmentForm">
    <label>Selected Service & Price</label>
    <?php 
    if(isset($_GET['serviceid'])) {
        $sid = mysqli_real_escape_string($con, $_GET['serviceid']);
        $get_service = mysqli_query($con, "SELECT service_name, Cost FROM services WHERE id='$sid'");
        $res = mysqli_fetch_array($get_service);
        if($res) {
            echo "<div class='selected-service-box'><span><i class='fa fa-sparkles'></i> " . htmlspecialchars($res['service_name']) . "</span><span class='service-price-tag'>Rs. " . number_format($res['Cost'], 2) . "</span><a href='javascript:void(0)' onclick='openModal()' style='font-size: 12px; color: #8f7463; text-decoration: underline;'>Change</a></div>";
        }
    } else { echo "<button type='button' class='btn-select-main' onclick='openModal()'><i class='fa fa-list-ul'></i> Click to Choose Service</button>"; }
    ?>
    <label>Appointment Date</label>
    <input type="date" name="adate" id="adate" required value="<?php echo $existingDate; ?>" min="<?php echo date('Y-m-d'); ?>" onchange="checkAvailability(); filterTime();">
    <p id="dateWarn" class="warn-text">Please select a valid date.</p>

    <label>Appointment Time</label>
    <select name="appointment_time" id="appointment_time" class="appointment-time" required onchange="checkAvailability()">
        <option value="">Select Time</option>
        <option value="09:00:00">9:00 AM</option>
        <option value="10:00:00">10:00 AM</option>
        <option value="11:00:00">11:00 AM</option>
        <option value="12:00:00">12:00 PM</option>
        <option value="13:00:00">1:00 PM</option>
        <option value="14:00:00">2:00 PM</option>
        <option value="15:00:00">3:00 PM</option>
        <option value="16:00:00">4:00 PM</option>
    </select>
    <p id="slotWarn" class="warn-text">Slot Unavailable: Already booked.</p>

    <label>Message / Special Requests</label>
    <textarea name="message" placeholder="e.g., Sensitive skin..."></textarea>
    <button type="submit" name="submit" id="submitBtn">Make an Appointment</button>
</form>
</div>
</div>
</section>

<div id="serviceModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <h3>Our Services</h3>
        <select id="modalServiceSelect" class="appointment-time" style="margin-bottom: 25px;">
            <option value="">-- Choose a treatment --</option>
            <?php 
            $query_s = mysqli_query($con, "SELECT id, service_name, Cost FROM services");
            while($row_s = mysqli_fetch_array($query_s)) { echo "<option value='".$row_s['id']."'>".$row_s['service_name']." (Rs. ".$row_s['Cost'].")</option>"; }
            ?>
        </select>
        <button type="button" class="btn-select-main" onclick="confirmService()">Confirm Selection</button>
    </div>
</div>

<?php include('include/footer.php');?>

<script>
function openModal() { document.getElementById('serviceModal').style.display = "block"; }
function closeModal() { document.getElementById('serviceModal').style.display = "none"; }
function confirmService() {
    const sid = document.getElementById('modalServiceSelect').value;
    if(sid) { window.location.href = "get-appointment.php?serviceid=" + sid + "&date=" + document.getElementById('adate').value; }
}

function checkAvailability() {
    const date = document.getElementById('adate').value;
    const time = document.getElementById('appointment_time').value;
    const btn = document.getElementById('submitBtn');
    const warn = document.getElementById('slotWarn');

    if(date && time) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "get-appointment.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText.trim() === "taken") {
                    btn.disabled = true;
                    btn.style.opacity = "0.5";
                    warn.style.display = "block";
                } else {
                    btn.disabled = false;
                    btn.style.opacity = "1";
                    warn.style.display = "none";
                }
            }
        };
        xhr.send("check_availability=1&date=" + date + "&time=" + time);
    }
}

function filterTime() {
    const dateInput = document.getElementById('adate');
    const timeSelect = document.getElementById('appointment_time');
    const options = timeSelect.options;
    const today = new Date();
    if(!dateInput.value) return;
    const selectedDate = new Date(dateInput.value);
    const isToday = today.toDateString() === selectedDate.toDateString();
    for (let i = 1; i < options.length; i++) {
        if (isToday) {
            const [optHour] = options[i].value.split(':');
            if (parseInt(optHour) <= today.getHours()) {
                options[i].disabled = true;
                options[i].style.display = 'none';
            } else { options[i].disabled = false; options[i].style.display = 'block'; }
        } else { options[i].disabled = false; options[i].style.display = 'block'; }
    }
}
window.onload = filterTime;
</script>
</body>
</html>