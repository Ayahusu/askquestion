<?php
session_start(); // Start the session to manage user state

// Check if the user is logged in by verifying if 'user' exists in the session
$isLoggedIn = isset($_SESSION['user']);
?>
<div class="container mt-3">
    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <!-- Logo Section -->
            <div class="navbar-brand">
                <img src="./public/logo.png" style="width: 200px; height: auto;" alt="Logo"> <!-- Logo image -->
            </div>

            <!-- Navigation Links -->
            <div class="navbar-nav">

                <!-- Link to Home page -->
                <a class="nav-link fs-4 me-4 page-link" href="index.php?page=home">Home</a>

                <!-- Link to About Us page -->
                <a class="nav-link fs-4 me-4 page-link" href="index.php?page=aboutus">About Us</a>

                <!-- Conditional display based on login status -->
                <?php if ($isLoggedIn): ?>
                    <!-- Show 'Ask a Question' and 'Logout' links if the user is logged in -->
                    <a class="nav-link fs-4 me-4 page-link" href="index.php?page=ask">Ask a Question</a>
                    <a class="nav-link fs-4 me-4 page-link" href="index.php?action=logout" onclick="return confirmLogout();">Logout</a>
                <?php else: ?>
                    <!-- Show 'Login' and 'Signup' links if the user is not logged in -->
                    <a class="nav-link fs-4 me-4 page-link" href="index.php?page=login">Login</a>
                    <a class="nav-link fs-4 me-4 page-link" href="index.php?page=signup">Signup</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>

<!-- JavaScript for confirming logout action -->
<script>
    function confirmLogout() {
        return confirm("Are you sure you want to log out?");
    }
</script>