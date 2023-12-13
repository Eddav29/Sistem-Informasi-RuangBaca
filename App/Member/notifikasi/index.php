<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION["userID"]) || !isset($_SESSION["userLevel"])) {
    header("Location: App/Katalog/index.php");
    exit();
}

// Retrieve ID_MEMBER from the session
$userID = $_SESSION["userID"];
$userLevel = $_SESSION["userLevel"];

// Include your database connection file or establish a connection here
$database = new Database();
$conn = $database->getConnection();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database for borrowing history
$query = "SELECT p.*, b.JUDUL_BUKU FROM peminjaman p
          JOIN DETAILPEMINJAMAN dp ON p.ID_PEMINJAMAN = dp.ID_PEMINJAMAN
          JOIN BUKU b ON dp.ID_BUKU = b.ID_BUKU
          WHERE p.ID_MEMBER = ?";

$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $userID);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Display notifications for approaching deadlines or overdue books
    while ($row = mysqli_fetch_assoc($result)) {
        $returnDate = strtotime($row['TANGGAL_PENGEMBALIAN']);
        $borrowDate = strtotime($row['TANGGAL_PEMINJAMAN']);
        $currentDate = time();
        $daysRemaining = floor(($returnDate - $currentDate) / (60 * 60 * 24));

        // Automatically reduce days if the current date is after the borrowing date
        if ($currentDate > $borrowDate) {
            $daysRemaining = $daysRemaining - floor(($currentDate - $borrowDate) / (60 * 60 * 24));
        }

        // Display alerts based on the days remaining
        if ($daysRemaining >= 0) {
            $alertType = 'info';
            $alertMessage = "Batas waktu pengembalian buku <strong>{$row['JUDUL_BUKU']}</strong> tinggal {$daysRemaining} hari.";
        } else {
            $alertType = 'danger';
            $alertMessage = "Batas waktu pengembalian buku <strong>{$row['JUDUL_BUKU']}</strong> telah berakhir.";
        }
        ?>
        <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
            <strong>Perhatian!</strong> <?= $alertMessage ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }
} else {
    echo "Error in the query: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>