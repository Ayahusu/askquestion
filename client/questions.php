<?php
session_start(); // Start the session to access session variables like user data
include("./config/db.php"); // Include the database connection file

// If the form is submitted with the 'edit_question' button, update the question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_question'])) {
    $questionId = $_POST['question_id']; // Get the question ID from the form
    $title = $_POST['title']; // Get the updated title from the form
    $description = $_POST['description']; // Get the updated description from the form

    // Prepare and execute the SQL query to update the question's title and description
    $updateQuery = "UPDATE questions SET title = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ssi', $title, $description, $questionId);
    $stmt->execute();
}
?>

<h1 class="heading mt-5 mb-3">Questions</h1>
<div class="container mt-2">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        // Fetch all questions with the username of the user who asked the question
        $query = "SELECT q.id, q.title, q.description, q.user_id, q.created_at, u.username 
                  FROM questions q 
                  JOIN users u ON q.user_id = u.id"; // Join with the users table to get the username
        $result = $conn->query($query);

        // Loop through each question and display its details
        foreach ($result as $row) {
            $id = $row['id'];
            $title = $row['title'];
            $description = $row['description'];
            $user_id = $row['user_id'];
            $created_at = date("F j, Y", strtotime($row['created_at'])); // Format creation date
            $username = htmlspecialchars($row['username']); // Get the username of the user who asked the question
        ?>
            <div class="col-12 col-md-4">
                <span>Question By: <?php echo ucfirst($username); ?></span><br> <!-- Display the username who asked the question -->
                <span>Asked on: <?php echo $created_at ?></span> <!-- Display the question's creation date -->
                <div class="card">
                    <div class="card-header" id="cardHeader-<?php echo $id; ?>">
                        <span id="cardTitle-<?php echo $id; ?>"><?php echo htmlspecialchars($title); ?></span> <!-- Display the title of the question -->
                    </div>
                    <div class="card-body">
                        <p class="card-text" id="cardDescription-<?php echo $id; ?>"><?php echo htmlspecialchars($description); ?></p> <!-- Display the description of the question -->

                        <div id="cardContent-<?php echo $id; ?>">
                            <div id="editButtons-<?php echo $id; ?>">
                                <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $user_id) { ?>
                                    <!-- If the logged-in user is the same as the user who asked the question, show edit and delete buttons -->
                                    <button class="btn btn-primary w-25" onclick="toggleEditForm(<?php echo $id; ?>)">Edit</button>
                                    <a href="./server/delete.php?id=<?php echo $id; ?>" class="btn btn-danger w-25" onclick="return confirm('Are you sure you want to delete this question?');">Delete</a>
                                <?php } ?>
                            </div>

                            <!-- Form to submit an answer -->
                            <form method="POST" action="./server/answer.php">
                                <div class="form-group mt-3">
                                    <label for="answer<?php echo $id; ?>">Your Answer</label>
                                    <textarea class="form-control" name="answer" id="answer<?php echo $id; ?>" required></textarea>
                                    <input type="hidden" name="question_id" value="<?php echo $id; ?>" />
                                </div>
                                <button type="submit" class="w-100 mt-3 btn btn-success mt-2">Submit Answer</button>
                            </form>

                            <!-- Button to toggle the display of answers -->
                            <div class="mt-3 fs-4">
                                <p class="text-center">Answers</p>
                                <button class="w-100 btn btn-success" onclick="toggleAnswer('<?php echo $id; ?>')">Show Answer</button>
                            </div>

                            <!-- Display answers if available -->
                            <div class="mt-3 form-group" id="answer-<?php echo $id; ?>" style="display: none; margin-top: 10px;">
                                <?php
                                // Query to fetch answers for the current question
                                $answerQuery = "SELECT a.answer, a.user_id, a.created_at, u.username 
                                                FROM answers a 
                                                JOIN users u ON a.user_id = u.id 
                                                WHERE a.question_id = ?";
                                $stmt = $conn->prepare($answerQuery);
                                $stmt->bind_param('i', $id);
                                $stmt->execute();
                                $answerResult = $stmt->get_result();

                                if ($answerResult->num_rows > 0) {
                                    // Loop through and display each answer
                                    while ($answerRow = $answerResult->fetch_assoc()) {
                                        $answerText = htmlspecialchars($answerRow['answer']);
                                        $answerDate = date("F j, Y", strtotime($answerRow['created_at']));
                                        $username = htmlspecialchars($answerRow['username']);
                                ?>
                                        <div class="answer mt-2 p-3 border rounded">
                                            <p><strong>Answer by <?php echo ucfirst($username); ?>:</strong></p>
                                            <p><?php echo $answerText; ?></p>
                                            <small>Answered on: <?php echo $answerDate; ?></small>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '<p class="mt-2 p-3 border rounded text-muted">No answer yet.</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Edit form (hidden by default) to modify the question's title and description -->
                        <form method="POST" class="mt-3" id="editForm-<?php echo $id; ?>" style="display: none;">
                            <input type="hidden" name="question_id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label for="editTitle-<?php echo $id; ?>">Title</label>
                                <input type="text" name="title" id="editTitle-<?php echo $id; ?>" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editDescription-<?php echo $id; ?>">Description</label>
                                <textarea name="description" id="editDescription-<?php echo $id; ?>" class="form-control" required><?php echo htmlspecialchars($description); ?></textarea>
                            </div>
                            <button type="submit" name="edit_question" class="btn btn-success mt-2">Save Changes</button>
                            <button type="button" class="btn btn-secondary mt-2" onclick="toggleEditForm(<?php echo $id; ?>)">Cancel</button>
                        </form>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    // Function to toggle the edit form visibility
    function toggleEditForm(questionId) {
        var editForm = document.getElementById("editForm-" + questionId);
        var cardContent = document.getElementById("cardContent-" + questionId);
        var cardHeader = document.getElementById("cardHeader-" + questionId);
        var cardDescription = document.getElementById("cardDescription-" + questionId);

        if (editForm.style.display === "none") {
            // If the form is hidden, show it and hide the question details
            editForm.style.display = "block";
            cardContent.style.display = "none";
            cardHeader.style.display = "none";
            cardDescription.style.display = "none";
            document.getElementById("editTitle-" + questionId).value = document.getElementById("cardTitle-" + questionId).textContent;
            document.getElementById("editDescription-" + questionId).value = document.getElementById("cardDescription-" + questionId).textContent;
        } else {
            // Otherwise, hide the form and show the question details
            editForm.style.display = "none";
            cardContent.style.display = "block";
            cardHeader.style.display = "block";
            cardDescription.style.display = "block";
        }
    }

    // Function to toggle the visibility of the answers section
    function toggleAnswer(questionId) {
        var answerSection = document.getElementById("answer-" + questionId);

        if (answerSection.style.display === "none" || answerSection.style.display === "") {
            // If the answers are hidden, show them
            answerSection.style.display = "block";
        } else {
            // Otherwise, hide the answers
            answerSection.style.display = "none";
        }
    }
</script>