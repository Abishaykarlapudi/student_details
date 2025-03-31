<?php
$server = "localhost";
$user = "root";
$pass = "";
$name = "student";
$conn = null;

try {
    $conn = mysqli_connect($server, $user, $pass, $name);
    
    // Check connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Log error instead of displaying it to users
    error_log("Database connection error: " . $e->getMessage());
    // You can set a flag here to show a user-friendly message
}

// Create tables if they don't exist
function initialize_database($conn) {
    if (!$conn) return;
    
    $details_table = "CREATE TABLE IF NOT EXISTS details (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        middle_name VARCHAR(50),
        last_name VARCHAR(50) NOT NULL,
        pnumber VARCHAR(15) NOT NULL,
        alt_number VARCHAR(15),
        email VARCHAR(100) NOT NULL,
        gender VARCHAR(10) NOT NULL,
        dob DATE,
        fname VARCHAR(100) NOT NULL,
        foccupation VARCHAR(100),
        fsalary VARCHAR(50),
        fnumber VARCHAR(15),
        mname VARCHAR(100) NOT NULL,
        moccupation VARCHAR(100),
        msalary VARCHAR(50),
        mnumber VARCHAR(15),
        door_no VARCHAR(20),
        street VARCHAR(100),
        mandal VARCHAR(100),
        district VARCHAR(100),
        state VARCHAR(100),
        pincode VARCHAR(10),
        school_name VARCHAR(200),
        school_percentage VARCHAR(10),
        college_name VARCHAR(200),
        college_percentage VARCHAR(10),
        diploma_name VARCHAR(200),
        diploma_percentage VARCHAR(10),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    mysqli_query($conn, $details_table);
}

// Initialize the database
initialize_database($conn);
?>