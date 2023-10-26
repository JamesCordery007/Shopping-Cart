<!DOCTYPE html>
<html>
<head>
    <title>Design Page</title>
    <style>
        .image-text-item {
            display: inline-block;
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            position: relative;
            cursor: grab;
        }

        .text-content {
            resize: both;
            overflow: auto;
            min-height: 50px;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Design Page</h1>

    <h2>Images and Editable Text:</h2>
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

                echo "<div class='image-text-item' draggable='true' ondragstart='drag(event)'>";
                echo "<img src='$imagePath' alt='Image'><br>";
                echo "<div class='text-content' contenteditable='true'>$text</div>";
                echo "<button class='delete-btn' data-image='$imagePath' data-text='$textPath'>Delete</button>";
                echo "</div>";
            }
        }
        ?>
    </div>

    <button id="saveButton">Save</button>

<script>
    // JavaScript function to initiate the file deletion
    function deleteFile(imagePath, textPath) {
        // Here, you should make an AJAX request to a server-side script
        // that handles the file deletion. I'll provide a placeholder example.
        
        // Example: Sending a request to delete.php
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
                    alert('Files deleted successfully.');
                } else {
                    alert('Failed to delete files.');
                }
            });
    }

    // JavaScript to handle the click event for the "Delete" button
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-btn')) {
            const imagePath = e.target.dataset.image;
            const textPath = e.target.dataset.text;
            if (confirm('Are you sure you want to delete this item?')) {
                deleteFile(imagePath, textPath);
                // You can also remove the item from the page here.
                e.target.parentElement.remove();
            }
        }
    });

    // JavaScript to save the page content to "products.php"
    document.getElementById('saveButton').addEventListener('click', function () {
        // Assuming you are using PHP to handle the save process
        fetch('save_content.php', {
            method: 'POST',
            body: document.documentElement.outerHTML,
        })
            .then(() => alert('Content saved in "products.php"'))
            .catch(error => alert('Failed to save content: ' + error));
    });
</script>

  
</body>
</html>
