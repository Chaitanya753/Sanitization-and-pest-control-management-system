<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch only logged-in user's payment records
$query = "SELECT b.booking_id AS booking_id, b.customer_name, b.service_type, b.service_time, b.price, 
                 p.payment_id AS payment_id, p.payment_status
          FROM bookings b
          LEFT JOIN payments p ON b.booking_id = p.booking_id
          WHERE b.user_id = ?
          ORDER BY b.service_time DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>User - Payment List</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            color: #333;

        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            width: 210px;
            position: fixed; 
            transition: all 0.3s;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            font-size: 1.3rem;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
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
        .status-completed {
            color: green;
            font-weight: bold;
        }
        .status-pending {
            color: red;
            font-weight: bold;
        }
        .btn {
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
        }
        .btn-pay {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-pay:hover {
            background-color: #218838;
        }
        .btn-home {
            background-color: #007bff;
            color: white;
        }
        .btn-home:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="user_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="user_services.php"><i class="fas fa-tree"></i> Available Services</a>
            <a href="bookings.php"><i class="fas fa-calendar-alt"></i> My Bookings</a>
            <a href="user_staff.php"><i class="fas fa-user-tie"></i> Staff</a>
            <a href="user_payment_list.php"><i class="fas fa-money-bill-alt"></i> Payments</a>
            <a href="reviews.php"><i class="fas fa-comments"></i> Reviews</a>
            <a href="profile.php"><i class="fas fa-cogs"></i> Settings</a>
        </div>

<div class="container">
    <h1>My Payments</h1>
    <table>
        <tr>
            <th>Service Type</th>
            <th>Service Date</th>
            <th>Total Amount</th>
            <th>Payment Status</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['service_type']); ?></td>
            <td><?php echo date("d-m-Y", strtotime($row['service_time'])); ?></td>
            <td>₹<?php echo number_format($row['price'], 2); ?></td>
            <td class="<?php echo ($row['payment_status'] == 'completed') ? 'status-completed' : 'status-pending'; ?>">
                <?php echo ucfirst($row['payment_status']); ?>
            </td>
            <td>
                <?php if ($row['payment_status'] == 'pending'): ?>
                    <a href="payment.php?booking_id=<?php echo $row['booking_id']; ?>" class="btn btn-pay">Make Payment</a>
                <?php else: ?>
                    <span>Paid</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php" class="btn btn-home">Back to Home</a>
    </div>
</div>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
