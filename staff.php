<?php
include('db_connection.php');
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit;
}

// Define Admin Users (Replace with actual admin user IDs)
$admin_ids = [1, 2]; // Example: user_id 1 and 2 are admins

// Check if the user is an admin
if (!in_array($_SESSION['user_id'], $admin_ids)) {
    echo "Access denied!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Staff Management</title>
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
        .container { max-width: 900px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; color: #4CAF50; margin-bottom: 30px; }
        .table th { background-color: #f2f2f2; color: #333; }
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
    <h1>Admin - Staff Management</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Service Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT staff_id, name, email, contact_number, service_name FROM staff ORDER BY staff_id DESC";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>" . $row['staff_id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['contact_number'] . "</td>
                        <td>" . $row['service_name'] . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No staff found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2 class="mt-5">Add New Staff</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
    <label for="service_name" class="form-label">Service Name</label>
    <select class="form-control" id="service_name" name="service_name" required>
        <option value="" disabled selected>Select Service</option>
        <option value="Sanitization Services">Sanitization Services</option>
        <option value="Pest Control">Pest Control</option>
        <option value="Disinfection Services">Disinfection Services</option>
        <option value="Customized Solutions">Customized Solutions</option>
    </select>
</div>

        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Staff</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
        $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);

        $insert_query = "INSERT INTO staff (name, email, contact_number, service_name) VALUES ('$name', '$email', '$contact_number', '$service_name')";
        
        // if (mysqli_query($conn, $insert_query)) {
        //     echo "<div class='alert alert-success mt-3'>Staff added successfully!</div>";
        //     echo "<script>setTimeout(function() { window.location.reload(); }, 2000);</script>";
        // } else {
        //     echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
        // }
    }
    ?>
</div>

</body>
</html>
