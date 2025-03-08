<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Styled Tables</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .table-container {
            max-width: 100%;
            margin: 0 auto 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        th {
            background-color: #4a4a4a;
            color: white;
            text-align: left;
            padding: 15px;
            font-weight: bold;
            white-space: nowrap;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            white-space: nowrap;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .step-number {
            font-weight: bold;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
        }
        .color-1 { background-color: #FF7F50; }
        .color-2 { background-color: #FF6B6B; }
        .color-3 { background-color: #8A2BE2; }
        .color-4 { background-color: #4169E1; }
        .color-5 { background-color: #3CB371; }

        .edit-btn, .print-btn {
            color: #4a4a4a;
            margin-right: 10px;
            text-decoration: none;
        }
        .edit-btn:hover, .print-btn:hover {
            color: #1a1a1a;
        }

        /* Simplified recent-orders table styles */
        .recent-orders table {
            width: 100%;
            border-collapse: collapse;
        }
        .recent-orders th, .recent-orders td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .recent-orders th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Invoice Date</th>
                    <th>Supplier Name</th>
                    <th>Product Name</th>
                    <th>Received Quantity</th>
                    <th>Purchasing Price</th>
                    <th>Total Amount</th>
                    <th>Grand Total</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Payment Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Your existing PHP code here
                ?>
            </tbody>
        </table>
    </div>
    
    <div class="table-container recent-orders">
        <table id="show">
            <tr>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Received Quantity</th>
                <th>Total Amount</th>
            </tr>
            <!-- Add your PHP code here to populate this table -->
        </table>
    </div>

    <!-- Your existing JavaScript code here -->

</body>
</html>