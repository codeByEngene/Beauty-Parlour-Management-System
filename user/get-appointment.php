<?php
session_start();
error_reporting(E_ALL);
include('include/dbconnection.php');

if (strlen($_SESSION['uid']) == 0) {
    header('location:logout.php');
} else {

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
            // --- SLOT AVAILABILITY CHECK ---
            $checkSlot = mysqli_query($con, "SELECT id FROM tblappointment WHERE AptDate='$adate' AND AptTime='$atime' AND Status != 'Rejected'");
            
            if(mysqli_num_rows($checkSlot) > 0) {
                echo "<script>alert('Slot Unavailable: This time slot is already booked. Please choose another time.');</script>";
            } else {
                $query = mysqli_query($con, "INSERT INTO tblappointment
                (AppointmentNumber, UserID, ServiceId, AptDate, AptTime, Message, Status) 
                VALUES('$aptnumber', '$userid', '$serviceid', '$adate', '$atime', '$msg', 'Pending')");

                if ($query) {
                    echo "<script>alert('Appointment sent! Your number is $aptnumber');</script>";
                    echo "<script>window.location.href='bookinghistory.php'</script>";
                } else {
                    echo "<script>alert('Database Error. Please try again.');</script>";
                }
            }
        }
    }
}
    // Memory logic: Pulling data from the URL to keep the boxes filled
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
/* --- MODAL (POP-UP) STYLES --- */
.modal {
    display: none; 
    position: fixed; 
    z-index: 9999; 
    left: 0; top: 0; width: 100%; height: 100%; 
    background-color: rgba(0,0,0,0.7); 
    backdrop-filter: blur(3px);
}
.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 30px;
    border-radius: 15px;
    width: 90%;
    max-width: 450px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    position: relative;
    animation: slideDown 0.3s ease-out;
}
@keyframes slideDown {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.modal-content h3 { color: #b5838d; margin-bottom: 10px; font-size: 24px; }
.close-modal {
    position: absolute;
    right: 20px; top: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #888;
}

/* --- REFINED BUTTONS & BOXES --- */
.btn-select-main {
    background-color: #b5838d; 
    color: white;
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 15px;
    transition: 0.3s;
}
.btn-select-main:hover { background-color: #a6737c; }

.selected-service-box {
    background: #fdf6f0; 
    border: 1px solid #e8a598; 
    padding: 15px; 
    border-radius: 8px; 
    color: #b5838d; 
    font-weight: 600; 
    margin-bottom: 20px; 
    display: flex; 
    justify-content: space-between; 
    align-items: center;
}

.form-box button[name="submit"] { background: #b5838d !important; }
.form-box button[name="submit"]:hover { background: #a6737c !important; }

/* Custom red warning label style */
.warn-text { color: #e74c3c; font-size: 13px; display: none; margin-bottom: 10px; font-weight: bold; }
</style>

</head>
<body>

<?php include('include/header.php');?>

<section class="hero">
    <div class="hero-overlay">
        <h1>Book Appointment</h1>
        <p>Your beauty journey starts here.</p>
    </div>
</section>

<div class="breadcrumb">
    <a href="dashboard.php">Home</a> › Book Appointment
</div>

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
            echo "<div class='selected-service-box'>";
            echo "<span><i class='fa fa-sparkles'></i> " . htmlspecialchars($res['service_name']) . "</span>";
            echo "<span class='service-price-tag'>Rs. " . number_format($res['Cost'], 2) . "</span>";
            echo "<a href='javascript:void(0)' onclick='openModal()' style='font-size: 12px; color: #8f7463; text-decoration: underline;'>Change</a>";
            echo "</div>";
        }
    } else {
        echo "<button type='button' class='btn-select-main' onclick='openModal()'><i class='fa fa-list-ul'></i> Click to Choose Service</button>";
    }
    ?>

    <label>Appointment Date</label>
    <input type="date" name="adate" id="adate" required 
           value="<?php echo $existingDate; ?>"
           min="<?php echo date('Y-m-d'); ?>" 
           max="<?php echo date('Y-12-31'); ?>" 
           oninput="validateYear(this); this.setCustomValidity('')" 
           onchange="filterTime()"
           oninvalid="this.setCustomValidity('Please pick a valid date for your appointment.')">
    <p id="dateWarn" class="warn-text">Please select a valid date in <?php echo date('Y'); ?>.</p>

    <label>Appointment Time</label>
    <select name="appointment_time" id="appointment_time" class="appointment-time" required 
            onchange="validateField(this)"
            oninvalid="this.setCustomValidity('Please select a time slot from the list.')" 
            oninput="this.setCustomValidity('')">
        <option value="">Select Time</option>
        <option value="09:00:00">9:00 AM</option>
        <option value="10:00:00">10:00 AM</option>
        <option value="11:00:00">11:00 AM</option>
        <option value="12:00:00">12:00 PM</option>
        <option value="13:00:00">1:00 PM</option>
        <option value="14:00:00">2:00 PM</option>
        <option value="15:00:00">3:00 PM</option>
        <option value="16:00:00">4:00 PM</option>
        <option value="17:00:00">5:00 PM</option>
        <option value="18:00:00">6:00 PM</option>
        <option value="19:00:00">7:00 PM</option>
    </select>
    <p id="timeWarn" class="warn-text">Please choose a time slot.</p>

    <label>Message / Special Requests</label>
    <textarea name="message" placeholder="e.g., Sensitive skin..."></textarea>

    <button type="submit" name="submit">Make an Appointment</button>
</form>
</div>
</div>
</section>

<div id="serviceModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <h3>Our Services</h3>
        <p style="font-size: 14px; color: #666; margin-bottom: 20px;">Choose a treatment to see the price:</p>
        
        <select id="modalServiceSelect" class="appointment-time" style="margin-bottom: 25px; border: 1px solid #b5838d;">
            <option value="">-- Choose a treatment --</option>
            <?php 
            $query_s = mysqli_query($con, "SELECT id, service_name, Cost FROM services");
            while($row_s = mysqli_fetch_array($query_s)) {
                echo "<option value='".$row_s['id']."'>".$row_s['service_name']." (Rs. ".$row_s['Cost'].")</option>";
            }
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
    const serviceId = document.getElementById('modalServiceSelect').value;
    const currentDate = document.getElementById('adate').value;
    const currentTime = document.getElementById('appointment_time').value;
    if(serviceId) {
        // Appends existing data to the URL so PHP can put it back after reload
        window.location.href = "get-appointment.php?serviceid=" + serviceId + "&date=" + currentDate + "&time=" + currentTime;
    } else {
        alert("Please select a service first.");
    }
}

function validateYear(element) {
    const currentYear = new Date().getFullYear();
    const warn = document.getElementById('dateWarn');
    if (element.value) {
        const inputYear = parseInt(element.value.split('-')[0]);
        if (inputYear !== currentYear) {
            element.value = "";
            warn.style.display = "block";
        } else { warn.style.display = "none"; }
    }
}

function validateField(element) {
    document.getElementById('timeWarn').style.display = (element.value === "") ? "block" : "none";
}

document.getElementById('appointmentForm').onsubmit = function(e) {
    const urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.has('serviceid')) {
        alert("Please select a service first.");
        openModal();
        e.preventDefault();
    }
};

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
            const [optHour, optMin] = options[i].value.split(':');
            if (parseInt(optHour) < today.getHours() || (parseInt(optHour) === today.getHours() && parseInt(optMin) <= today.getMinutes())) {
                options[i].style.display = 'none';
                options[i].disabled = true;
            } else {
                options[i].style.display = 'block';
                options[i].disabled = false;
            }
        } else {
            options[i].style.display = 'block';
            options[i].disabled = false;
        }
    }
}
window.onload = filterTime;
</script>

</body>
</html>