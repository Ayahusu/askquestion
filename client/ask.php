<?php session_start(); ?>

<!-- Container for the "Ask a Question" form with a border and rounded corners -->
<div class="border w-50 p-3 mt-5 rounded" id="questionContainer">
    <h1 class="mb-2">Ask a Question</h1>

    <!-- Display error message if an error exists in the session -->
    <?php if (isset($_SESSION['ask_error'])) : ?>
        <div class="alert alert-danger" id="errorAlert">
            <?php echo $_SESSION['ask_error']; ?>
        </div>
        <?php unset($_SESSION['ask_error']); ?> <!-- Clear the error after displaying it -->
    <?php endif; ?>

    <!-- Display success message if a success exists in the session -->
    <?php if (isset($_SESSION['ask_success'])) : ?>
        <div class="alert alert-success" id="successAlert">
            <?php echo $_SESSION['ask_success']; ?>
        </div>
        <?php unset($_SESSION['ask_success']); ?> <!-- Clear the success message after displaying it -->
    <?php endif; ?>

    <!-- Form to ask a question -->
    <form action="./server/ask.php" method="post">
        <!-- Title input field -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="title" required>
        </div>

        <!-- Description input field (textarea) for the question -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" placeholder="Write your question here..." id="description" rows="16" required></textarea>
        </div>

        <!-- Submit button to ask the question -->
        <div class="mb-3" id="submitContainer">
            <button type="submit" name="ask" class="btn btn-primary w-100">Ask Question</button>
        </div>
    </form>
</div>

<!-- Script to hide the error and success alerts after 3 seconds -->
<script>
    setTimeout(function() {
        var errorAlert = document.getElementById("errorAlert");
        var successAlert = document.getElementById("successAlert");

        // Hide the error alert if it exists
        if (errorAlert) {
            errorAlert.style.display = "none";
        }
        // Hide the success alert if it exists
        if (successAlert) {
            successAlert.style.display = "none";
        }
    }, 3000); // 3000 milliseconds (3 seconds) delay before hiding
</script>