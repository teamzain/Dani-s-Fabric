<?php

include '../../db/config.php'; // Ensure the correct path to config.php

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);  // Sanitize the ID

    // Prepare the SQL query to delete the customer
    $sql = "DELETE FROM products WHERE id = $id";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the customer registration page after deletion
        header('Location: ../../product_data.php'); 
    } else {
        // Display an error message if the query fails
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
