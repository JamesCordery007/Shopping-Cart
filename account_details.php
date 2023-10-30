<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css\design.css">
    <title>Products page</title>
    <title>Account Details</title>
</head>
<body>
<header>
    <div id="navbar">
        <?php include 'navbar\adminNavbar.html'; ?>
    </div>
</header>
    <h1>API Account Details</h1>
    <form method="post" action="process_account.php">
        <label for="api_username">API User Name:</label>
        <input type="text" name="api_username" id="api_username" required><br><br>

        <label for="api_password">API Password:</label>
        <input type="password" name="api_password" id="api_password" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>