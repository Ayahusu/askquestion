<?php
// Start the session or resume the existing session
session_start();

// Unset all session variables to clear the session data
session_unset();

// Destroy the session completely
session_destroy();

// Delete the user_id cookie by setting its expiration time to one hour ago
setcookie("user_id", "", time() - 3600, "/");

// Set headers to prevent caching of the page to ensure the user is logged out and the page is not cached
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // Prevent caching
header("Pragma: no-cache"); // For HTTP/1.0 compatibility
header("Expires: 0"); // Set the expiration to past time

// Redirect the user to the homepage after logout
header("Location: ../index.php?page=home");

// Ensure no further code is executed after the redirection
exit();
