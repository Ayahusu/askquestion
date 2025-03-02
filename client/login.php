<?php session_start(); // Start the session to manage user login state 
?>

<div class="container-fluid mt-3 d-flex justify-content-center align-items-center" style="height: 700px;">
    <!-- Container to center the login form on the page -->
    <div class="border w-25 mt-5 p-3 rounded">
        <h1 class="mb-2">Login</h1>

        <!-- Check if there is a login error stored in session -->
        <?php if (isset($_SESSION['login_error'])) : ?>
            <div class="alert alert-danger" id="errorAlert">
                <!-- Display the login error message if it exists -->
                <?php echo $_SESSION['login_error']; ?>
            </div>
            <?php unset($_SESSION['login_error']); // Clear the login error from the session 
            ?>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="./server/login.php" method="post">
            <!-- Email input field -->
            <div>
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>

            <!-- Password input field -->
            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <!-- Submit button to log in -->
            <div>
                <button type="submit" name="login" class="btn btn-primary mt-3 w-100 fs-5">Login</button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript to hide the error message after 3 seconds
    setTimeout(function() {
        var errorAlert = document.getElementById("errorAlert");
        if (errorAlert) {
            errorAlert.style.display = "none"; // Hide the error alert
        }
    }, 3000);
</script>