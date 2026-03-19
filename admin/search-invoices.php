<?php 
include('includes/dbconnection.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Invoice</title>
    <link rel="stylesheet" href="css/search-invoices.css">
    <style>
        .panel { padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fff; margin-bottom: 20px; }
        .input { padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 8px 15px; background-color: #d4a373; color: white; border: none; cursor: pointer; border-radius: 4px; }
        table th, table td { padding: 12px; border: 1px solid #eee; }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h1 class="title">Search Invoice</h1>
    <div class="panel">
        <form method="post" name="search">
            <h3>Search Invoice:</h3>
            <label class="label">Search by Billing Number / Customer Name / Mobile No</label><br><br>
            <input type="text" name="searchdata" id="searchdata" class="input" required="true" placeholder="Enter name or ID...">
            <button type="submit" name="search" class="btn">Search</button>
        </form>
    </div>

    <?php
    if(isset($_POST['search'])) {
        $sdata = mysqli_real_escape_string($con, $_POST['searchdata']);
    ?>
    <div class="panel" style="margin-top: 20px;">
        <h4 align="center">Results for "<?php echo htmlspecialchars($sdata); ?>"</h4>
        <table width="100%" style="border-collapse: collapse; margin-top: 15px; text-align: left;">
            <thead>
                <tr style="background-color: #f8f9fa;">
                    <th>S.No</th>
                    <th>Billing ID</th>
                    <th>Customer Name</th>
                    <th>Mobile Number</th>
                    <th>Invoice Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Fixed the JOIN condition (Userid vs UserId) and added GROUP BY to avoid duplicate rows
            $ret = mysqli_query($con, "SELECT tblinvoice.BillingId, tblusers.FullName, tblusers.MobileNumber, tblinvoice.PostingDate 
                                       FROM tblinvoice 
                                       JOIN tblusers ON tblusers.id = tblinvoice.Userid 
                                       WHERE tblinvoice.BillingId LIKE '%$sdata%' 
                                       OR tblusers.FullName LIKE '%$sdata%' 
                                       OR tblusers.MobileNumber LIKE '%$sdata%'
                                       GROUP BY tblinvoice.BillingId");
            
            $num = mysqli_num_rows($ret);
            if($num > 0) {
                $cnt = 1;
                while ($row = mysqli_fetch_array($ret)) {
            ?>
                <tr>
                    <td><?php echo $cnt;?></td>
                    <td>#<?php echo $row['BillingId'];?></td>
                    <td><?php echo $row['FullName'];?></td>
                    <td><?php echo $row['MobileNumber'];?></td>
                    <td><?php echo date("d-M-Y", strtotime($row['PostingDate']));?></td>
                    <td>
                        <a href="view-invoice.php?invoiceid=<?php echo $row['BillingId'];?>" 
                           style="background-color: #2a9d8f; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; display: inline-block;">
                           View Details
                        </a>
                    </td>
                </tr>
            <?php 
                $cnt++;
                } 
            } else { ?>
                <tr>
                    <td colspan="6" style="text-align:center; color:red; padding:20px;">No records found for "<?php echo htmlspecialchars($sdata); ?>".</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>