<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read API username from "API_name.txt"
    $apiNameFile = 'api_details/API_name.txt';
    if (file_exists($apiNameFile)) {
        $username = trim(file_get_contents($apiNameFile));
    } else {
        echo "API username file not found.";
        exit;
    }

    // Read API password from "API_password.txt"
    $apiPasswordFile = 'api_details/API_password.txt';
    if (file_exists($apiPasswordFile)) {
        $password = trim(file_get_contents($apiPasswordFile));
    } else {
        echo "API password file not found.";
        exit;
    }

    $transactionReference = isset($_POST['transactionReference']) ? $_POST['transactionReference'] : "";
    $amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
    $billingName = isset($_POST['billingName']) ? $_POST['billingName'] : "";
    $billingAddress1 = isset($_POST['billingAddress1']) ? $_POST['billingAddress1'] : "";
    $billingAddress2 = isset($_POST['billingAddress2']) ? $_POST['billingAddress2'] : "";
    $billingAddress3 = isset($_POST['billingAddress3']) ? $_POST['billingAddress3'] : "";
    $billingPostalCode = isset($_POST['billingPostalCode']) ? $_POST['billingPostalCode'] : "";
    $billingCity = isset($_POST['billingCity']) ? $_POST['billingCity'] : "";
    $billingCountryCode = isset($_POST['billingCountryCode']) ? $_POST['billingCountryCode'] : "";

    $description = isset($_POST['description']) ? $_POST['description'] : "Your default transaction description";

    $data = array(
        "transactionReference" => $transactionReference,
        "merchant" => array(
            "entity" => "POxxxxxxxxx"
        ),
        "narrative" => array(
            "line1" => "Your narrative line here"
        ),
        "value" => array(
            "currency" => "GBP",
            "amount" => $amount * 100
        ),
        "description" => $description,
        "billingAddressName" => $billingName,
        "billingAddress" => array(
            "address1" => $billingAddress1,
            "address2" => $billingAddress2,
            "address3" => $billingAddress3,
            "postalCode" => $billingPostalCode,
            "city" => $billingCity,
            "state" => "",
            "countryCode" => $billingCountryCode
        )
    );

    $json_data = json_encode($data);

    $url = "https://try.access.worldpay.com/payment_pages";

    $headers = array(
        'Content-Type: application/vnd.worldpay.payment_pages-v1.hal+json',
        'Accept: application/vnd.worldpay.payment_pages-v1.hal+json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password"); // Set the Basic Auth username and password
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    }

    curl_close($ch);

    if ($result) {
        // Decode the JSON response
        $response = json_decode($result, true);

        // Check if the response contains a URL for redirection
        if (isset($response['url'])) {
            $redirectUrl = $response['url'];

            // Redirect the user to the provided URL
            header("Location: $redirectUrl");
            exit;
        } else {
            // Handle the case where no redirection URL is provided
            echo "Response from WorldPay: " . $result;
        }
    }
}
?>
