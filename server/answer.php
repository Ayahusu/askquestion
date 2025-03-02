<?php
// Start the session to access user data
session_start();

// Include the database configuration file to establish a connection
include("../config/db.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['user']['id'])) {
    die("User not logged in.");
}

// Get the user_id from the session
$user_id = $_SESSION['user']['id'];

// Sanitize and store the answer and question_id
if (isset($_POST['answer']) && isset($_POST['question_id']) && !empty($_POST['answer'])) {
    $answer = htmlspecialchars($_POST['answer']);
    $question_id = (int)$_POST['question_id'];

    // Check if the user exists in the users table
    $userCheckQuery = "SELECT id FROM users WHERE id = ?";
    $stmt = $conn->prepare($userCheckQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    // If the user doesn't exist, show an error
    if ($stmt->num_rows === 0) {
        die("User does not exist in the database.");
    }

    // Prepare the SQL query to insert the answer into the answers table
    $query = "INSERT INTO answers (question_id, user_id, answer, created_at) 
              VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $question_id, $user_id, $answer);

    // Execute the query and check if the answer was inserted successfully
    if ($stmt->execute()) {
        // Redirect to the home page after successful submission
        header("Location: ../index.php?page=home");
        exit; // Stop further script execution
    } else {
        // If execution fails, display an error message
        die("Error submitting answer: " . $stmt->error);
    }
} else {
    // If the 'answer' or 'question_id' is not provided, display an error message
    die("Please provide an answer.");
}
