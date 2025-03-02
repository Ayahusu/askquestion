<?php

// Start the session or resume the existing session
session_start();

// Include the database configuration file to establish a connection
include("../config/db.php");

// Check if the 'id' parameter is provided in the URL
if (isset($_GET['id'])) {
    // Get the question ID from the URL
    $questionId = $_GET['id'];

    // Prepare a SQL query to fetch the question title and description by ID
    $query = "SELECT title, description FROM questions WHERE id = ?";
    $stmt = $conn->prepare($query); // Prepare the query
    $stmt->bind_param('i', $questionId); // Bind the question ID as an integer parameter
    $stmt->execute(); // Execute the query
    $result = $stmt->get_result(); // Get the result of the query

    // Check if a question with the given ID exists in the database
    if ($result->num_rows > 0) {
        // Fetch the question details (title and description) from the result
        $row = $result->fetch_assoc();
        $title = htmlspecialchars($row['title']); // Sanitize the title to prevent XSS
        $description = htmlspecialchars($row['description']); // Sanitize the description to prevent XSS
?>

        <!-- Display a form to edit the question -->
        <form method="POST" action="./update.php">
            <!-- Hidden field to store the question ID for updating -->
            <input type="hidden" name="question_id" value="<?php echo $questionId; ?>">

            <!-- Input field for the title -->
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br>

            <!-- Textarea field for the description -->
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"><?php echo $description; ?></textarea><br>

            <!-- Submit button to submit the form -->
            <input type="submit" value="Update">
        </form>

<?php
    } else {
        // If no question is found with the given ID, display an error message
        echo "Question not found.";
    }
} else {
    // If the 'id' parameter is not provided, display an error message
    echo "Question ID not provided.";
}
?>