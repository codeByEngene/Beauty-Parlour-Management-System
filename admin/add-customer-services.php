<?php 
session_start();
include('includes/dbconnection.php');

// Check login
if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Services | BPMS Admin</title>
    <link rel="stylesheet" href="css/add-customer-services.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main class="main-content" id="main-content">
    <div class="page">
        <h2 class="title">Assign Services</h2>
        <div class="card">
            <h3>Select Services for Invoice:</h3>
            
            <form method="post" action="save-invoice.php?addid=<?php echo $_GET['addid']; ?>">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Service Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Fetching services from database
                    $query = mysqli_query($con, "SELECT * FROM services");
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['cost']; ?></td>
                            <td>
                                <input type="checkbox" name="selected_services[]" value="<?php echo $row['id']; ?>" style="transform: scale(1.2);">
                            </td>
                        </tr>
                    <?php $cnt++; } ?>
                    </tbody>
                </table>

                <div class="submit-area">
                    <button type="submit" name="assign" class="btn-assign">Submit & Create Invoice</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="js/script.js"></script>
</body>
</html>
<?php } ?>