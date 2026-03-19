<?php
include('includes/dbconnection.php');
// Fetch dynamic info
$ret = mysqli_query($con, "SELECT * FROM tblpages WHERE PageType='contactus'");
$row = mysqli_fetch_array($ret);
?>

<?php
session_start();
include('includes/dbconnection.php');

if(isset($_POST['submit'])) {

    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $phone   = mysqli_real_escape_string($con, $_POST['phone']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $query = mysqli_query($con,
        "INSERT INTO tblcontact(Name, Phone, Email, Message)
         VALUES ('$name','$phone','$email','$message')"
    );

    if ($query) {
        echo "<script>alert('Your message was sent successfully!');</script>";
        echo "<script>window.location='contact.php'</script>";
    } else {
        echo "<script>alert('Something went wrong');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - BPMS</title>
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="includes/header.css">
    <link rel="stylesheet" href="includes/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<?php include('includes/header.php');?>
<section class="contact-section">

    <div class="contact-info">
        <div class="box">
            <h3>Call Us</h3>
            <p><?php echo $row['MobileNumber']; ?></p>
        </div>
        <div class="box">
            <h3>Email Us</h3>
            <p><?php echo $row['Email']; ?></p>
        </div>
        <div class="box">
            <h3>Address</h3>
            <p><?php echo $row['PageDescription']; ?></p>
        </div>
        <div class="box">
            <h3>Time</h3>
            <p><?php echo $row['Timing']; ?></p>
        </div>
    </div>

    <form class="contact-form" method="POST"> 
        <div class="row">
            <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="row">
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <textarea name="message" placeholder="Message" required></textarea>

        <button type="submit" name="submit">Send Message</button>
    </form>

</section>
    <?php include ('includes/footer.php');?>
</body>
</html>
