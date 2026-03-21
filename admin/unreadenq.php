<?php 
session_start();
include('includes/dbconnection.php'); 

if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Unread Enquiry - BPMS Admin</title>
    <link rel="stylesheet" href="css/unreadenq.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content" class="main-content">
    <div class="container">
        <h1 class="title">Manage Unread Enquiry</h1>
        <div class="box">
            <h3 class="subtitle">New Messages:</h3>
            <table class="enquiry-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Enquiry Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $ret = mysqli_query($con, "SELECT * FROM tblcontact WHERE IsRead=0 ORDER BY id DESC");
                $cnt = 1;
                
                if(mysqli_num_rows($ret) > 0) {
                    while ($row = mysqli_fetch_array($ret)) {
                ?>
                    <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['PostingDate']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="view-enquiry.php?viewid=<?php echo $row['ID']; ?>" class="view-btn">View</a>
                                <a href="manage-unread-enquiry.php?delid=<?php echo $row['ID']; ?>" class="delete-btn" onclick="return confirm('Do you really want to delete?');">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php 
                    $cnt++; 
                    } 
                } else { ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:red; padding:20px;">No unread enquiries found.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>
<?php } ?>