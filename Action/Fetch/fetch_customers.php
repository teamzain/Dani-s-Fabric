<?php
include '../../db/config.php';

// Check if search query is provided
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Initialize an empty array to store customers
$customers = array();

try {
    // Fetch customer data
    $sql = "SELECT customer_name FROM customers";
    
    if (!empty($query)) {
        // Use prepared statements to avoid SQL injection
        $stmt = $conn->prepare("SELECT customer_name FROM customers WHERE customer_name LIKE ?");
        $searchTerm = '%' . $query . '%';
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // If no query, execute the basic query
        $result = $conn->query($sql);
    }

    // Check if there are any results
    if ($result && $result->num_rows > 0) {
        // Fetch data and populate the customers array
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }

    // Return customer data as JSON
    header('Content-Type: application/json');
    echo json_encode($customers);

} catch (Exception $e) {
    // Return an error message if something goes wrong
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}

// Close connection
$conn->close();
?>
