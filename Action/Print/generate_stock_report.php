<?php
include '../../db/config.php';

// Check if the stock ID is set in the URL
if (isset($_GET['stock_id'])) {
    $stockId = $_GET['stock_id'];

    // Retrieve stock details from the database
    $sql = "SELECT s.stock_id, s.total_quantity, s.sold_quantity, p.product_name AS product_name 
            FROM stock s 
            INNER JOIN products p ON s.product_id = p.id
            WHERE s.stock_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error preparing the statement: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $stockId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stockData = $result->fetch_assoc();

        // HTML content for the stock invoice
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <title>Stock Details</title>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta charset='UTF-8'>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    font-size: 12px;
                    width: 48mm;
                    margin: 0 auto;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    background-color: #f4f4f4;
                }
                .container {
                    width: 100%;
                    max-width: 48mm;
                    padding: 10px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    box-sizing: border-box;
                }
                .header, .footer {
                    text-align: center;
                    margin-bottom: 10px;
                }
                .header h3 {
                    margin: 5px 0;
                    font-size: 18px;
                    color: #333;
                    text-transform: uppercase;
                }
                .invoice-details, .item-details, .summary {
                    width: 100%;
                    margin-bottom: 10px;
                    text-align: center;
                }
                .invoice-details th, .invoice-details td,
                .item-details th, .item-details td,
                .summary th, .summary td {
                    padding: 5px 0;
                    text-align: center;
                }
                .item-details th, .item-details td {
                    border-bottom: 1px solid #000;
                }
                .item-details th {
                    border-top: 1px solid #000;
                }
                .summary th, .summary td {
                    padding: 5px 0;
                    font-weight: bold;
                }
                .barcode {
                    text-align: center;
                    margin-top: 10px;
                }
                .footer p {
                    color: #888;
                    font-size: 10px;
                }
                @media print {
                    body, .container {
                        width: 100%;
                        height: auto;
                        margin: 0;
                        padding: 0;
                        -webkit-print-color-adjust: exact;
                    }
                    .header h3 {
                        font-size: 16px;
                    }
                    .summary th, .summary td {
                        font-size: 14px;
                    }
                    .item-details th, .item-details td {
                        font-size: 12px;
                    }
                }
            </style>
        </head>
        <body>
        <div class='container'>
            <div class='header'>
                <h3>Dani's Fabric</h3>
                <p>Sialkot, Pakistan</p>
                <p>Email: info@dani'sfabric.com</p>
                <p>Phone: +92 314 7096300</p>
            </div>
            <div class='invoice-details'>
                <table>
                    <tr>
                        <th>Stock ID:</th>
                        <td>{$stockId}</td>
                    </tr>
                </table>
            </div>
            <div class='item-details'>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item</th>
                            <th>Stock Available</th>
                            <th>Stock Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{$stockData['product_name']}</td>
                            <td>{$stockData['total_quantity']}</td>
                            <td>{$stockData['sold_quantity']}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class='barcode'>
                <svg id='barcode'></svg>
            </div>
            <div class='footer'>
                <p>Thank you  Dani's Fabric!</p>
            </div>
        </div>
        <script src='https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js'></script>
        <script>
            JsBarcode('#barcode', '{$stockId}', {
                format: 'CODE128',
                displayValue: true,
                fontSize: 14
            });

            // Trigger print dialog
            window.onload = function() {
                window.print();
            }
        </script>
        </body>
        </html>";

        // Close the prepared statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Stock not found.";
    }
} else {
    echo "Stock ID not provided.";
}
?>
