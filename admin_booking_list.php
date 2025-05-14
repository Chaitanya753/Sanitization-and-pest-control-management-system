<?php
// Include database connection
include('db_connection.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-danger'>You must be logged in to view this page.</div>";
    exit();
}

// Check if the logged-in user is an admin

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Booking List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 30px;
        }

        .table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #4CAF50;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="services.php"><i class="fas fa-tree"></i> Services</a>
            <a href="admin_booking_list.php"><i class="fas fa-calendar-alt"></i> Bookings</a>
            <a href="staff.php"><i class="fas fa-user-tie"></i> Staff</a>
            <a href="payment_list.php"><i class="fas fa-money-bill-alt"></i> Payments</a>
            <a href="reviews.php"><i class="fas fa-comments"></i> Reviews</a>
            <a href="profile.php"><i class="fas fa-cogs"></i> Settings</a>
        </div>
<div class="container">
    <h1>All User Bookings</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Service Type</th>
                <th>Booking Date</th>
                <th>Service Time</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all bookings for admin
            $query = "SELECT * FROM bookings ORDER BY booking_date DESC";
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>" . $row['booking_id'] . "</td>
                        <td>" . htmlspecialchars($row['customer_name']) . "</td>
                        <td>" . htmlspecialchars($row['contact_number']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['service_type']) . "</td>
                        <td>" . htmlspecialchars($row['booking_date']) . "</td>
                        <td>" . htmlspecialchars($row['service_time']) . "</td>
                        <td>" . htmlspecialchars($row['address']) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No bookings found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
