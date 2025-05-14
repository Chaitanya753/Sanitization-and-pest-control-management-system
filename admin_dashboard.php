<?php
session_start();
include('db_connection.php'); 

// Fetch total number of services
$serviceQuery = "SELECT COUNT(*) as total_services FROM services";
$serviceResult = $conn->query($serviceQuery);
$serviceCount = $serviceResult->fetch_assoc()['total_services'];

// Fetch total number of staff
$staffQuery = "SELECT COUNT(*) as total_staff FROM staff";
$staffResult = $conn->query($staffQuery);
$staffCount = $staffResult->fetch_assoc()['total_staff'];

// Fetch total number of bookings
$bookingQuery = "SELECT COUNT(*) as total_bookings FROM bookings";
$bookingResult = $conn->query($bookingQuery);
$bookingCount = $bookingResult->fetch_assoc()['total_bookings'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sanitization And Pest Control Management</title>
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
        .main-content {
            margin-left: 210px;
            padding: 20px;
            width: calc(100% - 210px);
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 10px 20px;
            border-bottom: 1px solid #dee2e6;
        }
        .dashboard-header h1 {
            color: #007bff;
        }
        .welcome-message {
            font-size: 2.5rem;
            color: #343a40;
            margin-top: 15px;
            text-align: center;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }
        .dashboard-grid .card {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .dashboard-grid .card i {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 10px;
        }
        .dashboard-grid .card h5 {
            margin: 10px 0;
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

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-header">
                <h1>Admin Dashboard</h1>
                <div>
                    <a href="profile.php" class="btn btn-primary">Profile</a>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>

            <div class="welcome-message">Welcome, Admin!</div>

            <!-- Dashboard Statistics -->
            <div class="dashboard-grid">
                <div class="card">
                    <i class="fas fa-tree"></i>
                    <h5>Total Services</h5>
                    <p><strong><?php echo $serviceCount; ?></strong></p>
                </div>
                <div class="card">
                    <i class="fas fa-user-tie"></i>
                    <h5>Total Staff</h5>
                    <p><strong><?php echo $staffCount; ?></strong></p>
                </div>
                <div class="card">
                    <i class="fas fa-calendar-alt"></i>
                    <h5>Total Bookings</h5>
                    <p><strong><?php echo $bookingCount; ?></strong></p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
