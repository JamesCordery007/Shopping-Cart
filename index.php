<DOCTYPE html>
    <html>
        <head>
         <link rel="stylesheet" type="text/css" href="css\products.css">
        </head>
        <body>
            
            <header>
              <div id="navbar">
                <?php include 'navbar\navbar.html'; ?>
             </div>
            </header>

            <h1>Home page</h1>

<h2>Homepage for the Shopping cart:</h2>
<div id="mainBody">
    <?php
    $filePath = 'homeText/HomeText.txt';

    if (file_exists($filePath)) {
        $text = file_get_contents($filePath);
        echo '<p>' . $text . '</p>';
    } else {
        echo '<p>Text not found.</p>';
    }
    ?>
</div>
</body>
</html>