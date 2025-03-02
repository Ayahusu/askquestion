<?php
// Start a new session or resume the existing one
session_start();

// Check if the user is logged in by verifying if 'user_id' exists in the session
$isLoggedIn = isset($_SESSION['user_id']);

// If 'logout' action is requested via GET, clear the session and redirect to the homepage
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    unset($_SESSION['user_id']); // Unset the user session
    session_destroy(); // Destroy the session
    header('Location: index.php'); // Redirect to the homepage
    exit(); // Ensure no further code is executed
}

// If the form is submitted with the 'login' action, handle the login attempt
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {

    // Get the username and password from the submitted form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded check for username and password (for testing purposes)
    if ($username == 'admin' && $password == 'password') {
        // If credentials are correct, set session variables
        $_SESSION['user_id'] = 1; // Set user ID in session
        $_SESSION['user'] = $username; // Set username in session
        header('Location: index.php'); // Redirect to homepage
        exit(); // Ensure no further code is executed
    } else {
        // If credentials are incorrect, display an error message
        $error = 'Invalid username or password';
    }
}

// Function to load the requested page content based on the 'page' parameter
function loadPage($page)
{
    switch ($page) {
        case 'home':
            include('client/home.php'); // Load the home page
            break;
        case 'login':
            include('client/login.php'); // Load the login page
            break;
        case 'signup':
            include('client/signup.php'); // Load the signup page
            break;
        case 'aboutus':
            include('client/aboutus.php'); // Load the about us page
            break;
        case 'ask':
            include('client/ask.php'); // Load the ask page
            break;
        default:
            // If the requested page doesn't match, show a 404 error message
            echo '<h2>404 Page Not Found</h2>';
            break;
    }
}

// Get the page parameter from the URL, default to 'home' if not provided
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AskQuestion</title>
    <!-- Include common files for the page (like stylesheets, scripts, etc.) -->
    <?php include('./includes/commonFile.php') ?>
</head>

<body>

    <!-- Include the navigation bar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Main content container -->
    <div class="container" id="content-container">
        <?php
        // Call the loadPage function to display the appropriate page content
        loadPage($page);
        ?>
    </div>

    <!-- If there's an error (invalid login attempt), display the error message -->
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <!-- Include the footer -->
    <?php include('./includes/footer.php') ?>
</body>

</html>