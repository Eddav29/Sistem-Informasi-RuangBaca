<?php
include("../../config/database.php"); // Adjust the path accordingly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the credentials (You should use secure password hashing and validation)
    $query = "SELECT * FROM MEMBER WHERE USERNAME_MEMBER = '$username' AND PASSWORD_MEMBER = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Login successful, fetch the user data
        $user = mysqli_fetch_assoc($result);

        // Start the session and store user data
        session_start();
        $_SESSION["user_id"] = $user["ID_MEMBER"];
        $_SESSION["username"] = $user["USERNAME_MEMBER"];
        $_SESSION["level"] = $user["level"];

        // Redirect based on user level
        if ($_SESSION["level"] == "Admin") {
            header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
            exit();
        } elseif ($_SESSION["level"] == "Member") {
            header("Location: member_dashboard.php"); // Redirect to the member dashboard
            exit();
        }
    } else {
        // Invalid login credentials
        echo "<script>alert('Invalid username or password. Please try again.');</script>";
    }

    mysqli_close($conn);
}
