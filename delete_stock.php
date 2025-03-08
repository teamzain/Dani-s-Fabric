<?php
@include 'db/config.php';

if (isset($_POST['productName']) && isset($_POST['quantity'])) {
    $productName = $_POST['productName'];
    $quantity = intval($_POST['quantity']);

    // Update stock quantities
    $updateQuery = "UPDATE stock SET total_quantity = total_quantity + ?, sold_quantity = sold_quantity - ? WHERE name = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("iis", $quantity, $quantity, $productName);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Product deleted and stock updated successfully.";
    } else {
        echo "Failed to update stock.";
    }
} else {
    echo "Invalid request.";
}
?>