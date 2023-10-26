<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $text = $data['text'];

    $filePath = 'homeText/homeText.txt';
   // $filePath = 'C:/xampp/htdocs/mvp1/homeText.txt';

    if (file_put_contents($filePath, $text) !== false) {
        echo 'success'; // Return success response
    } else {
        echo 'error'; // Return an error response if text saving failed
    }
} else {
    // Invalid request method
    header("HTTP/1.0 405 Method Not Allowed");
    echo 'Method Not Allowed';
}
?>
