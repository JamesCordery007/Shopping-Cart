<?php
$productNameDir = 'C:/xampp/htdocs/mvp1/product name/'; // Adjust the path accordingly
$productNameFileName = 'product_name.txt'; // Name of the "product name" file
$productNameFilePath = $productNameDir . $productNameFileName;

$productName = file_exists($productNameFilePath) ? file_get_contents($productNameFilePath) : 'Product Name: N/A';
?>
