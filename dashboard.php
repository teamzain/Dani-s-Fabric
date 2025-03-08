<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

@include 'db/config.php';

// Fetch total customers
$customer_sql = "SELECT COUNT(*) AS total_customers FROM customers";
$customer_result = $conn->query($customer_sql);
$customer_row = $customer_result->fetch_assoc();
$total_customers = $customer_row['total_customers'];

// Fetch total suppliers
$supplier_sql = "SELECT COUNT(*) AS total_suppliers FROM supplier";
$supplier_result = $conn->query($supplier_sql);
$supplier_row = $supplier_result->fetch_assoc();
$total_suppliers = $supplier_row['total_suppliers'];

// Fetch total staff
$staff_sql = "SELECT COUNT(*) AS total_staff FROM staff";
$staff_result = $conn->query($staff_sql);
$staff_row = $staff_result->fetch_assoc();
$total_staff = $staff_row['total_staff'];

$product_sql = "SELECT COUNT(*) AS total_product FROM products";
$product_result = $conn->query($product_sql);
$product_row = $product_result->fetch_assoc();
$total_product = $product_row['total_product'];

$purchase_sql = "SELECT SUM(grand_total) AS total_purchase_today FROM purchase WHERE DATE(invoice_date) = CURDATE()";
$purchase_result = $conn->query($purchase_sql);

if ($purchase_result) {
    $purchase_row = $purchase_result->fetch_assoc();
    $total_purchase_today = $purchase_row['total_purchase_today'] ? $purchase_row['total_purchase_today'] : 0;
}

$sale_sql = "SELECT SUM(grand_total) AS total_sale_today FROM sale WHERE DATE(invoice_date) = CURDATE()";
$sale_result = $conn->query($sale_sql);

if ($sale_result) {
    $sale_row = $sale_result->fetch_assoc();
    $total_sale_today = $sale_row['total_sale_today'] ? $sale_row['total_sale_today'] : 0;
}

$conn->close();

// Get current date and time
$current_datetime = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dani's Fabrico Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<?php include 'navbar.php'; ?>
 
    <main class="main-content">
    <?php include 'topbar.php'; ?>

        <div class="card-container">
            <div class="card">
                <i class="card-icon fas fa-wallet"></i>
                <div class="card-title">Today's Purchase</div>
                <div class="card-value">Rs<?php echo number_format($total_purchase_today, 2); ?></div>
            </div>
            <div class="card">
                <i class="card-icon fas fa-wallet"></i>
                <div class="card-title">Today's Sale</div>
                <div class="card-value">Rs<?php echo number_format($total_sale_today, 2); ?></div>
            </div>
            <div class="card">
                <i class="card-icon fas fa-box-open"></i>
                <div class="card-title">Total Product</div>
                <div class="card-value"><?php echo $total_product; ?></div>
            </div>
            <div class="card">
                <i class="card-icon fas fa-clock"></i>
                <div class="card-title">Current Date & Time</div>
                <div class="card-value" id="current-datetime"></div>
            </div>
        </div>

        <div class="card-container">
            <div class="card">
                <i class="card-icon fas fa-users"></i>
                <div class="card-title">Total Customers</div>
                <div class="card-value"><?php echo $total_customers; ?></div>
            </div>
            <div class="card">
                <i class="card-icon fas fa-truck"></i>
                <div class="card-title">Total Suppliers</div>
                <div class="card-value"><?php echo $total_suppliers; ?></div>
            </div>
            <div class="card">
                <i class="card-icon fas fa-user-tie"></i>
                <div class="card-title">Staff</div>
                <div class="card-value"><?php echo $total_staff; ?></div>
            </div>
        </div>
    </main>

    <script src="assets/script.js"></script>
    <script>
        function updateDateTime() {
            const now = new Date();
            const options = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric', 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: true
            };
            const formattedDateTime = now.toLocaleString(undefined, options);
            document.getElementById('current-datetime').textContent = formattedDateTime;
        }

        // Update time immediately and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>
</html>