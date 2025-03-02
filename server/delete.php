<?php
// Start the session or resume the existing session
session_start();

// Include the database configuration file to establish a connection
include("../config/db.php");

// Check if the request method is GET (used for requesting resources)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Check if the user is logged in and the 'id' parameter is present in the URL
    if (isset($_SESSION['user']['id']) && isset($_GET['id'])) {

        // Retrieve the user ID from the session and the question ID from the URL
        $user_id = $_SESSION['user']['id'];
        $question_id = $_GET['id'];

        // Prepare a SQL query to fetch the user ID who posted the question
        $query = "SELECT user_id FROM questions WHERE id = ?";
        $stmt = $conn->prepare($query); // Prepare the query
        $stmt->bind_param('i', $question_id); // Bind the question ID as an integer parameter
        $stmt->execute(); // Execute the query
        $result = $stmt->get_result(); // Get the result of the query

        // Check if the question exists in the database
        if ($result->num_rows > 0) {

            // Fetch the user ID who posted the question
            $row = $result->fetch_assoc();

            // Check if the logged-in user is the one who posted the question
            if ($row['user_id'] == $user_id) {

                // Prepare and execute the SQL query to delete answers related to the question
                $deleteAnswersQuery = "DELETE FROM answers WHERE question_id = ?";
                $deleteAnswersStmt = $conn->prepare($deleteAnswersQuery);
                $deleteAnswersStmt->bind_param('i', $question_id); // Bind the question ID as an integer
                $deleteAnswersStmt->execute(); // Execute the delete query for answers

                // Prepare and execute the SQL query to delete the question
                $deleteQuestionQuery = "DELETE FROM questions WHERE id = ?";
                $deleteQuestionStmt = $conn->prepare($deleteQuestionQuery);
                $deleteQuestionStmt->bind_param('i', $question_id); // Bind the question ID as an integer
                $deleteQuestionStmt->execute(); // Execute the delete query for the question

                // Check if the question was successfully deleted
                if ($deleteQuestionStmt->affected_rows > 0) {
                    // Redirect to the home page after successful deletion
                    header("Location: ../index.php?page=home");
                    exit(); // Stop further script execution
                } else {
                    // If an error occurred while deleting the question
                    echo "Error deleting question.";
                }
            } else {
                // If the logged-in user is not the one who posted the question
                echo "You do not have permission to delete this question.";
            }
        } else {
            // If the question is not found in the database
            echo "Question not found.";
        }
    } else {
        // If the user is not logged in or the 'id' parameter is missing
        echo "Invalid request.";
    }
} else {
    // If the request method is not GET, display an error
    echo "Invalid request method.";
}
