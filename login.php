<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the user data file exists
    $user_data_file = "userdata/users.txt";
    if (file_exists($user_data_file)) {
        // Read user data from the file
        $user_data = file_get_contents($user_data_file);
        $user_lines = explode("\n", $user_data);

        $validCredentials = false;

        foreach ($user_lines as $user_line) {
            $user_info = explode(",", $user_line);
            if (count($user_info) == 2 && $user_info[0] == $username && password_verify($password, $user_info[1])) {
                session_start();
                $_SESSION["username"] = $username;
                header("Location: home.php"); // Redirect to a welcome page
                exit;
            }
        }
    } else {
        echo "Invalid username or password, redirecting back to the login screen.";
        echo '<script type="text/javascript">
            setTimeout(function() {
                window.location = "login.html";
            }, 5000);
        </script>';
    }
}
?>
