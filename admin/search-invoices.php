<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php'); 

if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Invoices | Admin</title>
    <link rel="stylesheet" href="css/search-invoices.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main class="main-content" id="main-content">
    <h1 class="title"><i class="fa fa-search-plus"></i> Search Invoices</h1>
    
    <div class="panel search-card">
        <form method="post" name="search">
            <h3 class="panel-subtitle">Filter Billing Records</h3>
            <label class="label">Customer Name, Mobile No, or Invoice ID</label>
            <div class="search-group">
                <div class="input-with-icon">
                    <i class="fa fa-terminal"></i>
                    <input type="text" name="searchdata" id="searchdata" class="input" required="true" placeholder="Start typing to search...">
                </div>
                <button type="submit" name="search" class="btn-search">
                    <i class="fa fa-search"></i> Search
                </button>
                
                <?php if(isset($_POST['search'])): ?>
                    <a href="search-invoices.php" class="btn-clear"><i class="fa fa-refresh"></i> Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <?php
    if(isset($_POST['search'])) {
        $sdata = mysqli_real_escape_string($con, $_POST['searchdata']);
    ?>
    <div class="panel result-card">
        <h4 class="result-info"><i class="fa fa-list-alt"></i> Results for: "<span><?php echo htmlspecialchars($sdata); ?></span>"</h4>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Billing ID</th>
                    <th>Customer Name</th>
                    <th>Mobile</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $ret = mysqli_query($con, "SELECT i.BillingId, u.FullName, u.MobileNumber, i.PostingDate 
                                       FROM tblinvoice i 
                                       JOIN tblusers u ON u.id = i.Userid 
                                       WHERE i.BillingId LIKE '%$sdata%' 
                                       OR u.FullName LIKE '%$sdata%' 
                                       OR u.MobileNumber LIKE '%$sdata%'
                                       GROUP BY i.BillingId
                                       ORDER BY i.PostingDate DESC");
            
            $num = mysqli_num_rows($ret);
            if($num > 0) {
                $cnt = 1;
                while ($row = mysqli_fetch_array($ret)) {
            ?>
                <tr>
                    <td><?php echo $cnt;?></td>
                    <td><strong>#<?php echo $row['BillingId'];?></strong></td>
                    <td><?php echo $row['FullName'];?></td>
                    <td><?php echo $row['MobileNumber'];?></td>
                    <td><?php echo date("d-M-Y", strtotime($row['PostingDate']));?></td>
                    <td>
                        <a href="view-invoice.php?invoiceid=<?php echo $row['BillingId'];?>" class="btn-view">
                            <i class="fa fa-eye"></i> Details
                        </a>
                    </td>
                </tr>
            <?php 
                $cnt++;
                } 
            } else { ?>
                <tr>
                    <td colspan="6" class="no-data">
                        <i class="fa fa-search-minus"></i> No invoices found matching your criteria.
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
<?php } ?>