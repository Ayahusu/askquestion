<?php session_start(); ?>

<!-- Container for the signup form -->
<div class="container-fluid mt-3 d-flex justify-content-center align-items-center" style="height: 700px;">
    <div class="container border w-25 mt-5 p-3 rounded">
        <!-- Signup form heading -->
        <h1 class="mb-2">Signup</h1>

        <!-- Check if there is a signup error in the session -->
        <?php if (isset($_SESSION['signup_error'])) : ?>
            <!-- Display error message if available -->
            <div class="alert alert-danger" id="errorAlert">
                <?php echo $_SESSION['signup_error']; ?>
            </div>
            <!-- Unset the error session variable after displaying the message -->
            <?php unset($_SESSION['signup_error']); ?>
        <?php endif; ?>

        <!-- Signup form -->
        <form action="./server/signup.php" method="post">
            <!-- Username input field -->
            <div class="margin_bottom_15">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>

            <!-- Email input field -->
            <div class="margin_bottom_15">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>

            <!-- Password input field -->
            <div class="margin_bottom_15">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <!-- Submit button for the form -->
            <div class="margin_bottom_15">
                <button type="submit" name="signup" class="btn btn-primary mt-3 w-100 fs-5">Signup</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript to hide the error alert after 3 seconds -->
<script>
    setTimeout(function() {
        var errorAlert = document.getElementById("errorAlert");

        if (errorAlert) {
            errorAlert.style.display = "none"; // Hide the error alert
        }
    }, 3000);
</script>