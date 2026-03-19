<?php include('includes/dbconnection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice List</title>
    <link rel="stylesheet" href="css/invoices.css">
    <link rel="stylesheet" href="includes/sidebar.css">
    <style>
        /* Small internal fix for table layout if css/invoices.css is missing some parts */
        .container { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; }
        tr:hover { background-color: #f1f1f1; }
        .view-btn:hover { opacity: 0.8; }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h2 class="title" style="margin-left: 20px; margin-top: 20px;">Invoice List</h2>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Invoice ID</th>
                    <th>Customer Name</th>
                    <th>Invoice Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Using GROUP BY BillingId ensures one row per invoice even if there are multiple services
            $ret = mysqli_query($con, "SELECT 
                                        tblusers.FullName, 
                                        tblinvoice.BillingId, 
                                        tblinvoice.PostingDate 
                                       FROM tblinvoice 
                                       JOIN tblusers ON tblusers.id = tblinvoice.Userid 
                                       GROUP BY tblinvoice.BillingId 
                                       ORDER BY tblinvoice.PostingDate DESC");
            
            $cnt = 1;
            // Check if there are any results
            if(mysqli_num_rows($ret) > 0) {
                while ($row = mysqli_fetch_array($ret)) {
            ?>
                <tr>
                    <td><?php echo $cnt; ?></td>
                    <td>#<?php echo $row['BillingId']; ?></td>
                    <td><?php echo $row['FullName']; ?></td>
                    <td><?php echo date("d-M-Y H:i", strtotime($row['PostingDate'])); ?></td>
                    <td class="action-buttons">
                        <a href="view-invoice.php?invoiceid=<?php echo $row['BillingId']; ?>" 
                           class="view-btn" 
                           style="background: #2a9d8f; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; display: inline-block;">
                           View Invoice
                        </a>
                    </td>
                </tr>
            <?php 
                $cnt++; 
                } 
            } else { ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No invoices found.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>