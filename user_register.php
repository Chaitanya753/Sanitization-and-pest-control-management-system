<?php
session_start();
include 'db_connection.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address = htmlspecialchars(trim($_POST['address']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($password)) {
        $error_message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)";

        // Ensure the statement is prepared before execution
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $name, $email, $phone, $address, $hashed_password);

            if ($stmt->execute()) {
                $success_message = "Registration successful! You can now <a href='user_login.php'>login</a>.";
            } else {
                $error_message = "Error: " . $stmt->error;
            }

            // Close the statement after use
            $stmt->close();
        } else {
            $error_message = "Failed to prepare SQL statement.";
        }
    }
    // Ensure the database connection is closed
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        /* Add your CSS styles here */
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background: url('images/user_login.jpg') no-repeat center center;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            color: white;
            text-align: center;
        }
        .error {
            background-color: #f44336;
        }
        .success {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <?php if (!empty($error_message)) : ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)) : ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
</body>
</html>