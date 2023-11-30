<!DOCTYPE html>
<html>

<head>
    <title>Peminjaman</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            width: 80px;
        }
    </style>
</head>

<body>
    <h2>Data Peminjaman</h2>

    <?php
    include("../../../Config/koneksi.php");
    try {
        $db = new Database();

        $stmt = $db->getConnection()->prepare("SELECT * FROM PEMINJAMAN");
        $stmt->execute();
        $result = $stmt->get_result();
        $peminjamanData = $result->fetch_all(MYSQLI_ASSOC);


        if (count($peminjamanData) > 0) {
            // Tampilan Tabel
            echo "<table>";
            echo "<tr>
                    <th>ID Peminjaman</th>
                    <th>ID Member</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th class='actions'>Actions</th>
                  </tr>";

            foreach ($peminjamanData as $row) {
                echo "<tr>
                        <td>" . $row['ID_PEMINJAMAN'] . "</td>
                        <td>" . $row['ID_MEMBER'] . "</td>
                        <td>" . $row['TANGGAL_PEMINJAMAN'] . "</td>
                        <td>" . $row['TANGGAL_PENGEMBALIAN'] . "</td>
                        <td>" . $row['ATTRIBSTATUSUTE_26'] . "</td>
                        <td>" . $row['DENDA'] . "</td>
                        <td class='actions'>
                            <button onclick='editPeminjaman(" . $row['ID_PEMINJAMAN'] . ")'>Edit</button>
                            <button onclick='hapusPeminjaman(" . $row['ID_PEMINJAMAN'] . ")'>Hapus</button>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "Tidak ada data peminjaman.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>

    <script>
        function editPeminjaman(idPeminjaman) {
            window.location.href = "editPeminjaman.php?id=" + idPeminjaman;
        }

        function hapusPeminjaman(idPeminjaman) {
            if (confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')) {
                window.location.href = "deletePeminjaman.php?id=" + idPeminjaman;
            }
        }
    </script>
</body>

</html>