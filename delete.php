<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $imagePath = $data['image'];
    $textPath = $data['text'];

    // Delete the image file
    if (file_exists($imagePath)) {
        unlink($imagePath); // Delete the image file
    } else {
        // Image file not found
    }

    // Determine the associated text file based on the image path
    $textPath = str_replace('photo/', 'text/', $imagePath);
    $textPath = pathinfo($textPath, PATHINFO_FILENAME) . '.txt';

    // Delete the associated text file
    if (file_exists($textPath)) {
        unlink($textPath); // Delete the text file
    } else {
        // Text file not found
    }

    echo "success"; // Return a success message
}
?>
