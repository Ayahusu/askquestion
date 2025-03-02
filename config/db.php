<?php
// Database configuration settings
$host = "localhost";        // Hostname (usually localhost for local development)
$username = "root";         // Username for the database (default for local MySQL is 'root')
$password = "";             // Password for the database (empty by default in local setup)
$dbname = "askquestion";        // Name of the database to connect to

// Create a new connection to the MySQL database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    // If the connection fails, output an error message and stop the script
    die("Connection Failed....... " . $conn->connect_error);
}
