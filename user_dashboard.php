<?php
session_start();
include 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch total bookings for the user
$bookingQuery = "SELECT COUNT(*) as total_bookings FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($bookingQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$totalBookings = $result->fetch_assoc()['total_bookings'];
$stmt->close();

// Fetch total payments made by the user
$paymentQuery = "SELECT SUM(price) as total_paid FROM payments WHERE user_id = ?";
$stmt = $conn->prepare($paymentQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$totalPaid = $result->fetch_assoc()['total_paid'] ?? 0;
$stmt->close();

// Fetch total reviews given by the user
$reviewQuery = "SELECT COUNT(*) as total_reviews FROM reviews WHERE user_id = ?";
$stmt = $conn->prepare($reviewQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$totalReviews = $result->fetch_assoc()['total_reviews'];
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Sanitization and Pest Control</title>
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
            <a href="user_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="user_services.php"><i class="fas fa-tree"></i> Available Services</a>
            <a href="bookings.php"><i class="fas fa-calendar-alt"></i> My Bookings</a>
            <a href="user_staff.php"><i class="fas fa-user-tie"></i> Staff</a>
            <a href="user_payment_list.php"><i class="fas fa-money-bill-alt"></i> Payments</a>
            <a href="reviews.php"><i class="fas fa-comments"></i> Reviews</a>
            <a href="profile.php"><i class="fas fa-cogs"></i> Settings</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-header">
                <h1>User Dashboard</h1>
                <div>
                    <a href="profile.php" class="btn btn-primary">Profile</a>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>

            <div class="welcome-message">Welcome, User!</div>

            <!-- Dashboard Statistics -->
            <div class="dashboard-grid">
                <div class="card">
                    <i class="fas fa-calendar-alt"></i>
                    <h5>My Bookings</h5>
                    <p><strong><?php echo $totalBookings; ?></strong></p>
                </div>
                <div class="card">
                    <i class="fas fa-money-bill-alt"></i>
                    <h5>Payments</h5>
                    <p><strong>₹<?php echo number_format($totalPaid, 2); ?></strong></p>
                </div>
                <div class="card">
                    <i class="fas fa-comments"></i>
                    <h5>My Reviews</h5>
                    <p><strong><?php echo $totalReviews; ?></strong></p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
