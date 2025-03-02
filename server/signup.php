<?php
// Start the session or resume the existing session
session_start();

// Include the database configuration file to establish a database connection
include("../config/db.php");

// Check if the signup form is submitted via POST
if (isset($_POST['signup'])) {

    // Sanitize and trim input values to remove extra spaces and special characters
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Convert special characters to HTML entities to prevent XSS attacks
    $username = htmlspecialchars($username);
    $email = htmlspecialchars($email);
    $password = htmlspecialchars($password);

    // Check if any fields are empty
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['signup_error'] = "All fields are required."; // Store error message in session
        header("Location: ../index.php?page=signup"); // Redirect to the signup page
        exit(); // Terminate further script execution
    }
    // Check if the email format is valid
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = "Invalid email format."; // Store error message in session
        header("Location: ../index.php?page=signup"); // Redirect to the signup page
        exit();
    }
    // Check if the password length is at least 6 characters
    elseif (strlen($password) < 6) {
        $_SESSION['signup_error'] = "Password must be at least 6 characters long."; // Store error message
        header("Location: ../index.php?page=signup"); // Redirect to the signup page
        exit();
    }

    // Prepare a SQL statement to check if the email is already registered
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // Bind the email parameter
    $stmt->execute(); // Execute the query
    $stmt->store_result(); // Store the result of the query

    // If email already exists in the database, show an error message
    if ($stmt->num_rows > 0) {
        $_SESSION['signup_error'] = "Email is already registered."; // Store error message
        header("Location: ../index.php?page=signup"); // Redirect to the signup page
        exit();
    }

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL statement to insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt === false) {
        // Log database error if preparation fails
        error_log("Database error: " . $conn->error);
        $_SESSION['signup_error'] = "There was a problem with the registration. Please try again later."; // Store error message
        header("Location: ../index.php?page=signup"); // Redirect to the signup page
        exit();
    }

    // Bind the parameters (username, email, hashed password) to the SQL query
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Execute the query to insert the user into the database
    if ($stmt->execute()) {
        // If insertion is successful, store user info in the session
        $_SESSION['user'] = [
            'id' => $stmt->insert_id, // Store the inserted user's ID
            'username' => $username, // Store the username
            'email' => $email // Store the email
        ];

        // Regenerate the session ID to prevent session fixation attacks
        session_regenerate_id(true);

        // Redirect to the homepage after successful registration
        header('Location: ../index.php');
        exit();
    } else {
        // Log execution error if insertion fails
        error_log("Execution error: " . $stmt->error);
        $_SESSION['signup_error'] = "There was a problem with the registration. Please try again later."; // Store error message
        header("Location: ../index.php?page=signup"); // Redirect to the signup page
        exit();
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted via POST, redirect to the signup page
    header("Location: ../index.php?page=signup");
    exit();
}
