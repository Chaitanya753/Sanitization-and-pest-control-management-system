<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit;
}

// Get payment ID from URL
if (!isset($_GET['payment_id'])) {
    echo "Invalid payment ID!";
    exit;
}

$payment_id = $_GET['payment_id'];

// Fetch payment details using payment_id
$query = "SELECT p.payment_id, p.payment_date, p.price, p.card_type,
                 b.customer_name, b.contact_number, b.service_type
          FROM payments p
          JOIN bookings b ON p.booking_id = b.booking_id
          WHERE p.payment_id = ? AND p.user_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $payment_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No payment record found!";
    exit;
}

$bill = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h2 {
            color: #343a40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .print-btn {
            background-color: #28a745;
        }
        .print-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Payment Receipt</h2>
    <table>
        <tr>
            <th>Payment ID</th>
            <td><?php echo htmlspecialchars($bill['payment_id']); ?></td>
        </tr>
        <tr>
            <th>Payment Date</th>
            <td><?php echo date("d-m-Y H:i:s", strtotime($bill['payment_date'])); ?></td>
        </tr>
        <tr>
            <th>Customer Name</th>
            <td><?php echo htmlspecialchars($bill['customer_name']); ?></td>
        </tr>
        <tr>
            <th>Contact Number</th>
            <td><?php echo htmlspecialchars($bill['contact_number']); ?></td>
        </tr>
        <tr>
            <th>Service Type</th>
            <td><?php echo htmlspecialchars($bill['service_type']); ?></td>
        </tr>
        <tr>
            <th>Paid Amount</th>
            <td>₹<?php echo number_format($bill['price'], 2); ?></td>
        </tr>
        <tr>
            <th>Payment Method</th>
            <td><?php echo htmlspecialchars($bill['card_type']); ?></td>
        </tr>
    </table>

    <a href="index.php" class="btn">Back to Home</a>
    <button class="btn print-btn" onclick="window.print()">Print Bill</button>
</div>

</body>
</html>
