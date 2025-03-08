<?php
include '../../db/config.php';


// Check if the product name is provided in the GET parameter
if (isset($_GET['product_name'])) {
    // Get the product name from the GET parameter and sanitize it
    $productName = mysqli_real_escape_string($connection, $_GET['product_name']);

    // Construct the SQL query to fetch total_quantity from the stock table
    $query = "SELECT total_quantity FROM stock WHERE name = '$productName'";

    // Perform the query
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch the total_quantity from the result
            $row = mysqli_fetch_assoc($result);
            $totalQuantity = $row['total_quantity'];

            // Return the total_quantity as a response
            echo $totalQuantity;
        } else {
            // No rows found with the given product name
            echo "0"; // or handle the case as per your application logic
        }
    } else {
        // Query execution error
        echo "Error: " . mysqli_error($connection);
    }

    // Free result set
    mysqli_free_result($result);
} else {
    // If product name is not provided in GET parameter
    echo "Error: Product name parameter is missing.";
}

// Close connection
mysqli_close($connection);
?>
