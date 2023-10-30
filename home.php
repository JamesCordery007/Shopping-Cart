<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="css\design.css">
</head>
<body>

<?php
session_start();

if (!isset($_SESSION["username"])) {
    // If the session variable "username" is not set, the user is not logged in
    header("Location: login.html"); // Redirect to the login page
    exit;
}
?>


<header>
    <div id="navbar">
        <?php include 'navbar\adminNavbar.html'; ?>
    </div>
</header>
<h1>Home Page</h1>

<p>Add a description of what your company does and any other details you require.</p>

<!-- Text update form -->
<form id="textForm">
    <textarea id="textContent" rows="10" cols="50"></textarea>
    <br>
    <button type="submit">Save Text</button>
</form>

<!-- Add a Logout button -->
<form action="logout.php" method="post">
    <button type="submit">Logout</button>
</form>

<!-- Email update form -->
<!--
<form id="emailForm">
    <label for="emailUpdate">Update Email Contact:</label>
    <input type="email" id="emailUpdate" name="emailUpdate" required>
    <button type="submit">Save Email</button>
</form>
-->

<div id="message"></div>

<script>
    document.getElementById('textForm').addEventListener('submit', function (e) {
        e.preventDefault();
        
        const text = document.getElementById('textContent').value;
        saveTextToFile(text);
    });

    /*
    document.getElementById('emailForm').addEventListener('submit', function (e) {
        e.preventDefault();
        
        const email = document.getElementById('emailUpdate').value;
        saveEmailToFile(email);
    });
    */

    function saveTextToFile(text) {
        fetch('save_text.php', {
            method: 'POST',
            body: JSON.stringify({ text: text }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.text())
        .then(result => {
            if (result === 'success') {
                document.getElementById('message').textContent = 'Text saved successfully.';
            } else {
                document.getElementById('message').textContent = 'Failed to save text.';
            }
        });
    }

    /*
    function saveEmailToFile(email) {
        fetch('save_email.php', {
            method: 'POST',
            body: JSON.stringify({ email: email }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.text())
        .then(result => {
            if (result === 'success') {
                document.getElementById('message').textContent = 'Email saved successfully.';
            } else {
                document.getElementById('message').textContent = 'Failed to save email.';
            }
        });
    }
    */
</script>
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
