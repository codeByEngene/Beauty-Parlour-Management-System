<?php
include('dbconnection.php');
$reminderMessages = [];
$nextAppointment = null;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['uid']) && isset($con)) {
    $uid = $_SESSION['uid'];

    $columnCheck = mysqli_query($con, "SHOW COLUMNS FROM tblappointment LIKE 'ReminderSent'");
    $hasReminderField = ($columnCheck && mysqli_num_rows($columnCheck) > 0);

    $now = new DateTime('now');
    $rangeStart = $now->format('Y-m-d H:i:s');
    $rangeEnd = $now->modify('+1 hour')->format('Y-m-d H:i:s');

    $sql = "SELECT * FROM tblappointment WHERE UserID='$uid' AND Status IN ('Accepted','Pending') AND CONCAT(AptDate, ' ', AptTime) BETWEEN '$rangeStart' AND '$rangeEnd'";
    if ($hasReminderField) {
        $sql .= " AND ReminderSent=0";
    }

    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $aptDateTime = date('d-M-Y h:i A', strtotime($row['AptDate'] . ' ' . $row['AptTime']));
            $reminderMessages[] = "Reminder: appointment #{$row['AppointmentNumber']} at $aptDateTime is coming in 1 hour.";

            if ($hasReminderField) {
                mysqli_query($con, "UPDATE tblappointment SET ReminderSent=1 WHERE ID='{$row['ID']}'");
            }
        }
    }

    // Find the next upcoming appointment for the icon
    $nextSql = "SELECT tblappointment.*, services.service_name FROM tblappointment LEFT JOIN services ON tblappointment.ServiceId = services.id WHERE tblappointment.UserID='$uid' AND tblappointment.Status IN ('Accepted','Pending') AND CONCAT(tblappointment.AptDate, ' ', tblappointment.AptTime) > NOW() ORDER BY CONCAT(tblappointment.AptDate, ' ', tblappointment.AptTime) ASC LIMIT 1";
    $nextResult = mysqli_query($con, $nextSql);
    if ($nextResult && mysqli_num_rows($nextResult) > 0) {
        $nextAppointment = mysqli_fetch_assoc($nextResult);
    }
}
?>

<nav class="navbar">
  <div class="logo">BPMS</div>
  <ul>
    <li><a href="dashboard.php">Home</a></li>
    <li><a href="aboutus.php">About</a></li>
    <li><a href="services.php">Services</a></li>
    <!-- <li><a href="contact.php">Contact</a></li> -->
     <li><a href="get-appointment.php">Get-Appointment</a></li>
     <li><a href="bookinghistory.php">Booking History</a></li>
     <li><a href="invoice.php">Invoice History</a></li>
     <li><a href="logout.php">LogOut</a></li>
  </ul>
  <?php if ($nextAppointment): ?>
    <div class="notification-icon" onclick="openNotificationModal()" title="Click for appointment details">
      <i class="fas fa-bell"></i>
      <span class="time-remaining"><?php
        $now = new DateTime();
        $aptTime = new DateTime($nextAppointment['AptDate'] . ' ' . $nextAppointment['AptTime']);
        $interval = $now->diff($aptTime);
        if ($interval->days > 0) {
            echo $interval->days . 'd ' . $interval->h . 'h';
        } elseif ($interval->h > 0) {
            echo $interval->h . 'h ' . $interval->i . 'm';
        } else {
            echo $interval->i . 'm';
        }
      ?></span>
    </div>
  <?php endif; ?>
</nav>

<!-- Notification Modal -->
<div id="notificationModal" class="modal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeNotificationModal()">&times;</span>
    <h3>Upcoming Appointment</h3>
    <?php if ($nextAppointment): ?>
      <p><strong>Appointment Number:</strong> <?php echo $nextAppointment['AppointmentNumber']; ?></p>
      <p><strong>Service:</strong> <?php echo $nextAppointment['service_name'] ?: 'Not Specified'; ?></p>
      <p><strong>Date & Time:</strong> <?php echo date('d-M-Y h:i A', strtotime($nextAppointment['AptDate'] . ' ' . $nextAppointment['AptTime'])); ?></p>
      <p><strong>Status:</strong> <?php echo $nextAppointment['Status']; ?></p>
      <p><strong>Message:</strong> <?php echo $nextAppointment['Message'] ?: 'None'; ?></p>
    <?php else: ?>
      <p>No upcoming appointments.</p>
    <?php endif; ?>
  </div>
</div>

<?php if (!empty($reminderMessages)): ?>
<div class="reminder-banner">
  <?php foreach ($reminderMessages as $message): ?>
    <div class="reminder-item"><?php echo htmlspecialchars($message); ?></div>
  <?php endforeach; ?>
</div>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        alert("<?php echo implode('\\n', array_map('addslashes', $reminderMessages)); ?>");
    });
</script>
<?php endif; ?>

<script>
function openNotificationModal() {
    document.getElementById('notificationModal').style.display = 'block';
}
function closeNotificationModal() {
    document.getElementById('notificationModal').style.display = 'none';
}
window.onclick = function(event) {
    if (event.target == document.getElementById('notificationModal')) {
        closeNotificationModal();
    }
}
</script>
