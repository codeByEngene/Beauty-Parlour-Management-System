<?php include('includes/dbconnection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Read Enquiry</title>
    <link rel="stylesheet" href="css/readenq.css">
</head>
<body>
<?php include 'includes/header.php'; include 'includes/sidebar.php'; ?>

<div class="main-content">
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
                $ret = mysqli_query($con, "SELECT * FROM tblcontact WHERE IsRead=1 ORDER BY id DESC");
                $cnt = 1;
                while ($row = mysqli_fetch_array($ret)) {
                ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['PostingDate']; ?></td>
                    <td>
                        <div class="action-buttons">
      <a href="view-enquiry.php?viewid=<?php echo $row['ID']; ?>" class="view-btn" style="padding:5px 10px; background:#d4a373; color:white; text-decoration:none; border-radius:4px; display:inline-block;">View</a>
                                <a href="delete-enquiry.php?id=<?php echo $row['ID']; ?>" class="delete-btn" style="padding:5px 10px; background:red; color:white; text-decoration:none; border-radius:4px; margin-left:5px;" onclick="return confirm('Do you really want to delete?');">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php $cnt++; } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>