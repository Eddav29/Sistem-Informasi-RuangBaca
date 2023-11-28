<?php
include("../../config/koneksi.php");

class Authentication
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($username, $password)
    {
        $username = mysqli_real_escape_string($this->conn, $username);
        $password = mysqli_real_escape_string($this->conn, $password);

        $query = "SELECT * FROM MEMBER WHERE USERNAME_MEMBER = '$username' AND PASSWORD_MEMBER = '$password'";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            return $user;
        } else {
            return false;
        }
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Create an instance of the Database class
    $db = new Database();
    $conn = $db->getConnection();

    // Create an instance of the Authentication class
    $authentication = new Authentication($conn);

    // Attempt to login
    $user = $authentication->login($username, $password);

    if ($user) {
        session_start();
        $_SESSION["user_id"] = $user["ID_MEMBER"];
        $_SESSION["username"] = $user["USERNAME_MEMBER"];
        $_SESSION["level"] = $user["level"];

        // Redirect based on user level
        if ($_SESSION["level"] == "Admin") {
            header("Location: admin_dashboard.php");
            exit();
        } elseif ($_SESSION["level"] == "Member") {
            header("Location: member_dashboard.php");
            exit();
        }
    } else {
        echo "<script>alert('Invalid username or password. Please try again.');</script>";
        header("Location : ../App/Katalog/index.php");
    }

    // Close the database connection
    mysqli_close($conn);
}
