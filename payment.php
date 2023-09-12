<?php

$username = 'iuospcpc0onok906'; // Basic Auth username
$password = 'tf5zohhzsl7erll1prui7pz12d2tzq6q09g2bfqwajah1qicc3fmnnhqfq72m0bi'; // Basic Auth password
$url = 'https://try.access.worldpay.com/payment_pages';

// Retrieve address details from the checkout page
$name = $_POST['name'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$town = $_POST['town'];
$county = $_POST['county'];
$postcode = $_POST['postcode'];

// Calculate the total amount from the checkout page
$totalAmount = $_POST['totalAmount'];

// JSON data
$jsonData = array(
    "transactionReference" => "Memory265-13/08/1876",
    "merchant" => array(
        "entity" => "MindPalaceLtd"
    ),
    "narrative" => array(
        "line1" => "Mind Palace Ltd"
    ),
    "value" => array(
        "currency" => "GBP",
        "amount" => $totalAmount*100
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

?>

