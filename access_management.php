<?php  
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_GET['id'];
@include 'db/config.php';

// Fetch staff member information
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$staff = $stmt->get_result()->fetch_assoc();

// Fetch available sections and their files
$sections = [
    'Dashboard' => ['dashboard.php'],
    'Authentication' => ['staff_access_authentication.php'],
    'Registration' => [
        'customer_registration.php',
        'vendor_registration.php',
        'vehicle_registration.php',
        'staff_registration.php'
    ],
    'Products & Transactions' => [
        'product_data.php',
        'purchase.php',
        'sale.php',
        'return.php',
        'exchange.php',
        'booking.php'
    ],
    'Stock Management' => ['stock_management.php'],
    'Financials' => [
        'shop_expense.php',
        'customer_balance_sheet.php',
        'vendor_balance_sheet.php'
    ],
    'Reports' => [
        'daily_report.php',
        'monthly_report.php',
        'yearly_report.php'
    ]
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_files = isset($_POST['files']) ? $_POST['files'] : [];
    $files_string = implode(',', $selected_files);

    // Update staff access in the database
    $update_sql = "UPDATE users SET sections = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $files_string, $user_id);
    $update_stmt->execute();

    header("Location: staff_access_authentication.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        /* Main content area styling */
.main-content {
    padding: 20px;
    margin-left: 250px; /* Adjust based on sidebar width if applicable */
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

/* Form styling */
form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;
}

form h3 {
    font-size: 20px;
    margin-bottom: 10px;
    color: #333;
}

form .section {
    margin-bottom: 20px;
}

form label {
    display: block;
    font-size: 16px;
    margin-bottom: 8px;
    color: #555;
}

form input[type="checkbox"] {
    margin-right: 10px;
}

form .btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

form .btn:hover {
    background-color: #0056b3;
}

/* Responsive styling for small screens */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
    }

    form {
        padding: 15px;
        margin: 10px;
    }
}

    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="main-content">
<?php include 'topbar.php'; ?>

    <h2>Manage Access for <?php echo htmlspecialchars($staff['name']); ?></h2>
    <form action="" method="POST">
        <?php foreach ($sections as $section => $files): ?>
            <div class="section">
                <h3><?php echo htmlspecialchars($section); ?></h3>
                <?php foreach ($files as $file): ?>
                    <label>
                        <input type="checkbox" name="files[]" value="<?php echo htmlspecialchars($file); ?>"
                            <?php if (in_array($file, explode(',', $staff['sections']))) echo 'checked'; ?>>
                        <?php echo htmlspecialchars($file); ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn">Save Changes</button>
    </form>
</main>

<script src="assets/script.js"></script>
</body>
</html>