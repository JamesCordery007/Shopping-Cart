<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $textPath = $data['text'];
    $newText = $data['content'];

    // Update the text file with the new content
    if (file_put_contents($textPath, $newText)) {
        echo "success"; // Return a success message
    } else {
        echo "error"; // Return an error message
    }
}
?>
