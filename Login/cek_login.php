<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["loginUsername"];
    $password = $_POST["loginPassword"];

    // Include your database connection file or establish a connection here
    include_once("../Config/koneksi.php"); // Adjust the path accordingly
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the connection is successful
    if ($conn) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT ID_MEMBER, PASSWORD_MEMBER, level FROM MEMBER WHERE USERNAME_MEMBER = ?");
        $stmt->bind_param("s", $username);

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userID, $hashedPassword, $userLevel);
            $stmt->fetch();

            // Verify the password using md5()
            if (md5($password) === $hashedPassword) {
                // Password is correct
                // Store user ID and level in session variables
                $_SESSION["userID"] = $userID;
                $_SESSION["userLevel"] = $userLevel;

                $stmt->close();

                // Redirect based on user level
                if ($userLevel === 'Admin') {
                    header("Location: ../index.php");
                    exit();
                } elseif ($userLevel === 'Member') {
                    header("Location: ../App/member/index.php");
                    exit();
                }
            } else {
                // Incorrect password
                header("Location: ../App/Katalog/katalog.php?error=incorrect_password");
                exit();
            }
        } else {
            // Invalid username
            header("Location: ../App/Katalog/katalog.php?error=invalid_username");
            exit();
        }
    } else {
        // Database connection failed
        header("Location: ../App/Katalog/katalog.php?error=db_connection_failed");
        exit();
    }
} else {
    // Redirect to login page if accessed directly
    header("Location: ../App/Katalog/katalog.php");
    exit();
}