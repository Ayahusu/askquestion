<?php
// Start the session or resume the existing session
session_start();

// Include the database configuration file to establish a connection
include('../config/db.php');

// Check if the user is logged in, otherwise redirect to ask page with an error message
if (!isset($_SESSION['user']['id'])) {
    $_SESSION['ask_error'] = 'You must be logged in to ask a question.';
    header('Location: ../index.php?page=ask'); // Redirect to ask page
    exit(); // Stop further script execution
}

// Check if the form has been submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ask'])) {

    // Get and trim the title and description inputs from the form
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $user_id = $_SESSION['user']['id']; // Get the logged-in user's ID

    // Check if any of the fields are empty
    if (empty($title) || empty($description)) {
        $_SESSION['ask_error'] = 'Please fill in all fields.'; // Set error message
        header('Location: ../index.php?page=ask'); // Redirect to ask page
        exit(); // Stop further script execution
    }

    // Check if the database connection is successful
    if (!$conn) {
        $_SESSION['ask_error'] = "Database Connection Error: " . mysqli_connect_error(); // Set connection error message
        header('Location: ../index.php?page=ask'); // Redirect to ask page
        exit(); // Stop further script execution
    }

    // Prepare the SQL query to insert the question into the database
    $query = "INSERT INTO questions (user_id, title, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query); // Prepare the query

    // Check if the query preparation is successful
    if (!$stmt) {
        $_SESSION['ask_error'] = "Database Error: " . $conn->error; // Set error message for preparation failure
        header('Location: ../index.php?page=ask'); // Redirect to ask page
        exit(); // Stop further script execution
    }

    // Bind the parameters to the prepared statement (user_id as integer, title and description as strings)
    $stmt->bind_param("iss", $user_id, $title, $description);

    // Execute the query to insert the question into the database
    if ($stmt->execute()) {
        // If successful, set a success message and redirect to ask page
        $_SESSION['ask_success'] = 'Your question has been submitted successfully!';
        header('Location: ../index.php?page=ask'); // Redirect to ask page
        exit(); // Stop further script execution
    } else {
        // If execution fails, set an error message and redirect to ask page
        $_SESSION['ask_error'] = "Execution Error: " . $stmt->error; // Set error message for execution failure
        header('Location: ../index.php?page=ask'); // Redirect to ask page
        exit(); // Stop further script execution
    }
}
