<?php

// Basic Auth credentials
$username = 'iuospcpc0onok906'; // Basic Auth username
$password = 'tf5zohhzsl7erll1prui7pz12d2tzq6q09g2bfqwajah1qicc3fmnnhqfq72m0bi'; // Basic Auth password

// Worldpay URL
$url = 'https://try.access.worldpay.com/payment_pages';

// Retrieve address details from the checkout page
$name = $_POST['name'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$town = $_POST['town'];
$county = $_POST['county'];
$postcode = $_POST['postcode'];

// Calculate the total amount from the checkout page and convert to pence (two added zeros)
$totalAmount = floatval($_POST['totalAmount']) * 100;

// Generate a unique transaction reference
$transactionReference = generateTransactionReference();

// JSON data
$jsonData = array(
    "transactionReference" => $transactionReference,
    "merchant" => array(
        "entity" => "MindPalaceLtd"
    ),
    "narrative" => array(
        "line1" => "Mind Palace Ltd"
    ),
    "value" => array(
        "currency" => "GBP",
        "amount" => $totalAmount
    ),
    // Add address details
    "address" => array(
        "name" => $name,
        "address1" => $address1,
        "address2" => $address2,
        "town" => $town,
        "county" => $county,
        "postcode" => $postcode
    )
);

$jsonPayload = json_encode($jsonData);

// Set headers
$headers = array(
    'Content-Type: application/vnd.worldpay.payment_pages-v1.hal+json',
    'Accept: application/vnd.worldpay.payment_pages-v1.hal+json'
);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);

// Execute cURL session and capture the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo 'Response: ' . $response;
}

// Close cURL session
curl_close($ch);

// Function to generate a unique transaction reference
function generateTransactionReference() {
    // Generate a timestamp-based reference combined with a random number
    $timestamp = time();
    $randomNumber = mt_rand(1000, 9999); // Adjust the range as needed
    return "Memory{$timestamp}-{$randomNumber}";
}

?>
