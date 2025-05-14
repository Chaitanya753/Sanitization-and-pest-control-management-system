<?php
// Include database connection
include('db_connection.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    exit("Please log in to proceed.");
}

// Get user info from the 'users' table
$user_id = $_SESSION['user_id'];
$query = "SELECT name, email FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    $user_name = $user_data['name'];
    $user_email = $user_data['email'];
} else {
    echo "<div class='alert alert-danger'>User not found.</div>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $service_id = mysqli_real_escape_string($conn, $_POST['service_type']);
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
    $service_time = mysqli_real_escape_string($conn, $_POST['service_time']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Fetch the service price from the services table
    $service_query = "SELECT name, price FROM services WHERE service_id = ?";
    $stmt = mysqli_prepare($conn, $service_query);
    mysqli_stmt_bind_param($stmt, "i", $service_id);
    mysqli_stmt_execute($stmt);
    $service_result = mysqli_stmt_get_result($stmt);

    if ($service_result && mysqli_num_rows($service_result) > 0) {
        $service_data = mysqli_fetch_assoc($service_result);
        $service_name = $service_data['name'];
        $service_price = $service_data['price'];
    } else {
        echo "<div class='alert alert-danger'>Invalid service selected.</div>";
        exit();
    }

    // Insert data into the bookings table, including service price
    $query = "INSERT INTO bookings (customer_name, contact_number, email, service_type, price, booking_date, service_time, address, user_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssisssi", $customer_name, $contact_number, $email, $service_name, $service_price, $booking_date, $service_time, $address, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Get the last inserted booking ID
        $booking_id = mysqli_insert_id($conn);
        // Redirect to payments page with the booking ID
        header("Location: payments.php?booking_id=$booking_id");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Fetch available services for dropdown
$service_options = "";
$services_query = "SELECT service_id, name FROM services";
$result = mysqli_query($conn, $services_query);

while ($row = mysqli_fetch_assoc($result)) {
    $service_options .= "<option value='{$row['service_id']}'>{$row['name']}</option>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Our Services - Sanitization & Pest Control</title>
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
            max-width: 800px;
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

        .form-label {
            font-size: 16px;
            font-weight: bold;
        }

        .form-control, .form-select {
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
        }

        .btn-success {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-success:hover {
            background-color: #45a049;
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
    <h1>Book Our Services</h1>

    <!-- Booking Form -->
    <form method="POST">
        <div class="mb-3">
            <label for="customer_name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($user_name); ?>" required>
        </div>

        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email (Optional)</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>">
        </div>

        <div class="mb-3">
            <label for="service_type" class="form-label">Service Type</label>
            <select class="form-select" id="service_type" name="service_type" required>
                <?php echo $service_options; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="booking_date" class="form-label">Booking Date</label>
            <input type="date" class="form-control" id="booking_date" name="booking_date" required>
        </div>

        <div class="mb-3">
            <label for="service_time" class="form-label">Preferred Service Time</label>
            <input type="time" class="form-control" id="service_time" name="service_time" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Booking</button>
    </form>
</div>

</body>
</html>
