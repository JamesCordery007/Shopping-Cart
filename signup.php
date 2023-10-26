<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

    // Save the user data in a flat file
    $user_data = "$username,$password\n";
    file_put_contents("userdata/users.txt", $user_data, FILE_APPEND);

    header("Location: login.html"); // Redirect to login page
}
?>
