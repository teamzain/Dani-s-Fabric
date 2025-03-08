<?php
// Include database configuration
@include 'db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST request
    $purchase_id = $_POST['purchase_id'];
    $paid_amount = $_POST['paid_amount'];
    $due_amount = $_POST['due_amount'];

    // Validate and sanitize input
    if (is_numeric($paid_amount) && is_numeric($due_amount) && !empty($purchase_id)) {
        // Update query
        $updateQuery = "UPDATE purchase SET paid_amount = ?, due_amount = ? WHERE purchase_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('ddi', $paid_amount, $due_amount, $purchase_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
}
$conn->close();
?>
