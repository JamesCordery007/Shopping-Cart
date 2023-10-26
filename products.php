<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css\products.css">
    <title>Products page</title>
</head>
<body>
<header>
    <div id="navbar">
        <?php include 'navbar\navbar.html'; ?>
    </div>
</header>

<h1>Products page</h1>

<h2>This is what the shopper will see:</h2>
<div id="mainBody"><p>On this page, all the products will be displayed</p></div>
<div id="imageTextContainer">
    <?php
    $photoDir = 'photo/';
    $textDir = 'text/';
    $amountDir = 'amount/';

    // Retrieve the list of image files
    $photoFiles = scandir($photoDir);

    foreach ($photoFiles as $file) {
        if ($file !== '.' && $file !== '..') {
            $textFileName = pathinfo($file, PATHINFO_FILENAME) . '.txt';
            $imagePath = "$photoDir$file";
            $textPath = "$textDir$textFileName";
            $text = file_get_contents($textPath);

            // Get the corresponding "amount" file
            $amountFileName = pathinfo($file, PATHINFO_FILENAME) . '.txt';
            $amountPath = "$amountDir$amountFileName";
            $amount = file_exists($amountPath) ? file_get_contents($amountPath) : 'Amount (GBP): N/A';

            echo "<div class='image-text-item' draggable='false'>";
            echo "<img src='$imagePath' alt='Image'><br>";
            echo "<div class='text-content' contenteditable='false'>$text</div>";
            echo "<div class='amount-content' contenteditable='false'>$amount</div>";

            // Add a button for each item
            echo "<form method='POST'>";
            echo "<button type='button' class='add-to-cart' data-amount='$amount'>Add to Cart</button>";
            echo "</form>";

            echo "</div>";
        }
    }
    ?>
</div>

<!-- Display the cart total -->
<div id="cart-total">
    <p>Cart Total: GBP <span id="cart-amount">0.00</span></p>
</div>

<script>
    // JavaScript to handle the "Add to Cart" button click event
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartAmountElement = document.getElementById('cart-amount');
    let cartTotal = 0; // Initialize the cart total

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const amount = this.getAttribute('data-amount');
            // Extract the numeric value from the "amount" text
            const numericAmount = parseFloat(amount.match(/\d+\.\d+|\d+/));
            
            // Add the numericAmount to the cartTotal
            cartTotal += numericAmount;

            // Update the cart total display
            cartAmountElement.textContent = cartTotal.toFixed(2);

            // Log the cart total to the console
            console.log('Cart Total: GBP ' + cartTotal.toFixed(2));
        });
    });
</script>
</body>
</html>
