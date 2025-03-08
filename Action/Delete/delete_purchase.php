<?php
include '../../db/config.php';  // Include the database connection

if (isset($_GET['purchase_id'])) {
    $purchaseId = $_GET['purchase_id'];

    // Fetch product and quantity details for the purchase to restore stock
    $fetchPurchaseQuery = "SELECT product_name, received_quantity FROM purchase WHERE purchase_id = ?";
    $stmtFetchPurchase = $conn->prepare($fetchPurchaseQuery);
    $stmtFetchPurchase->bind_param("i", $purchaseId);
    $stmtFetchPurchase->execute();
    $stmtFetchPurchase->bind_result($productNamesJson, $receivedQuantitiesJson);
    $stmtFetchPurchase->fetch();
    $stmtFetchPurchase->close();

    // Decode JSON data to arrays
    $productNames = json_decode($productNamesJson, true);
    $receivedQuantities = json_decode($receivedQuantitiesJson, true);

    // Restore stock for each product in the purchase
    foreach ($productNames as $index => $productName) {
        $quantity = $receivedQuantities[$index] ?? 0; // Handle missing or null quantity

        // Fetch current stock quantity
        $fetchStockQuery = "SELECT total_quantity FROM stock WHERE name = ?";
        $stmtFetchStock = $conn->prepare($fetchStockQuery);
        $stmtFetchStock->bind_param("s", $productName);
        $stmtFetchStock->execute();
        $stmtFetchStock->bind_result($currentQuantity);
        $stmtFetchStock->fetch();
        $stmtFetchStock->close();

        if ($currentQuantity !== null) {
            // Update the stock by adding the received quantity back to total_quantity
            $newQuantity = $currentQuantity + $quantity;
            $updateStockQuery = "UPDATE stock SET total_quantity = ? WHERE name = ?";
            $stmtUpdateStock = $conn->prepare($updateStockQuery);
            $stmtUpdateStock->bind_param("is", $newQuantity, $productName);
            $stmtUpdateStock->execute();
            $stmtUpdateStock->close();
        }
    }

    // Now delete the purchase record from the purchase table
    $deletePurchaseQuery = "DELETE FROM purchase WHERE purchase_id = ?";
    $stmtDeletePurchase = $conn->prepare($deletePurchaseQuery);
    $stmtDeletePurchase->bind_param("i", $purchaseId);
    if ($stmtDeletePurchase->execute()) {
        echo "Purchase record deleted successfully!";
    } else {
        echo "Error deleting purchase record: " . $conn->error;
    }
    $stmtDeletePurchase->close();

    // Redirect to the purchase page after deletion
    header("Location: purchase.php");
    exit();
} else {
    echo "No purchase ID provided.";
}
?>
