<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Profile- BPMS</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="include/header.css">
    <link rel="stylesheet" href="include/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body>

<?php include('include/header.php');?>
    <!-- Header Banner -->
    <div class="banner">
        <h1>Profile</h1>
        <p>
            
        </p>
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="dashboard.php">Home</a> > <span>profile</span>
    </div>

    <!-- Main Section -->
    <section class="container">

        <!-- Left Contact Info -->
        <div class="contact-box">
            <div class="info-block">
                <h3> Call Us</h3>
                <p>+1- 2415903</p>
            </div>

            <div class="info-block">
                <h3> Email Us</h3>
                <p>parlour01@gmail.com</p>
            </div>

            <div class="info-block">
                <h3>  Address</h3>
                <p>Thamel, 16 Kathmandu Nepal</p>
            </div>

            <div class="info-block">
                <h3> Time</h3>
                <p>10:00 am to 7:30 pm</p>
            </div>
        </div>

        <!-- Signup Form -->
        <div class="form-box">
            <h2>User Profile!!</h2>

            <form action="register.php" method="POST">

                <div class="row">
                    <div class="col">
                        <label>FullName</label>
                        <input type="text" name="FullName" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile" required>
                    </div>
                    <div class="col">
                        <label>Email Address</label>
                        <input type="email" name="email" required>
                    </div>
                </div>

                <div class="row">
                    
                   <div class="col">
                        <label>Registration Date</label>
                        <input type="date" name="registration_date" required>
                    </div>

                </div>

                <button class="btn">Save Change</button>
            </form>
        </div>

    </section>
<?php include('include/footer.php');?>
</body>
</html>
