<?php
include '../../db/config.php';

$query = "SELECT p.id, p.product_name, p.price
          FROM products p
          LEFT JOIN stock s ON p.id = s.product_id
          WHERE p.status = 'Active' AND s.total_quantity > 0";
$result = mysqli_query($conn, $query);

$products = array();
while($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

echo json_encode($products);
?>