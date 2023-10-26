<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css\design.css">
    <title>Upload Page</title>
</head>
<body>
    <header>
        <div id="navbar">
            <?php include 'navbar\adminNavbar.html'; ?>
        </div>
    </header>

    <?php
$photoDir = 'photo/';
$textDir = 'text/';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle image upload
    if (isset($_FILES["image"])) {
        $imageFileName = basename($_FILES["image"]["name"]);
        $imageTargetPath = $photoDir . $imageFileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imageTargetPath)) {
            echo "Image uploaded successfully.";
        } else {
            echo "Failed to upload image.";
        }
    }

    // Handle text input and save it to a text file with a matching name
    if (isset($_POST["text"])) {
        $text = $_POST["text"];
        // Get the name of the uploaded image file
        $imageFileName = basename($_FILES["image"]["name"]);
        // Remove the file extension (e.g., .jpg or .png) to create a matching text file name
        $textFileName = pathinfo($imageFileName, PATHINFO_FILENAME) . '.txt';
        $textFilePath = $textDir . $textFileName;

        if (file_put_contents($textFilePath, $text) !== false) {
            echo "Text saved successfully.";
        } else {
            echo "Failed to save text.";
        }
    }

    // Handle the "product name" input and save it to the specified directory
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
        // Get the name of the uploaded image file
        $imageFileName = basename($_FILES["image"]["name"]);
        // Remove the file extension to create a matching text file name
        $textFileName = pathinfo($imageFileName, PATHINFO_FILENAME) . '.txt';
        // Define the directory for "product name" files
        $productNameDir = 'C:/xampp/htdocs/mvp1/product name/';
        $productNameFilePath = $productNameDir . $textFileName;

        if (file_put_contents($productNameFilePath, "Product Name: " . $name) !== false) {
            echo "Product name saved successfully.";
        } else {
            echo "Failed to save product name.";
        }
    }

    // Handle the "amount" input and save it to a text file
    if (isset($_POST["amount"])) {
        $amount = $_POST["amount"];
        // Get the name of the uploaded image file
        $imageFileName = basename($_FILES["image"]["name"]);
        // Remove the file extension to create a matching text file name
        $amountFileName = pathinfo($imageFileName, PATHINFO_FILENAME) . '.txt';
        // Define the directory for "amount" files
        $amountDir = 'amount/';
        $amountFilePath = $amountDir . $amountFileName;

        if (file_put_contents($amountFilePath, "Amount (GBP): " . $amount) !== false) {
            echo "Amount saved successfully.";
        } else {
            echo "Failed to save amount.";
        }
    }
}
?>
