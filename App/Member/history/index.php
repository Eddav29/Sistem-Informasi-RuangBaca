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
include_once("Config/koneksi.php"); // Adjust the path accordingly
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

    // Display the borrowing history
    $no = 1;
    ?>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">HISTORY</h1>
                </div>
                <div class="row">
                    <div class="col-lg-2"></div>

                    <?php
                    if (isset($_SESSION['_flashdata'])) {
                        echo "<br>";
                        foreach ($_SESSION['_flashdata'] as $key => $val) {
                            echo get_flashdata($key);
                        }
                    }
                    ?>

                    <div class="table-responsive small">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">JUDUL BUKU</th>
                                    <th scope="col">TGL PEMINJAMAN</th>
                                    <th scope="col">TGL PENGEMBALIAN</th>
                                    <th scope="col">DENDA</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $no++ ?></th>
                                        <td><?= isset($row['JUDUL_BUKU']) ? $row['JUDUL_BUKU'] : 'N/A' ?></td>
                                        <td><?= isset($row['TANGGAL_PEMINJAMAN']) ? date('Y-m-d', strtotime($row['TANGGAL_PEMINJAMAN'])) : 'N/A' ?></td>
                                        <td><?= isset($row['TANGGAL_PENGEMBALIAN']) ? date('Y-m-d', strtotime($row['TANGGAL_PENGEMBALIAN'])) : 'N/A' ?></td>
                                        <td><?= isset($row['DENDA']) ? $row['DENDA'] : 'N/A' ?></td>
                                        <td>
                                            <a href="edit.php?id=<?= $row['ID_PEMINJAMAN'] ?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i>Edit</a>
                                            <a href="delete.php?id=<?= $row['ID_PEMINJAMAN'] ?>" onclick="javascript:return confirm('Hapus Data Buku?');" class="btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i>Hapus</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php
} else {
    echo "Error in the query: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>