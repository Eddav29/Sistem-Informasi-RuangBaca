<?php
include("../Config/koneksi.php");
$db = new Database();
$conn = $db->getConnection();

// Retrieve user input (you can use filter_input to sanitize input)
$idmember = $_POST['ID_MEMBER'] ?? '';
$username = $_POST['USERNAME_MEMBER'] ?? '';
$password = $_POST['PASSWORD_MEMBER'] ?? '';
$hashed_password = md5($password);
$fullName = $_POST['NAMA_MEMBER'] ?? '';
$identityType = $_POST['JENIS_IDENTITAS'] ?? '';
$identityNumber = $_POST['NOMOR_IDENTITAS'] ?? '';
$address = $_POST['ALAMAT'] ?? '';
$level = $_POST['LEVEL'] ?? '';

// Generate the numeric part of ID_MEMBER (assumed to be the last 3 digits)
$new_numeric_part = mt_rand(1, 999);
$new_id_member = 'MBR' . sprintf('%03d', $new_numeric_part);

// Ensure the total length does not exceed 10 characters
if (strlen($new_id_member) > 10) {
    die("Error: Generated ID_MEMBER exceeds the maximum length.");
}

// Check if ID_MEMBER already exists
$check_query = "SELECT * FROM MEMBER WHERE ID_MEMBER = ?";
$stmt_check = $conn->prepare($check_query);
$stmt_check->bind_param('s', $idmember);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo "ID_MEMBER sudah digunakan. Gunakan ID_MEMBER yang berbeda.";
} else {
    $sql = "INSERT INTO MEMBER (ID_MEMBER, USERNAME_MEMBER, PASSWORD_MEMBER, NAMA_MEMBER, JENIS_IDENTITAS, NOMOR_IDENTITAS, ALAMAT, LEVEL) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters with appropriate data types
    $stmt->bind_param('ssssssss', $new_id_member, $username, $hashed_password, $fullName, $identityType, $identityNumber, $address, $level);

    // Execute the INSERT statement
    if ($stmt->execute()) {
        echo "Registrasi berhasil!";
        header("Location: ../App/Katalog/index.php");
        exit();
    } else {
        echo "Registrasi gagal. Silakan coba lagi.";
        // If you want to display detailed error messages:
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$stmt_check->close();
$conn->close();
