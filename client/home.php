<?php
session_start();  // Start the session to check if the user is logged in

// Check if the user is logged in (session exists for 'user')
if (isset($_SESSION['user'])) {
    // If the user is logged in, include the 'questions.php' page from the client folder
    include("./client/questions.php");
} else { ?>
    <!-- If the user is not logged in, display a promotional banner and a link to log in -->
    <div class="banner-container mt-5 mb-5">
        <div class="text-container">
            <h2>Have a Question?</h2>
            <p>A fast and reliable app that provides instant answers to all your questions, anytime, anywhere!</p>
            <div class="get-btn mt-2">
                <!-- Button to redirect the user to the login page -->
                <a href="index.php?page=login">Get Started</a>
            </div>
        </div>
    </div>
<?php } ?>