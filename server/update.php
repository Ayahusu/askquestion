<?php

// Start the session or resume the existing session
session_start();

// Include the database configuration file to establish a database connection
include("../config/db.php");

// Check if the request method is POST and the 'question_id' is set in the POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_id'])) {

    // Get the values of 'question_id', 'title', and 'description' from the POST request
    $questionId = $_POST['question_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Prepare an SQL query to update the title and description of the question with the given ID
    $updateQuery = "UPDATE questions SET title = ?, description = ? WHERE id = ?";

    // Prepare the query with the database connection
    $stmt = $conn->prepare($updateQuery);

    // Bind the parameters to the prepared statement ('ssi' represents string, string, integer)
    $stmt->bind_param('ssi', $title, $description, $questionId);

    // Execute the prepared statement
    $stmt->execute();

    // After successful update, redirect the user to the home page
    header("Location: ../index.php?page=home");

    // Terminate further script execution
    exit();
} else {
    // If the request is invalid, output an error message
    echo "Invalid request.";
}
