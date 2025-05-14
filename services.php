<?php
// services.php - Services page for Sanitization and Pest Control Management

// Include header if needed
include('db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Sanitization & Pest Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            margin-left: 220px; /* Offset for sidebar */
            flex-grow: 1; /* Allows container to grow and take available space */
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        .services-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .service-box {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .service-box:hover {
            transform: scale(1.05);
        }

        .service-box h3 {
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .service-box p {
            color: #555;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .service-box .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .service-box .btn:hover {
            background-color: #45a049;
        }

        /* Modal style */
        input[type="radio"] {
            display: none;
        }

        .modal-container {
            position: relative;
            z-index: 0;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .modal-body {
            font-size: 16px;
            color: #333;
        }

        .modal-container input[type="radio"]:checked ~ .modal-overlay {
            display: block;
        }

        .modal-container input[type="radio"]:checked ~ .modal-overlay .modal-content {
            animation: fadeIn 0.5s ease-in-out;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            width: 100%;  /* Ensures footer spans full width */
            margin-top: auto; /* Ensures footer sticks to the bottom */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

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
    <h1>Our Services</h1>

    <div class="services-section">
        <!-- Service 1 -->
        <div class="service-box">
            <h3>Sanitization Services</h3>
            <p>We provide thorough sanitization services for homes, offices, and public spaces, ensuring a healthy environment.</p>
            <label class="btn" for="service1-modal">Learn More</label>
        </div>

        <!-- Service 2 -->
        <div class="service-box">
            <h3>Pest Control</h3>
            <p>Our pest control services eliminate pests like rodents, termites, and insects from your premises safely and effectively.</p>
            <label class="btn" for="service2-modal">Learn More</label>
        </div>

        <!-- Service 3 -->
        <div class="service-box">
            <h3>Disinfection Services</h3>
            <p>We offer disinfection services that target harmful bacteria and viruses, protecting your space from illness.</p>
            <label class="btn" for="service3-modal">Learn More</label>
        </div>

        <!-- Service 4 -->
        <div class="service-box">
            <h3>Customized Solutions</h3>
            <p>We offer tailored pest control and sanitization services according to your unique needs and requirements.</p>
            <label class="btn" for="service4-modal">Learn More</label>
        </div>
    </div>
</div>

<!-- Modal for Sanitization Services -->
<div class="modal-container">
    <input type="radio" id="service1-modal" name="service-modal" />
    <div class="modal-overlay">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('service1-modal').checked = false;">&times;</span>
            <div class="modal-header">Sanitization Services</div>
            <div class="modal-body">
                <p>Our sanitization services include a deep clean of all surfaces, the use of eco-friendly disinfectants, and ensuring your space is free of harmful bacteria, viruses, and germs. We use advanced technology and cleaning agents to give you peace of mind.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Pest Control -->
<div class="modal-container">
    <input type="radio" id="service2-modal" name="service-modal" />
    <div class="modal-overlay">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('service2-modal').checked = false;">&times;</span>
            <div class="modal-header">Pest Control</div>
            <div class="modal-body">
                <p>We use a combination of chemical and non-chemical methods to eradicate pests from your home or business. Our team ensures your property is protected from common pests like rodents, cockroaches, and termites using safe, reliable, and eco-friendly treatments.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Disinfection Services -->
<div class="modal-container">
    <input type="radio" id="service3-modal" name="service-modal" />
    <div class="modal-overlay">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('service3-modal').checked = false;">&times;</span>
            <div class="modal-header">Disinfection Services</div>
            <div class="modal-body">
                <p>Our disinfection services are designed to eliminate harmful pathogens such as viruses and bacteria from high-touch areas in your home or office. We focus on ensuring your environment remains safe and healthy with regular disinfection treatments.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Customized Solutions -->
<div class="modal-container">
    <input type="radio" id="service4-modal" name="service-modal" />
    <div class="modal-overlay">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('service4-modal').checked = false;">&times;</span>
            <div class="modal-header">Customized Solutions</div>
            <div class="modal-body">
                <p>We understand that each property has its unique needs, so we offer customized pest control and sanitization plans to address your specific challenges. Whether it's a large corporate office or a small apartment, we create a plan that works for you.</p>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2025 Sanitization & Pest Control Management. All Rights Reserved.</p>
</footer>

</body>
</html>
