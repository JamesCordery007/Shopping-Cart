<html>
    <head>
    <link rel="stylesheet" type="text/css" href="css\design.css">
    </head>
    <body>
    <header>
    <div id="navbar">
        <?php include 'navbar\adminNavbar.html'; ?>
    </div>
</header>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apiUsername = isset($_POST['api_username']) ? $_POST['api_username'] : "";
    $apiPassword = isset($_POST['api_password']) ? $_POST['api_password'] : "";

    // Check if the "api_details" folder exists and create it if it doesn't.
    if (!file_exists("api_details")) {
        mkdir("api_details", 0777, true);
    }

    // Save API username to "API_name.txt"
    $apiNameFile = "api_details/API_name.txt";
    file_put_contents($apiNameFile, $apiUsername);

    // Save API password to "API_password.txt"
    $apiPasswordFile = "api_details/API_password.txt";
    file_put_contents($apiPasswordFile, $apiPassword);

    echo "API details saved successfully.";
}
?>

</body>
</html>