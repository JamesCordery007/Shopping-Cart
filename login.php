<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Read user data from the flat file
    $user_data = file_get_contents("userdata/users.txt");
    $user_lines = explode("\n", $user_data);

    foreach ($user_lines as $user_line) {
        $user_info = explode(",", $user_line);
        if (count($user_info) == 2 && $user_info[0] == $username && password_verify($password, $user_info[1])) {
            session_start();
            $_SESSION["username"] = $username;
            header("Location: home.php"); // Redirect to a welcome page
            exit;
        }
    }

    echo "Invalid username or password";
}
?>
