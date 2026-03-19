<?php
include 'includes/dbconnection.php';

// Code for Deletion
if(isset($_GET['delid'])) {
    $id = $_GET['delid'];
    mysqli_query($con, "DELETE FROM services WHERE id = '$id'");
    echo "<script>alert('Data Deleted');</script>";
    echo "<script>window.location.href='manage-services.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Manage Services</title>
    <link rel="stylesheet" href="css/manage-services.css">
    <link rel="stylesheet" href="includes/sidebar.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="container">
            <h2 class="page-title">Manage Services</h2>
            <div class="card-box">
                <table class="service-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Service Price</th>
                            <th>Creation Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $ret = mysqli_query($con, "SELECT * FROM services ORDER BY id DESC");
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($ret)) {
                    ?>
                        <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['cost']; ?></td>
                            <td><?php echo $row['creation_date']; ?></td>
                            <td class="action-buttons">
                                <a href="edit-services.php?editid=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                                <a href="manage-services.php?delid=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Do you really want to delete?');">Delete</a>
                            </td>
                        </tr>
                    <?php $cnt++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>