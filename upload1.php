<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css\design.css">
    <title>Upload Page</title>
</head>
<body>
<?php
session_start();

if (!isset($_SESSION["username"])) {
    // If the session variable "username" is not set, the user is not logged in
    header("Location: login.html"); // Redirect to the login page
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the "image" field is set and contains a file
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Upload the image to a specified folder
        $imageFolder = "uploads/";
        $targetPath = $imageFolder . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);

        // Get the filename without the file extension
        $fileNameWithoutExtension = pathinfo($_FILES["image"]["name"], PATHINFO_FILENAME);

        // Check if the "amount" field is set
        if (isset($_POST["amount"])) {
            $amount = $_POST["amount"];
            // Save the "amount" in a folder called "amount" with the same file name as the image
            file_put_contents("amount/" . $fileNameWithoutExtension . ".txt", "GBP: " . $amount);
        }

        // Check if the "name" field is set
        if (isset($_POST["name"])) {
            $name = $_POST["name"];
            // Save the "name" in a folder called "product name" with the same file name as the image
            file_put_contents("product name/" . $fileNameWithoutExtension . ".txt", "Product Name: " . $name);
        }
    }
}
?>

<header>
    <div id="navbar">
        <?php include 'navbar\adminNavbar.html'; ?>
    </div>
</header>
<h1>Upload Page</h1>
<p>This page allows you to upload your images and add some text below to tell us about the product</p>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <!-- Input field for uploading an image -->
    <input type="file" name="image" accept="image/*" required>
    <br>

    <!-- Input field for entering the amount (GBP) -->
    <input type="text" name="amount" placeholder="Enter amount in GBP">
    <br>

    <!-- Input field for entering the product name -->
    <input type="text" name="name" placeholder="Enter product name">
    <br>

    <!-- Textarea for inputting and saving text -->
    <textarea name="text" rows="4" cols="50" placeholder="Enter text here"></textarea>
    <br>

    <input type="submit" value="Upload">
</form>

<script>
    // Define the inactivity timeout in milliseconds (5 seconds)
    const inactivityTimeout = 500000;
    let timeout;

    function resetTimer() {
        clearTimeout(timeout);
        timeout = setTimeout(redirectToLogin, inactivityTimeout);
    }

    function redirectToLogin() {
        // Redirect to the login page
        window.location.href = 'login.html';
    }

    // Reset the timer when the page loads
    resetTimer();

    // Listen for user activity events
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);
</script>

</body>
</html>
