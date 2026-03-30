<?php 
session_start(); // Move this to the top
error_reporting(0);
include('includes/dbconnection.php');

// Now the session check will work correctly
if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
    exit(); // Always add exit after a redirect
} else {
    // Delete Logic (Added to make your Delete button actually work)
    if(isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = mysqli_query($con, "DELETE FROM tblcontact WHERE ID='$rid'");
        echo "<script>alert('Data Deleted');</script>";
        echo "<script>window.location.href='manage-read-enquiry.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Read Enquiry - BPMS Admin</title>
    <link rel="stylesheet" href="css/readenq.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content" class="main-content">
    <div class="container">
        <h1 class="title">Manage Read Enquiry</h1>
        <table>
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
                $ret = mysqli_query($con, "SELECT * FROM tblcontact WHERE IsRead=1 ORDER BY ID DESC");
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
                            <a href="manage-read-enquiry.php?delid=<?php echo $row['ID']; ?>" class="delete-btn" onclick="return confirm('Do you really want to delete this enquiry?');">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php 
                    $cnt++; 
                    } 
                } else { ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:red; padding:20px;">No read enquiries found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>