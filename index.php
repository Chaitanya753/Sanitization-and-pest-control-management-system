<?php
// Start session if needed
session_start();
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanitization and Pest Control Management System</title>
    <style>
        /* Basic Reset */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/background_sms.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        /* Overlay effect for better readability */
        .overlay {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }

        /* Header Section */
        header {
            background-color: rgba(76, 175, 80, 0.9);
            color: white;
            text-align: center;
            padding: 20px 0;
            border-radius: 10px;
        }

        /* Navigation Section */
        nav {
            background-color: rgba(51, 51, 51, 0.9);
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            position: relative;
        }

        nav ul li {
            margin: 0 15px;
            position: relative;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        nav ul li a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        nav ul li .dropdown {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 150px;
            top: 100%;
            left: 0;
            border-radius: 5px;
            z-index: 1;
        }

        nav ul li:hover .dropdown {
            display: block;
        }

        nav ul li .dropdown a {
            padding: 10px 15px;
            text-decoration: none;
            display: block;
        }

        nav ul li .dropdown a:hover {
            background-color: #575757;
        }

        /* Main Content */
        .container {
            max-width: 1100px;
            margin: auto;
            padding: 20px;
        }

        main .intro {
            text-align: center;
            padding: 50px 20px;
        }

        main .intro .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        main .services {
            text-align: center;
            padding: 50px 20px;
        }

        .contact {
            padding: 50px 20px;
            background: rgba(255, 255, 255, 0.9);
            text-align: center;
        }

        .contact h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .contact p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .contact-info {
            font-size: 18px;
            line-height: 1.6;
        }

        .services-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 300px;
            text-align: center;
            flex: 1;
        }

        /* Footer Section */
        footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(51, 51, 51, 0.9);
            color: white;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <h1>Sanitization and Pest Control Management</h1>
            <p>Your one-stop solution for sanitization and pest control needs.</p>
        </div>
    </header>

    <!-- Navigation Section -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li>
                <a href="#">Login</a>
                <div class="dropdown">
                    <a href="admin_login.php">Admin Login</a>
                    <a href="user_login.php">User Login</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Main Content Section -->
    <main>
        <section class="intro">
            <div class="container overlay">
                <h2>Welcome to Our Platform</h2>
                <p>
                    We offer professional sanitization and pest control services for both residential 
                    and commercial needs. Book your service online and ensure a safe and clean environment.
                </p>
            </div>
        </section>

        <section id="services" class="services">
            <div class="container">
                <h2>Our Services</h2>
                <div class="services-container">
                    <div class="service-card">
                        <h3>Home Sanitization</h3>
                        <p>Deep cleaning and sanitization for a germ-free home.</p>
                    </div>
                    <div class="service-card">
                        <h3>Pest Control</h3>
                        <p>Effective pest control solutions to protect your space.</p>
                    </div>
                    <div class="service-card">
                        <h3>Commercial Services</h3>
                        <p>Custom sanitization and pest control for businesses.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <section id="contact" class="contact">
        <h2>Contact Us</h2>
        <p>If you have any questions or need assistance, feel free to reach out to us.</p>
        <div class="contact-info">
            <p>Email: contact@sanitization.com</p>
            <p>Phone: +123 456 7890</p>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <p>&copy; 2025 Sanitization and Pest Control Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
