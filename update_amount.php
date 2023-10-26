<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->amount) && isset($data->content)) {
        $amountPath = $data->amount;
        $newAmount = $data->content;

        if (file_put_contents($amountPath, $newAmount) !== false) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
?>
