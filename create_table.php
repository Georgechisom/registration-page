<?php

$servername = "127.0.0.1";
$username = "innocxnu_IZI";
$password = "U!CFjPw0QeJg";
$dbname = "innocxnu_IZIREG";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die(`Connection failed: ` . $conn->connect_error);
    }

    // SQL query to create table
    $sql = "CREATE TABLE registrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL,
        expertise ENUM('transition', 'beginner', 'intermediate', 'expert') NOT NULL,
        country VARCHAR(100) NOT NULL,
        state VARCHAR(50) NOT NULL,
        school VARCHAR(100) NOT NULL,
        volunteer ENUM('yes', 'no') NOT NULL,
        role VARCHAR(20) NOT NULL,
        ticket_id VARCHAR(100) NOT NULL,
        verify_token VARCHAR(50) NULL,
        verify_timestamp TIMESTAMP NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "Table 'registrations' created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Close connection
    if (isset($conn)) {
        $conn->close();
    }
}
