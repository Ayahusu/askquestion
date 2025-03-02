<?php
session_start(); // Start a session to manage user state

// Check if the user is logged in by verifying the session variable 'user'
$isLoggedIn = isset($_SESSION['user']);
?>
<div class="container">
    <!-- Footer Section -->
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <!-- Copyright Information -->
        <p class="col-md-4 mb-0 text-muted">&copy; 2022 AskQuestion</p>

        <!-- Bootstrap Logo (SVG) -->
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap" />
        </svg>

        <!-- Navigation Menu -->
        <ul class="nav col-md-4 justify-content-end">
            <!-- Link to Home page -->
            <li class="nav-item"><a href="index.php?page=home" class="nav-link px-2 text-muted">Home</a></li>

            <!-- Link to About Us page -->
            <li class="nav-item"><a href="index.php?page=aboutus" class="nav-link px-2 text-muted">About</a></li>

            <!-- Conditional display of links based on whether the user is logged in -->
            <?php if ($isLoggedIn): ?>
                <!-- Show 'Ask a Question' link if the user is logged in -->
                <li class="nav-item"><a href="index.php?page=ask" class="nav-link px-2 text-muted">Ask a Question</a></li>
            <?php else: ?>
                <!-- Show 'Login' and 'Signup' links if the user is not logged in -->
                <li class="nav-item"><a href="index.php?page=login" class="nav-link px-2 text-muted">Login</a></li>
                <li class="nav-item"><a href="index.php?page=signup" class="nav-link px-2 text-muted">Signup</a></li>
            <?php endif; ?>
        </ul>
    </footer>
</div>