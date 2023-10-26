<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css\design.css">
    <title>Design Page</title>
</head>
<body>
<?php
session_start();

if (!isset($_SESSION["username"])) {
    // If the session variable "username" is not set, the user is not logged in
    header("Location: login.html"); // Redirect to the login page
    exit;
}

function getAdditionalInfo($imageFileName) {
    $amountDir = 'amount/';
    $productNameDir = 'product name/';
    $fileNameWithoutExtension = pathinfo($imageFileName, PATHINFO_FILENAME);

    $amountFile = $amountDir . $fileNameWithoutExtension . '.txt';
    $productNameFile = $productNameDir . $fileNameWithoutExtension . '.txt';

    $amount = file_exists($amountFile) ? file_get_contents($amountFile) : 'Amount: N/A';
    $productName = file_exists($productNameFile) ? file_get_contents($productNameFile) : 'Product Name: N/A';

    return ['amount' => $amount, 'productName' => $productName];
}
?>
<header>
    <div id="navbar">
        <?php include 'navbar\adminNavbar.html'; ?>
    </div>
</header>
<h1>Design Page</h1>

<h2>The text can be edited on this page:</h2>
<div id="imageTextContainer">
    <?php
    $photoDir = 'photo/';
    $textDir = 'text/';

    // Retrieve the list of image files
    $photoFiles = scandir($photoDir);

    foreach ($photoFiles as $file) {
        if ($file !== '.' && $file !== '..') {
            $textFileName = pathinfo($file, PATHINFO_FILENAME) . '.txt';
            $imagePath = "$photoDir$file";
            $textPath = "$textDir$textFileName";
            $text = file_get_contents($textPath);

            // Get additional information for the image
            $additionalInfo = getAdditionalInfo($file);

            echo "<div class='image-text-item' draggable='true' ondragstart='drag(event)'>";
            echo "<div class='additional-info'>{$additionalInfo['productName']}</div>"; // Display product name
            echo "<img src='$imagePath' alt='Image'><br>";
            echo "<div class='text-content' contenteditable='true' data-textpath='$textPath'>$text</div>";
            echo "<div class='additional-info'>{$additionalInfo['amount']}</div>";
            echo "<button class='delete-btn' data-image='$imagePath' data-text='$textPath'>Delete</button>";
            echo "<button class='save-text-btn' data-textpath='$textPath'>Save Text</button>";
            echo "</div>";
        }
    }
    ?>
</div>

<script>
    // JavaScript to handle the click event for the "Delete" button
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-btn')) {
            const imagePath = e.target.dataset.image;
            const textPath = e.target.dataset.text;
            const itemElement = e.target.parentElement;
            if (confirm('Are you sure you want to delete this item?')) {
                deleteItem(imagePath, textPath, itemElement);
            }
        }
    });

    // JavaScript function to handle item deletion
    function deleteItem(imagePath, textPath, itemElement) {
        fetch('delete.php', {
            method: 'POST',
            body: JSON.stringify({ image: imagePath, text: textPath }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.text())
        .then(result => {
            if (result === 'success') {
                alert('Item deleted successfully.');
                itemElement.remove(); // Remove the item from the page
            } else {
                alert('Failed to delete the item.');
            }
        });
    }

    // JavaScript function to handle text changes and save the text
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('text-content')) {
            const textPath = e.target.getAttribute('data-textpath');
            const newText = e.target.innerText;
            saveTextToTextFile(textPath, newText);
        }
    });

    // JavaScript function to save text to the text file
    function saveTextToTextFile(textPath, newText) {
        fetch('update_text.php', {
            method: 'POST',
            body: JSON.stringify({ text: textPath, content: newText }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
      //  .then(response => response.text())
      //  .then(result => {
       //     if (result === 'success') {
       //         alert('Text updated and saved successfully.');
       //     } else {
       //         alert('Failed to update and save the text.');
       //     }
      //  });
    }
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
