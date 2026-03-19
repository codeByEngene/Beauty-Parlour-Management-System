<?php 
include('includes/dbconnection.php');

if(isset($_GET['viewid'])) {
    $vid = $_GET['viewid'];

    mysqli_query($con, "UPDATE tblcontact SET IsRead=1 WHERE id='$vid'");

    $ret = mysqli_query($con, "SELECT * FROM tblcontact WHERE id='$vid'");
    $row = mysqli_fetch_array($ret);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Enquiry Detail</title>
    <link rel="stylesheet" href="css/view-enquiry.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <div class="page-wrapper">
        <h1 class="title">View Enquiry Details</h1>
        <div class="container">
            <table class="enquiry-table">
                <tr>
                    <th>Name</th><td><?php echo $row['Name']; ?></td>
                    <th>Email</th><td><?php echo $row['Email']; ?></td>
                </tr>
                <tr>
                    <th>Contact No.</th><td><?php echo $row['Phone']; ?></td>
                    <th>Query Date</th><td><?php echo $row['PostingDate']; ?></td>
                </tr>
                <tr class="message-row">
                    <th>Message</th>
                    <td colspan="3"><?php echo $row['Message']; ?></td>
                </tr>
            </table>
            <br>
            <button onclick="window.location.href='readenq.php'" style="padding:10px 20px; background:#555; color:white; border:none; cursor:pointer;">Back</button>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>