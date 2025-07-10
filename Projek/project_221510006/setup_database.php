<?php
// Database setup script
// Run this once to set up your database properly

include 'config.php';

echo "<h2>Database Setup</h2>";

// Drop existing tables if they exist
$conn->query("DROP TABLE IF EXISTS shoes");
$conn->query("DROP TABLE IF EXISTS users");

echo "<p>✓ Dropped existing tables</p>";

// Create users table
$create_users = "CREATE TABLE users (
    id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(50) NOT NULL,
    password_hash varchar(255) NOT NULL,
    role enum('admin','viewer') NOT NULL DEFAULT 'viewer',
    PRIMARY KEY (id),
    UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if ($conn->query($create_users)) {
    echo "<p>✓ Created users table</p>";
} else {
    echo "<p>✗ Error creating users table: " . $conn->error . "</p>";
}

// Create shoes table
$create_shoes = "CREATE TABLE shoes (
    id int(11) NOT NULL AUTO_INCREMENT,
    brand varchar(100) NOT NULL,
    model varchar(100) DEFAULT NULL,
    color varchar(50) DEFAULT NULL,
    size varchar(20) DEFAULT NULL,
    price decimal(10,2) DEFAULT NULL,
    image_filename varchar(255) DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if ($conn->query($create_shoes)) {
    echo "<p>✓ Created shoes table</p>";
} else {
    echo "<p>✗ Error creating shoes table: " . $conn->error . "</p>";
}

// Create shoe_sizes table for size/stock variety
$create_shoe_sizes = "CREATE TABLE IF NOT EXISTS shoe_sizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shoe_id INT NOT NULL,
    size VARCHAR(10) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    FOREIGN KEY (shoe_id) REFERENCES shoes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if ($conn->query($create_shoe_sizes)) {
    echo "<p>✓ Created shoe_sizes table</p>";
} else {
    echo "<p>✗ Error creating shoe_sizes table: " . $conn->error . "</p>";
}

// Insert sample users
$admin_password = password_hash('admin123', PASSWORD_DEFAULT);
$viewer_password = password_hash('viewer123', PASSWORD_DEFAULT);

$insert_users = "INSERT INTO users (username, password_hash, role) VALUES 
('admin', '$admin_password', 'admin'),
('viewer', '$viewer_password', 'viewer')";

if ($conn->query($insert_users)) {
    echo "<p>✓ Created sample users</p>";
    echo "<p><strong>Admin login:</strong> username: admin, password: admin123</p>";
    echo "<p><strong>Viewer login:</strong> username: viewer, password: viewer123</p>";
} else {
    echo "<p>✗ Error creating users: " . $conn->error . "</p>";
}

// Insert sample shoes
$insert_shoes = "INSERT INTO shoes (brand, model, color, size, price, image_filename) VALUES 
('Nike', 'Air Max', 'Black', '42', 1500000.00, 'nike_airmax.jpg'),
('Adidas', 'Ultraboost', 'White', '41', 2000000.00, 'adidas_ultraboost.jpg'),
('Jordan', 'Air Jordan 1', 'Red', '43', 2500000.00, 'jordan_aj1.jpg')";

if ($conn->query($insert_shoes)) {
    echo "<p>✓ Created sample shoes</p>";
} else {
    echo "<p>✗ Error creating shoes: " . $conn->error . "</p>";
}

// Create images directory if it doesn't exist
if (!file_exists('images')) {
    mkdir('images', 0777, true);
    echo "<p>✓ Created images directory</p>";
} else {
    echo "<p>✓ Images directory already exists</p>";
}

echo "<h3>Setup Complete!</h3>";
echo "<p><a href='login.php'>Go to Login Page</a></p>";
?> 