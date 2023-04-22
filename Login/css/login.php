<?php
// Start a session
session_start();

// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the login form was submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the user with the entered username
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // User was found in the database, so check the password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Password is correct, so log the user in
            $_SESSION['username'] = $username;
            header("Location: home.php");
            exit();
        } else {
            // Password is incorrect
            $error_message = "Incorrect password";
        }
    } else {
        // User was not found in the database
        $error_message = "User not found";
    }
}

mysqli_close($conn);
?>
