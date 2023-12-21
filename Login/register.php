<?php
include("../Config/koneksi.php");
$db = new Database();
$conn = $db->getConnection();

$idmember = $_POST['ID_MEMBER'] ?? '';
$username = $_POST['USERNAME_MEMBER'] ?? '';
$password = $_POST['PASSWORD_MEMBER'] ?? '';
$hashed_password = md5($password);
$fullName = $_POST['NAMA_MEMBER'] ?? '';
$identityType = $_POST['JENIS_IDENTITAS'] ?? '';
$identityNumber = $_POST['NOMOR_IDENTITAS'] ?? '';
$address = $_POST['ALAMAT'] ?? '';
$level = $_POST['LEVEL'] ?? '';

// Memeriksa apakah ID_MEMBER sudah ada sebelumnya
$check_query = "SELECT * FROM MEMBER WHERE ID_MEMBER = ?";
$stmt_check = $conn->prepare($check_query);
$stmt_check->bind_param('s', $idmember);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo "ID_MEMBER sudah digunakan. Gunakan ID_MEMBER yang berbeda.";
} else {
    $sql = "INSERT INTO MEMBER (ID_MEMBER, USERNAME_MEMBER, PASSWORD_MEMBER, NAMA_MEMBER, JENIS_IDENTITAS, NOMOR_IDENTITAS, ALAMAT,LEVEL) 
            VALUES (?, ?, ?, ?, ?, ?, ?,?)";

    // Persiapkan pernyataan SQL
    $stmt = $conn->prepare($sql);

    // Bind parameters dengan tipe data yang sesuai
    $stmt->bind_param('ssssssss', $idmember, $username, $hashed_password, $fullName, $identityType, $identityNumber, $address, $level);

    // Eksekusi pernyataan INSERT
    if ($stmt->execute()) {
        echo "Registrasi berhasil!";
        header("Location: ../App/Katalog/index.php");
        exit();
    } else {
        echo "Registrasi gagal. Silakan coba lagi.";
        // Jika ingin menampilkan pesan kesalahan detail:
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$stmt_check->close();
$conn->close();
?>