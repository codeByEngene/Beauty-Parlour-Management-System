<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <title>Booking History</title>
  <link rel="stylesheet" href="style5.css">
  <link rel="stylesheet" href="include/header.css">
  <link rel="stylesheet" href="include/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<?php include('include/header.php');?>
    <!-- Banner Section -->
    <section class="page-banner">
        <div class="banner-overlay">
            <h1>Booking History</h1>
            <p>
                Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                Hic fuga sit illo modi aut aspernatur tempore laboriosam
                saepe dolores eveniet.
            </p>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="dashboard.php">Home</a>
        <span>›</span>
        <span class="active">Booking History</span>
    </div>

    <!-- Appointment History -->
    <section class="content">
        <h2 class="section-title">Appointment History</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Appointment Number</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Appointment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="no-record">
                            No Record Found
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Scroll to Top Button -->
    <div class="scroll-top">↑</div>
<?php include('include/footer.php');?>

</body>
</html>
