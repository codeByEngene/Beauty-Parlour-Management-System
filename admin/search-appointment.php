<?php 
include('includes/dbconnection.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Appointment</title>
    <link rel="stylesheet" href="css/search-appointment.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h1 class="page-title">Search Appointment</h1>
    <div class="card">
        <form method="post" name="search">
            <h3 class="card-title">Search Appointment Number / User ID:</h3>
            <label class="search-label">Search by Appointment Number or User ID</label>
            <input type="text" name="searchdata" id="searchdata" class="search-input" required="true">
            <button type="submit" name="search" class="search-btn">Search</button>
        </form>
    </div>

    <?php
    if(isset($_POST['search'])) {
        $sdata = $_POST['searchdata'];
    ?>
    <div class="card" style="margin-top: 20px;">
        <h4 align="center" style="padding-bottom:15px;">Result against "<?php echo $sdata;?>" keyword </h4>
        <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px;">S.No</th>
                    <th>Appointment Number</th>
                    <th>User ID</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Tapaiko table structure 'tblappointment' anusar ko query
            $ret = mysqli_query($con, "SELECT * FROM tblappointment WHERE AppointmentNumber LIKE '%$sdata%' OR UserID LIKE '%$sdata%'");
            $num = mysqli_num_rows($ret);
            if($num > 0) {
                $cnt = 1;
                while ($row = mysqli_fetch_array($ret)) {
            ?>
                <tr>
                    <td style="padding: 10px;"><?php echo $cnt;?></td>
                    <td><?php echo $row['AppointmentNumber'];?></td>
                    <td><?php echo $row['UserID'];?></td>
                    <td><?php echo $row['AptDate'];?></td>
                    <td><?php echo $row['AptTime'];?></td>
                    <td>
                        <?php 
                        if($row['Status'] == "") {
                            echo "Not Updated Yet";
                        } else {
                            echo $row['Status'];
                        }
                        ?>
                    </td>
                    <td><a href="view-appointment.php?viewid=<?php echo $row['ID'];?>" style="color: blue;">View Details</a></td>
                </tr>
            <?php 
                $cnt = $cnt + 1;
                } 
            } else { ?>
                <tr>
                    <td colspan="7" style="text-align:center; color:red; padding: 20px;">No record found against this search</td>
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