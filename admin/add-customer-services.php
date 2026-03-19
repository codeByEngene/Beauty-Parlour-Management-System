<?php include 'includes/dbconnection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Services</title>
    <link rel="stylesheet" href="css/add-customer-services.css">
    <link rel="stylesheet" href="includes/sidebar.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <div class="page">
        <h2 class="title">Assign Services</h2>
        <div class="card">
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
                    $query = mysqli_query($con, "SELECT * FROM services");
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['cost']; ?></td>
                            <td><input type="checkbox" name="selected_services[]" value="<?php echo $row['id']; ?>"></td>
                        </tr>
                    <?php $cnt++; } ?>
                    </tbody>
                </table>
                <div class="submit-area">
                    <button type="submit" name="assign" class="btn-primary" style="padding: 10px 20px; cursor: pointer; background: #d4a373; border: none; color: white;">Submit & Create Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>