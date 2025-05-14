CREATE TABLE users (
   user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);


ALTER TABLE users
ADD COLUMN address VARCHAR(255) NOT NULL,
ADD COLUMN phone VARCHAR(15) NOT NULL,
ADD COLUMN role ENUM('customer', 'technician') NOT NULL DEFAULT 'customer';



CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);


CREATE TABLE `bookings` (
    booking_id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    customer_name` VARCHAR(100) NOT NULL,
    contact_number` VARCHAR(15) NOT NULL,
    email` VARCHAR(100),
    service_type` VARCHAR(50) NOT NULL,
    booking_date` DATE NOT NULL,
    service_time` TIME NOT NULL,
    address` TEXT,
    status` ENUM('Pending', 'Confirmed', 'Completed') DEFAULT 'Pending',
    created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);


CREATE TABLE staff (
    staff_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    contact_number VARCHAR(15) NOT NULL,
    role VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    card_type VARCHAR(50) NOT NULL,
    card_number VARCHAR(20) NOT NULL,
    cvv VARCHAR(10) NOT NULL,
    expiry_date VARCHAR(10) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('pending', 'completed') DEFAULT 'pending',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE

);


CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    review_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

