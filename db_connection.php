<?php
// Database Configuration
$host = "localhost"; // Your database host (e.g., localhost)
$username = "root";  // Your database username (e.g., root for XAMPP/WAMP)
$password = "";      // Your database password (leave blank for XAMPP/WAMP)
$database = "control_pest"; // Your database name

// Create Connection
$conn = new mysqli($host, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Uncomment to confirm connection during testing
// echo "Database connected successfully!";
?>
