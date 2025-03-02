<?php
// Start the session or resume the existing session
session_start();

// Include the database configuration file to establish a connection
include("../config/db.php");

// Check if the login form is submitted via POST
if (isset($_POST['login'])) {

    // Sanitize and trim the input values for email and password
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Convert special characters to HTML entities to prevent XSS attacks
    $email = htmlspecialchars($email);
    $password = htmlspecialchars($password);

    // Check if email or password is empty
    if (empty($email) || empty($password)) {
        // Set an error message in session and redirect to the login page
        $error_message = "Email and password are required.";
        $_SESSION['login_error'] = $error_message;
        header("Location: ../index.php?page=login");
        exit(); // Stop further script execution
    } else {
        // Prepare a SQL statement to select the user details based on the entered email
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email); // Bind the email parameter to the query
        $stmt->execute(); // Execute the query
        $stmt->store_result(); // Store the result of the query

        // Check if a user with the given email exists
        if ($stmt->num_rows == 1) {
            // Bind the result to variables
            $stmt->bind_result($user_id, $username, $hashed_password);
            $stmt->fetch(); // Fetch the result

            // Verify the entered password against the hashed password in the database
            if (password_verify($password, $hashed_password)) {
                // If password is correct, store user details in the session
                $_SESSION['user'] = [
                    'id' => $user_id, // Store user ID
                    'username' => $username, // Store username
                    'email' => $email // Store email
                ];

                // Regenerate session ID for security
                session_regenerate_id(true);

                // Set a cookie for the user ID to keep the user logged in for 30 days
                setcookie('user_id', $user_id, time() + (30 * 24 * 60 * 60), '/', '', true, true); // Secure, HTTP-only cookie

                // Redirect to the homepage after successful login
                header("Location: ../index.php");
                exit(); // Stop further script execution
            } else {
                // If password is incorrect, set an error message and redirect to the login page
                $error_message = "Incorrect password.";
                $_SESSION['login_error'] = $error_message;
                header("Location: ../index.php?page=login");
                exit();
            }
        } else {
            // If email is not found in the database, set an error message and redirect to the login page
            $error_message = "Email not found.";
            $_SESSION['login_error'] = $error_message;
            header("Location: ../index.php?page=login");
            exit();
        }
        // Close the prepared statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted via POST, redirect to the login page
    header("Location: ../index.php?page=login");
    exit();
}
