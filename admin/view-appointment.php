<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');


if (!isset($_SESSION['bpmsaid']) || strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
    
    if(isset($_POST['update'])) {
        $vid = $_GET['viewid'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];
        
        $query = mysqli_query($con, "UPDATE tblappointment SET Status='$status', Remark='$remark', UpdationDate=now() WHERE ID='$vid'");
        
        if($query) {
            echo "<script>alert('Appointment Status Updated Successfully');</script>";
            echo "<script>window.location.href='all-appointment.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please check your database connection.');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Appointment | BPMS Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        #main-content { margin-left: 280px; padding-top: 100px; display: flex; flex-direction: column; align-items: center; }
        .appointment-card { background: #fff; width: 90%; max-width: 850px; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .card-header { border-bottom: 2px solid #f1f1f1; margin-bottom: 20px; padding-bottom: 12px; color: #d4a373; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th { background-color: #fcfcfc; width: 35%; text-align: left; color: #555; font-size: 14px; font-weight: 600; border: 1px solid #f0f0f0; padding: 12px; }
        .table td { border: 1px solid #f0f0f0; padding: 12px; font-size: 14px; }
        .status-badge { font-weight: bold; padding: 4px 10px; border-radius: 4px; font-size: 13px; }
        .pending { color: #f39c12; background: #fef9e7; }
        .accepted { color: #27ae60; background: #eafaf1; }
        .rejected { color: #e74c3c; background: #fdedec; }
        .action-box { margin-top: 25px; padding: 20px; border: 1px dashed #d4a373; background: #fffdfb; border-radius: 8px; }
        textarea { width: 100%; height: 80px; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; resize: none; box-sizing: border-box; }
        .btn-submit { padding: 10px 25px; background: #27ae60; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; }
        @media screen and (max-width: 768px) { #main-content { margin-left: 0; } }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content">
    <div class="appointment-card">
        <div class="card-header">
            <h3 style="margin:0;"><i class="fas fa-eye"></i> Process Appointment</h3>
        </div>

        <?php
        $vid = $_GET['viewid'];
        $ret = mysqli_query($con, "SELECT tblappointment.*, tblusers.FullName, tblusers.MobileNumber, tblusers.Email, services.service_name 
                                   FROM tblappointment 
                                   JOIN tblusers ON tblusers.id=tblappointment.UserID 
                                   LEFT JOIN services ON services.id=tblappointment.ServiceId
                                   WHERE tblappointment.ID='$vid'");
        
        while ($row = mysqli_fetch_array($ret)) {
        ?>
        
        <table class="table">
            <tr><th>Appointment Number</th><td><strong><?php echo $row['AppointmentNumber'];?></strong></td></tr>
            <tr><th>Customer Name</th><td><?php echo $row['FullName'];?></td></tr>
            <tr><th>Selected Service</th><td style="color: blue; font-weight: bold;"><?php echo ($row['service_name']!="") ? $row['service_name'] : "General Service";?></td></tr>
            <tr><th>Mobile Number</th><td><?php echo $row['MobileNumber'];?></td></tr>
            <tr><th>Email Address</th><td><?php echo $row['Email'];?></td></tr>
            <tr><th>Apt Date / Time</th><td><?php echo $row['AptDate'];?> / <?php echo $row['AptTime'];?></td></tr>
            <tr><th>Customer Message</th><td><?php echo ($row['Message']!="") ? $row['Message'] : "No specific message provided.";?></td></tr>
            <tr><th>Booking Date</th><td><?php echo $row['BookingDate'];?></td></tr>
            <tr>
                <th>Current Status</th>
                <td>
                    <?php 
                    if($row['Status'] == "Accepted") echo "<span class='status-badge accepted'>Accepted</span>";
                    elseif($row['Status'] == "Rejected") echo "<span class='status-badge rejected'>Rejected</span>";
                    else echo "<span class='status-badge pending'>Pending</span>";
                    ?>
                </td>
            </tr>
        </table>

        <?php if($row['Status'] == "Pending" || $row['Status'] == "") { ?>
            <div class="action-box">
                <h4 style="margin:0;"><i class="fas fa-edit"></i> Admin Action</h4>
                <form method="post">
                    <p style="font-size:14px; margin: 10px 0 5px; font-weight:600;">Admin Remarks:</p>
                    <textarea name="remark" required placeholder="Enter feedback for the customer..."></textarea>
                    
                    <p style="font-size:14px; margin: 5px 0; font-weight:600;">Update Status:</p>
                    <select name="status" required style="padding:8px; width:220px; border-radius:4px; border:1px solid #ddd;">
                        <option value="">Select Status</option>
                        <option value="Accepted">Accept Appointment</option>
                        <option value="Rejected">Reject Appointment</option>
                    </select>
                    <div style="margin-top: 15px;">
                        <button type="submit" name="update" class="btn-submit">Submit Update</button>
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="action-box" style="border-left: 5px solid #d4a373;">
                <h4 style="margin:0; color:#d4a373;">Admin Processing Log</h4>
                <p><strong>Remark:</strong> <?php echo $row['Remark'];?></p>
                <p><strong>Processed On:</strong> <?php echo date("d-M-Y H:i A", strtotime($row['UpdationDate']));?></p>
            </div>
        <?php } ?>

        <?php } ?>
    </div>
    
    <div style="margin-top:30px;">
        <?php include 'includes/footer.php'; ?>
    </div>
</main>

<script src="js/script.js"></script>
</body>
</html>
<?php } ?>