<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <title>Checkout Page</title>
</head>
<body>
<header>
    <div id="navbar">
        <?php include 'navbar/navbar.html'; ?>
    </div>
</header>

<h1>Checkout Page</h1>

<?php
// Generate a unique transaction reference number
$transactionReference = uniqid() . "-" . date("d/m/Y");

// User input for billing information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $billingName = $_POST["billingName"];
    $billingAddress1 = $_POST["billingAddress1"];
    $billingAddress2 = $_POST["billingAddress2"];
    $billingAddress3 = $_POST["billingAddress3"];
    $billingPostalCode = $_POST["billingPostalCode"];
    $billingCity = $_POST["billingCity"];
    $billingCountryCode = $_POST["billingCountryCode"];
} else {
    // Default billing information
    $billingName = "Sherlock Holmes";
    $billingAddress1 = "221B Baker Street";
    $billingAddress2 = "Marylebone";
    $billingAddress3 = "Westminster";
    $billingPostalCode = "NW1 6XE";
    $billingCity = "London";
    $billingCountryCode = "GB";
}

// Retrieve the total amount from the URL
$amount = isset($_GET['total']) ? $_GET['total'] : 0;

// Retrieve the selected items from local storage (if available)
$selectedItems = [];

if (isset($_GET['items'])) {
    // If items are sent via URL, store them in local storage
    $itemsJSON = $_GET['items'];
    $selectedItems = json_decode($itemsJSON, true);
    // Store the selected items in local storage for future visits
    $selectedItemsJSON = json_encode($selectedItems);
    echo "<script>localStorage.setItem('selectedItems', '$selectedItemsJSON');</script>";
} elseif (isset($_GET['items']) && $_GET['items'] === 'clear') {
    // If a 'clear' signal is sent via URL, clear local storage
    echo "<script>localStorage.removeItem('selectedItems');</script>";
}



// Output the selected items and quantities
if (!empty($selectedItems)) {
    echo "<h2>Selected Items:</h2>";
    echo "<ul>";
    foreach ($selectedItems as $item) {
        $itemName = $item['item'];
        $quantity = $item['quantity'];
        echo "<li>$itemName (Quantity: $quantity)</li>";
    }
    echo "</ul>";
}

// Output the transaction reference
echo "<h2>Transaction Details:</h2>";
echo "<p>Transaction Reference: $transactionReference</p>";
echo "<p>Transaction Amount: GBP $amount</p>";
echo "<p>Description:</p>";
if (!empty($selectedItems)) {
    echo "<ul>";
    foreach ($selectedItems as $item) {
        $itemName = $item['item'];
        $quantity = $item['quantity'];
        echo "<li>$itemName (Quantity: $quantity)</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Mind Palace Ltd</p>";
}
?>

<h2>Billing Address:</h2>
<form method="post" action="send_payment.php">
    <input type="hidden" name="transactionReference" value="<?php echo $transactionReference; ?>">
    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
    <input type="hidden" name="selectedItems" value="<?php echo json_encode($selectedItems); ?>">
    <label for="billingName">Name:</label>
    <input type="text" id="billingName" name="billingName" value="<?php echo $billingName; ?>" required><br>

    <label for="billingAddress1">Address Line 1:</label>
    <input type="text" id="billingAddress1" name="billingAddress1" value="<?php echo $billingAddress1; ?>" required><br>

    <label for="billingAddress2">Address Line 2:</label>
    <input type="text" id="billingAddress2" name="billingAddress2" value="<?php echo $billingAddress2; ?>"><br>

    <label for="billingAddress3">Address Line 3:</label>
    <input type="text" id="billingAddress3" name="billingAddress3" value="<?php echo $billingAddress3; ?>"><br>

    <label for="billingPostalCode">Postal Code:</label>
    <input type="text" id="billingPostalCode" name="billingPostalCode" value="<?php echo $billingPostalCode; ?>" required><br>

    <label for="billingCity">City:</label>
    <input type="text" id="billingCity" name="billingCity" value="<?php echo $billingCity; ?>" required><br>

    <label for="billingCountryCode">Country Code:</label>
    <input type="text" id="billingCountryCode" name="billingCountryCode" value="<?php echo $billingCountryCode; ?>" required><br>

    <input type="submit" value="Submit to WorldPay">
</form>

</body>
</html>
