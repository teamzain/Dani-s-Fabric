<?php
 
 include '../../db/config.php';

// Fetching product details based on barcode_number
$barcode = $_GET['barcode_number'];

// Prepare SQL statement (example assuming 'products' table structure)
$sql = "SELECT product_name, price FROM products WHERE barcode_number = '$barcode'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the first row (assuming barcode is unique)
    $row = $result->fetch_assoc();
    $product = [
        'product_name' => $row['product_name'],
        'price' => $row['price']
    ];
    echo json_encode($product);
} else {
    echo json_encode(null); // Return null if product not found (optional)
}

$conn->close();
?>
