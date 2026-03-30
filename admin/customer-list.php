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
    <title>Customer List - BPMS Admin</title>
    <link rel="stylesheet" href="css/customer-list.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main id="main-content" class="main-content">
    <div class="page">
        <h2 class="title">Customer List</h2>
        <div class="card">
            <h3>Registered Customers:</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $ret = mysqli_query($con, "SELECT * FROM tblusers WHERE role='user' ORDER BY id DESC");
                $cnt = 1;
                if(mysqli_num_rows($ret) > 0) {
                    while ($row = mysqli_fetch_array($ret)) {
                ?>
                    <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row['FullName']; ?></td>
                        <td><?php echo $row['MobileNumber']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="add-customer-services.php?addid=<?php echo $row['id']; ?>" class="assign">Assign Services</a>
                            </div>
                        </td>
                    </tr>
                <?php 
                    $cnt++; 
                    } 
                } else { ?>
                    <tr>
                        <td colspan="6" style="text-align:center; color:red; padding:20px;">No customers registered yet.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="js/script.js"></script>
</body>
</html>
<?php } ?>