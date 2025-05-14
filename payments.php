<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit;
}

$user_id = $_SESSION['user_id'];

// Get booking ID from URL
if (!isset($_GET['booking_id'])) {
    echo "Invalid booking!";
    exit;
}

$booking_id = $_GET['booking_id'];

// Fetch booking details
$query = "SELECT b.customer_name, b.contact_number, b.service_type, b.price
          FROM bookings b 
          LEFT JOIN payments p ON b.booking_id = p.booking_id
          WHERE b.booking_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No booking found!";
    exit;
}

$booking = $result->fetch_assoc();
$stmt->close();

// Insert payment details if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $card_type = $_POST['card_type'];
    $card_number = $_POST['card_number'];
    $cvv = $_POST['cvv'];
    $expiry_date = $_POST['expiry_date'];
    $amount = $booking['price'];
    
    // Insert payment into database
    $insert_query = "INSERT INTO payments (booking_id, user_id, price, card_type, card_number, cvv, expiry_date, payment_date, payment_status) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 'completed')";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iisssss", $booking_id, $user_id, $amount, $card_type, $card_number, $cvv, $expiry_date);
    
    if ($stmt->execute()) {
        // Get the newly inserted payment ID
        $payment_id = $stmt->insert_id;
        
        // Redirect to bill page using payment_id
        header("Location: bill.php?payment_id=" . $payment_id);
        exit();
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #343a40;
        }
        label {
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Payment Details</h2>
    <form action="" method="POST">
        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="<?php echo htmlspecialchars($booking['customer_name']); ?>" readonly>

        <label>Contact Number:</label>
        <input type="text" name="contact_number" value="<?php echo htmlspecialchars($booking['contact_number']); ?>" readonly>

        <label>Service Type:</label>
        <input type="text" name="service_type" value="<?php echo htmlspecialchars($booking['service_type']); ?>" readonly>

        <label>Total Amount (₹):</label>
        <input type="text" name="amount" value="<?php echo number_format($booking['price'], 2); ?>" readonly>

        <h3>Card Details</h3>

        <label>Card Type:</label>
        <select name="card_type" required>
            <option value="Debit Card">Debit Card</option>
            <option value="Credit Card">Credit Card</option>
        </select>

        <label>Card Number:</label>
        <input type="text" name="card_number" placeholder="1234 5678 9012 3456" required pattern="\d{16}">

        <label>CVV:</label>
        <input type="text" name="cvv" placeholder="123" required pattern="\d{3}">

        <label>Expiry Date:</label>
        <input type="month" name="expiry_date" required>

        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
        
        <button type="submit" class="btn">Submit Payment</button>
    </form>
</div>

</body>
</html>
