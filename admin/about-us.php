<?php 
$conn = new mysqli("localhost", "root", "", "pms_db");

$msg = ""; // Initialize an empty message variable

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_btn'])) {
    $title = mysqli_real_escape_string($conn, $_POST['page_title']);
    $desc = mysqli_real_escape_string($conn, $_POST['page_description']);

    $sql = "UPDATE about_settings SET page_title='$title', page_description='$desc' WHERE id=1";
    
    if ($conn->query($sql) === TRUE) {
        $msg = "success"; // Set flag for the popup
    } else {
        $msg = "error";
    }
}

// Fetch current data for the form
$result = $conn->query("SELECT * FROM about_settings WHERE id=1");
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update About Us</title>
    <link rel="stylesheet" href="css/about-us.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <div class="container">
        <h1 class="title">Update About Us</h1>
        <div class="panel">
            <form method="POST" action="">
                <h3>Update About Us:</h3>

                <label>Page Title</label>
                <input type="text" name="page_title" value="<?php echo $data['page_title']; ?>" class="input">

                <label>Page Description</label>
                <textarea name="page_description" class="textarea"><?php echo $data['page_description']; ?></textarea>

                <div class="action-buttons">
                    <button type="submit" name="update_btn" class="btn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if ($msg == "success"): ?>
<script>
    // This is a simple browser alert popup
    alert("Update Successfully!");
    
    // Optional: Redirect back to the same page to clear the POST data
    window.location.href = "about-us.php"; 
</script>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>