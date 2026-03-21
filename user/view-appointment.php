<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('include/dbconnection.php');

if (!isset($_SESSION['bpmsaid']) || strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
    // Status update logic
    if(isset($_POST['update'])) {
        $vid = $_GET['viewid'];
        $status = $_POST['status'];
        $remark = $_POST['remark'];
        
        $query = mysqli_query($con, "UPDATE tblappointment SET Status='$status', Remark='$remark', UpdationDate=now() WHERE ID='$vid'");
        
        if($query) {
            echo "<script>alert('Appointment Status Updated Successfully');</script>";
            echo "<script>window.location.href='all-appointment.php';</script>";
        } else {
            echo "<script>alert('Error updating record.');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Anua BPMS | View Appointment</title>
    <link rel="stylesheet" href="include/header.css">
    <link rel="stylesheet" href="include/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        #main-content { margin-left: 280px; padding-top: 100px; padding-bottom: 50px; display: flex; flex-direction: column; align-items: center; }
        .appointment-card { background: #fff; width: 90%; max-width: 850px; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .card-header { border-bottom: 2px solid #f1f1f1; margin-bottom: 20px; padding-bottom: 12px; color: #d4a373; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th { background-color: #fcfcfc; width: 35%; text-align: left; color: #555; font-size: 14px; font-weight: 600; }
        .table th, .table td { border: 1px solid #f0f0f0; padding: 12px 18px; font-size: 14px; }
        .status-rejected { color: #e74c3c; font-weight: bold; background: #fdedec; padding: 4px 8px; border-radius: 4px; }
        .status-accepted { color: #27ae60; font-weight: bold; background: #eafaf1; padding: 4px 8px; border-radius: 4px; }
        .status-pending { color: #f39c12; font-weight: bold; background: #fef9e7; padding: 4px 8px; border-radius: 4px; }
        .action-box { margin-top: 25px; padding: 20px; border-left: 5px solid #d4a373; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        @media screen and (max-width: 768px) { #main-content { margin-left: 0; padding-top: 80px; } }
    </style>
</head>
<body>

<?php include 'include/header.php'; ?>

<main id="main-content">
    <div class="appointment-card">
        <div class="card-header">
            <h3 style="margin:0;"><i class="fas fa-calendar-alt"></i> Appointment Details</h3>
        </div>

        <?php
        $vid = $_GET['viewid'];
        // UPDATED QUERY: Added JOIN with services table to get service_name and cost
        $ret = mysqli_query($con, "SELECT tblappointment.*, tblusers.FullName, tblusers.MobileNumber, tblusers.Email, services.service_name, services.cost 
                                   FROM tblappointment 
                                   JOIN tblusers ON tblusers.id=tblappointment.UserID 
                                   LEFT JOIN services ON services.id=tblappointment.ServiceId
                                   WHERE tblappointment.ID='$vid'");
        
        while ($row = mysqli_fetch_array($ret)) {
        ?>
        
        <table class="table">
            <tr><th>Appointment Number</th><td><?php echo $row['AppointmentNumber'];?></td></tr>
            <tr><th>Customer Name</th><td><?php echo $row['FullName'];?></td></tr>
            <tr><th>Mobile Number</th><td><?php echo $row['MobileNumber'];?></td></tr>
            <tr><th>Email Address</th><td><?php echo $row['Email'];?></td></tr>
            
            <tr>
                <th style="color: #d4a373;">Selected Service</th>
                <td style="font-weight: bold;"><?php echo ($row['service_name'] != "") ? $row['service_name'] : "Not Specified"; ?></td>
            </tr>
            <tr>
                <th style="color: #d4a373;">Service Cost</th>
                <td>Rs. <?php echo ($row['cost'] != "") ? $row['cost'] : "0"; ?></td>
            </tr>
            
            <tr><th>Apt Date / Time</th><td><?php echo $row['AptDate'];?> / <?php echo $row['AptTime'];?></td></tr>
            <tr><th>Booking Date</th><td><?php echo $row['BookingDate'];?></td></tr>
            <tr>
                <th>Current Status</th>
                <td>
                    <?php 
                    $curr_status = $row['Status'];
                    if($curr_status == "Accepted") { echo "<span class='status-accepted'>Accepted</span>"; }
                    else if($curr_status == "Rejected") { echo "<span class='status-rejected'>Rejected</span>"; }
                    else { echo "<span class='status-pending'>Pending</span>"; }
                    ?>
                </td>
            </tr>
        </table>

        <?php if($row['Status'] != "Pending" && $row['Status'] != "" && $row['Status'] != "0") { ?>
            <div class="action-box">
                <h4 style="margin:0 0 10px 0; color:#d4a373;">Admin Processed Details</h4>
                <p style="font-size:14px; margin: 5px 0;"><strong>Remark:</strong> <?php echo $row['Remark'];?></p>
                <p style="font-size:14px; margin: 5px 0;"><strong>Updated On:</strong> 
                    <?php 
                        if(!empty($row['UpdationDate'])) {
                            echo date("d-M-Y H:i A", strtotime($row['UpdationDate']));
                        } else {
                            echo "N/A";
                        }
                    ?>
                </p>
            </div>
        <?php } ?>

        <?php } ?>
    </div>
</main>

<div style="width:100%; text-align:center; margin-top:30px;">
    <?php include 'include/footer.php'; ?>
</div>
</body>
</html>
<?php } ?>