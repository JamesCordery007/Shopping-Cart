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
<!-- Button to redirect to the checkout page -->
<div id="checkout-button">
    <button id="go-to-checkout-button">Go to Checkout</button>
</div>
<!-- Display the cart total -->
<div id="cart-total">
    <p>Cart Total: GBP <span id="cart-amount">0</span></p>
</div>
<br>
<div id="imageTextContainer">
    <?php
    $productNameDir = 'product name/';
    $photoDir = 'photo/';
    $textDir = 'text/';
    $amountDir = 'amount/';

    // Initialize an array to store selected items and quantities
    $selectedItems = [];

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

            // Get the corresponding "product name" file
            $productNameFileName = pathinfo($file, PATHINFO_FILENAME) . '.txt';
            $productNamePath = "$productNameDir$productNameFileName";
            $productName = file_exists($productNamePath) ? file_get_contents($productNamePath) : 'Product Name: N/A';

            // Display the product name content
            echo "<div class='product-name-content' contenteditable='false'>$productName</div>";
            echo "<div class='image-text-item' draggable='false'>";
            echo "<img src='$imagePath' alt='Image'><br>";
            echo "<div class='text-content' contenteditable='false'>$text</div>";
            echo "<div class='amount-content' contenteditable='false'>$amount</div>";

            // Add a button for each item
            echo "<form method='POST'>";
            echo "<input type='hidden' name='item_name' value='$productName'>";
            echo "<input type='hidden' name='item_amount' value='$amount'>";
            echo "<button type='button' class='add-to-cart' data-amount='$amount' data-item='$productName'>Add to Cart</button>";
            echo "</form>";
            echo "</div>";
        }
    }
    ?>
</div>

<script>
    // JavaScript to handle the "Add to Cart" button click event
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartAmountElement = document.getElementById('cart-amount');
    let cartTotal = 0; // Initialize the cart total
    let cartItems = []; // Initialize the cart items array

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const amount = this.getAttribute('data-amount');
            const item = this.getAttribute('data-item');
            const numericAmount = parseFloat(amount.match(/\d+\.\d+|\d+/)); // Extract numeric amount

            // Convert the numeric amount to a whole number
            const wholeAmount = parseInt(numericAmount);

            // Add the item and its quantity to the cart
            cartItems.push({ item, quantity: 1, amount: wholeAmount }); // Include the whole amount

            // Update the cart total
            cartTotal += wholeAmount;

            // Update the cart total display
            cartAmountElement.textContent = cartTotal;
        });
    });
</script>

<script>
    // JavaScript to handle the button click event to redirect to the checkout page
    document.getElementById('go-to-checkout-button').addEventListener('click', function () {
        // Create a JSON string of the selected items and quantities
        const cartItemsJSON = JSON.stringify(cartItems);

        // Log the data to the console
        console.log('Data being sent to checkout.php:');
        console.log('Total Amount: ' + cartTotal);
        console.log('Items: ' + cartItemsJSON);

        // Redirect to the checkout.php page with the total amount and items in the URL
        window.location.href = `checkout.php?total=${cartTotal}&items=${cartItemsJSON}`;
    });
</script>

</body>
</html
