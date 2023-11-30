<?php
include("../../../Config/koneksi.php");
$db = new Database();
$conn = $db->getConnection();

// Memproses edit kategori jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];

    $sql = "UPDATE KATEGORI SET NAMA_KATEGORI = '$nama_kategori' WHERE ID_KATEGORI = $id_kategori";

    if ($conn->query($sql) === TRUE) {
        header("Location: indexKategori.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Memproses penghapusan kategori jika diberikan parameter ID
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $id_kategori = $_GET['id'];
    $sql = "DELETE FROM KATEGORI WHERE ID_KATEGORI = $id_kategori";

    if ($conn->query($sql) === TRUE) {
        header("Location: indexKategori.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manajemen Kategori</title>
    <!-- Tambahkan CSS di sini jika diperlukan -->
</head>

<body>
    <h2>Daftar Kategori</h2>
    <table border="1">
        <tr>
            <th>ID Kategori</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php
        $sql = "SELECT * FROM KATEGORI";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID_KATEGORI"] . "</td>";
                echo "<td>" . $row["NAMA_KATEGORI"] . "</td>";
                echo "<td><a href='indexKategori.php?action=edit&id=" . $row["ID_KATEGORI"] . "'>Edit</a> | <a href='indexKategori.php?action=hapus&id=" . $row["ID_KATEGORI"] . "'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
        }
        ?>
    </table>

    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        $id_kategori = $_GET['id'];
        $sql = "SELECT * FROM KATEGORI WHERE ID_KATEGORI = $id_kategori";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Tampilkan form untuk mengedit data kategori
            echo "<h2>Edit Kategori</h2>";
            echo "<form action='indexKategori.php' method='POST'>";
            echo "<input type='hidden' name='id_kategori' value='" . $row["ID_KATEGORI"] . "'>";
            echo "<input type='text' name='nama_kategori' value='" . $row["NAMA_KATEGORI"] . "' required><br><br>";
            echo "<input type='submit' value='Simpan Perubahan'>";
            echo "</form>";
        } else {
            echo "Data kategori tidak ditemukan.";
        }
    }
    ?>

    <a href="indexKategori.php">Kembali ke Daftar Kategori</a>
</body>

</html>

<?php
$conn->close();
?>