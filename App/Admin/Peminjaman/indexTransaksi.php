<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Transaksi Peminjaman</title>
    <style>
        body {
            font-family: Inter, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            text-align: left;
            background-color: #fff;
            margin: 0;
            padding: 20px;
        }

        .container {
            display: flexbox;
            flex-direction: column;
            align-items: center;
            width: 80%;
            margin: 0 auto;
            border: 2px solid black;
            /* Tambahkan border untuk luaran .container */
            padding: 20px;
            /* Tambahkan padding agar border terlihat */
        }

        .table-container {
            display: flexbox;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid black;
            /* Tambahkan border untuk luaran .table-container */
            margin-bottom: 20px;
            /* Tambahkan margin-bottom agar terlihat jarak antar tabel */
        }

        .table-title {
            background-color: #36ABFF;
            font-weight: 400;
            line-height: 39px;
            color: #fff;
            margin-bottom: 20px;
            padding: 0 10px;
            /* Tambahkan padding agar teks tidak terlalu dekat dengan tepi */
        }

        .table-kembali {
            background-color: #5FBA62;
            font-weight: 400;
            line-height: 39px;
            color: #fff;
            margin-bottom: 20px;
            padding: 0 10px;
            /* Tambahkan padding agar teks tidak terlalu dekat dengan tepi */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
            color: black;
        }

        th {
            background-color: #D9D9D9;
        }

        /* Other styles for search, buttons, etc. */

        /* Example style for search box */
        .search-box {
            display: flex;
            margin-top: 10px;
            margin-bottom: -90px;
            margin-block-end: auto;
            /* margin-left: 366px; */
            border: 1px solid black;
            /* Tambahkan border untuk kotak pencarian */
            display: inline-block;
            /* Agar kotak pencarian tidak mengambil lebar penuh */
            padding: 5px;
            /* Tambahkan padding agar isi pencarian terlihat lebih rapi */
        }

        .search-box input[type="text"] {

            padding: 8px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            outline: none;
            width: 150px;
            /* Sesuaikan lebar input pencarian */
        }

        .search-box button {
            padding: 8px 16px;
            background-color: rgba(161, 159, 159, 1);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Gaya untuk tombol "Tambah Data" */
        .add-button {
            background-color: #36ABFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            /* Menggunakan borderRadius untuk membuat tombol kotak */
            width: auto;
            /* Mengatur lebar sesuai dengan konten */
            padding: 10px 20px;
            /* Padding agar tombol tidak terlalu kecil */
            font-size: 16px;
            text-align: center;
            cursor: pointer;
            float: right;
            /* Menggunakan float untuk meletakkan tombol di sebelah kanan */
            margin-top: -10px;
            /* Sesuaikan margin agar posisinya di atas tabel */
            margin-right: 20px;
            /* Beri margin untuk penempatan yang lebih baik */
        }
    </style>
</head>

<body>

    <?php
    // Include file koneksi.php untuk mendapatkan kelas Database
    include("../../../Config/koneksi.php");
    include("../menu.php");
    // Membuat instance dari kelas Database
    $db = new Database();

    // Mendapatkan koneksi
    $conn = $db->getConnection();

    // Query untuk mendapatkan data transaksi peminjaman
    $stmtPeminjaman = $conn->prepare("
        SELECT 
            PEMINJAMAN.ID_PEMINJAMAN AS 'ID Peminjaman',
            PEMINJAMAN.ID_MEMBER AS 'ID Member',
            MEMBER.NAMA_MEMBER AS 'Nama Peminjam',
            PEMINJAMAN.TANGGAL_PEMINJAMAN AS 'Tanggal Pinjam',
            PEMINJAMAN.TANGGAL_PENGEMBALIAN AS 'Tanggal Kembali',
            BUKU.JUDUL_BUKU AS 'Judul Buku',
            COUNT(DETAILPEMINJAMAN.ID_BUKU) AS 'Jumlah Buku',
            ATTRIBSTATUSUTE_26 AS 'Status'
        FROM 
            PEMINJAMAN
        LEFT JOIN 
            MEMBER ON PEMINJAMAN.ID_MEMBER = MEMBER.ID_MEMBER
        LEFT JOIN 
            DETAILPEMINJAMAN ON PEMINJAMAN.ID_PEMINJAMAN = DETAILPEMINJAMAN.ID_PEMINJAMAN
        LEFT JOIN 
            BUKU ON DETAILPEMINJAMAN.ID_BUKU = BUKU.ID_BUKU
        GROUP BY 
            PEMINJAMAN.ID_PEMINJAMAN
        ORDER BY 
            PEMINJAMAN.ID_PEMINJAMAN;
    ");
    $stmtPeminjaman->execute();
    $resultPeminjaman = $stmtPeminjaman->get_result();
    $peminjamanData = $resultPeminjaman->fetch_all(MYSQLI_ASSOC);

    // Query untuk mendapatkan data transaksi pengembalian
    $stmtPengembalian = $conn->prepare("
        SELECT 
            PEMINJAMAN.ID_PEMINJAMAN AS 'ID Pengembalian',
            PEMINJAMAN.ID_MEMBER AS 'ID Member',
            MEMBER.NAMA_MEMBER AS 'Nama Peminjam',
            PEMINJAMAN.TANGGAL_PEMINJAMAN AS 'Tanggal Pinjam',
            PEMINJAMAN.TANGGAL_PENGEMBALIAN AS 'Tanggal Kembali',
            BUKU.JUDUL_BUKU AS 'Judul Buku',
            COUNT(DETAILPEMINJAMAN.ID_BUKU) AS 'Jumlah Buku'
        FROM 
            PEMINJAMAN
        LEFT JOIN 
            MEMBER ON PEMINJAMAN.ID_MEMBER = MEMBER.ID_MEMBER
        LEFT JOIN 
            DETAILPEMINJAMAN ON PEMINJAMAN.ID_PEMINJAMAN = DETAILPEMINJAMAN.ID_PEMINJAMAN
        LEFT JOIN 
            BUKU ON DETAILPEMINJAMAN.ID_BUKU = BUKU.ID_BUKU
        WHERE 
            PEMINJAMAN.TANGGAL_PENGEMBALIAN IS NOT NULL
        GROUP BY 
            PEMINJAMAN.ID_PEMINJAMAN
    ");
    $stmtPengembalian->execute();
    $resultPengembalian = $stmtPengembalian->get_result();
    $pengembalianData = $resultPengembalian->fetch_all(MYSQLI_ASSOC);

    ?>

    <div class="table-container">
        <div class="table-title">Tabel Peminjaman</div>
        <!-- Tombol "Tambah" untuk menambahkan data -->
        <button type="button" class="add-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
            <i class="fa fa-plus"></i>+Tambah Peminjam</button>


        <!-- Search Box untuk Tabel Peminjaman -->
        <div class="search-box">
            <input type="text" id="searchPeminjaman" placeholder="Cari...">
            <button onclick="searchPeminjaman()">Cari</button>
        </div>


        <!-- Script untuk filter pada Tabel Peminjaman -->
        <script>
            function searchPeminjaman() {
                // Mendapatkan nilai inputan dari kotak pencarian
                var input = document.getElementById("searchPeminjaman");
                var filter = input.value.toUpperCase();

                // Mendapatkan baris data dari tabel peminjaman
                var table = document.getElementsByTagName("table")[0]; // Menggunakan tag table pertama di halaman
                var rows = table.getElementsByTagName("tr");

                // Melakukan iterasi pada setiap baris data
                for (var i = 0; i < rows.length; i++) {
                    var data = rows[i].getElementsByTagName("td")[2]; // Kolom indeks 2 adalah kolom Nama Peminjam
                    if (data) {
                        var txtValue = data.textContent || data.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            rows[i].style.display = "";
                        } else {
                            rows[i].style.display = "none";
                        }
                    }
                }
            }
        </script>

        <!-- Tombol "Kembali" -->
        <button onclick="clearSearchPeminjaman()">Kembali</button>

        <!-- Script untuk menghapus filter pada Tabel Peminjaman -->
        <script>
            function clearSearchPeminjaman() {
                // Menghapus nilai inputan dari kotak pencarian
                document.getElementById("searchPeminjaman").value = "";

                // Mendapatkan baris data dari tabel peminjaman
                var table = document.getElementsByTagName("table")[0]; // Menggunakan tag table pertama di halaman
                var rows = table.getElementsByTagName("tr");

                // Melakukan iterasi pada setiap baris data
                for (var i = 0; i < rows.length; i++) {
                    rows[i].style.display = ""; // Menampilkan kembali semua baris yang sebelumnya disembunyikan oleh pencarian
                }
            }
        </script>

        <!-- Table for Peminjaman CRUD -->
        <table>
            <thead>
                <tr>
                    <th>ID Peminjaman</th>
                    <th>ID Member</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Judul Buku</th>
                    <th>Jumlah Buku</th>
                    <th>status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop to display data transaksi peminjaman -->
                <?php
                if (!empty($peminjamanData)) {
                    foreach ($peminjamanData as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["ID Peminjaman"] . "</td>";
                        echo "<td>" . $row["ID Member"] . "</td>";
                        echo "<td>" . $row["Nama Peminjam"] . "</td>";
                        echo "<td>" . $row["Tanggal Pinjam"] . "</td>";
                        echo "<td>" . $row["Tanggal Kembali"] . "</td>";
                        // echo "<td>" . $row['ATTRIBSTATUSUTE_26'] . "</td>";
                        echo "<td>" . ($row["Judul Buku"] ?? 'Belum ada') . "</td>"; // Gunakan operator null coalescing untuk menampilkan pesan jika nilai NULL
                        echo "<td>" . ($row["Jumlah Buku"] ?? '0') . "</td>"; // Gunakan operator null coalescing untuk menampilkan pesan jika nilai NULL atau 0
                        echo "<td>" . $row["Status"] . "</td>";
                        echo "<td><a href='edit.php?id=" . $row['ID Peminjaman'] . "'>Edit</a> | <a href='hapus.php?id=" . $row['ID Peminjaman'] . "'>Hapus</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Tidak ada data peminjaman</td></tr>";
                }

                ?>

            </tbody>
        </table>
        <!-- Modal untuk menambahkan data peminjam -->
        <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Peminjam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="proses_tambah_peminjam.php" method="POST">
                        <div class="modal-body">
                            <!-- Form untuk menambahkan data peminjam -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Peminjam</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <!-- Tambahkan field lainnya sesuai kebutuhan -->


                            <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>




        <!-- Modal untuk mengedit data peminjaman -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Peminjam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form untuk mengedit data peminjaman -->
                        <form action="proses_edit_peminjam.php" method="POST">
                            <div class="mb-3">
                                <label for="editNama" class="form-label">Nama Peminjam</label>
                                <input type="text" class="form-control" id="editNama" name="editNama" required>
                            </div>
                            <!-- Tambahkan field lainnya sesuai kebutuhan -->

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk menghapus data peminjaman -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Hapus Peminjam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data peminjam ini?</p>
                        <!-- Form untuk menghapus data peminjaman -->
                        <form action="proses_hapus_peminjam.php" method="POST">
                            <!-- Tambahkan field tersembunyi (misalnya ID) yang dibutuhkan untuk proses penghapusan -->
                            <input type="hidden" id="deleteID" name="deleteID">

                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->


    <div class="table-container">
        <div class="table-kembali">Tabel Pengembalian</div>
        <!-- Search Box -->
        <!-- Search Box untuk Tabel Pengembalian -->
        <div class="search-box">
            <input type="text" id="searchPengembalian" placeholder="Cari...">
            <button onclick="searchPengembalian()">Cari</button>
        </div>

        <!-- Script untuk filter pada Tabel Pengembalian -->
        <script>
            function searchPengembalian() {
                // Mendapatkan nilai inputan dari kotak pencarian
                var input = document.getElementById("searchPengembalian");
                var filter = input.value.toUpperCase();

                // Mendapatkan baris data dari tabel pengembalian
                var table = document.getElementsByTagName("table")[1]; // Menggunakan tag table kedua di halaman (indeks 1)
                var rows = table.getElementsByTagName("tr");

                // Melakukan iterasi pada setiap baris data
                for (var i = 0; i < rows.length; i++) {
                    var data = rows[i].getElementsByTagName("td")[2]; // Kolom indeks 2 adalah kolom Nama Peminjam
                    if (data) {
                        var txtValue = data.textContent || data.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            rows[i].style.display = "";
                        } else {
                            rows[i].style.display = "none";
                        }
                    }
                }
            }
        </script>

        <!-- Tombol "Kembali" untuk tabel Pengembalian -->
        <button onclick="clearSearchPengembalian()">Kembali</button>

        <!-- Script untuk menghapus filter pada Tabel Pengembalian -->
        <script>
            function clearSearchPengembalian() {
                // Menghapus nilai inputan dari kotak pencarian
                document.getElementById("searchPengembalian").value = "";

                // Mendapatkan baris data dari tabel pengembalian
                var table = document.getElementsByTagName("table")[1]; // Menggunakan tag table kedua di halaman (indeks 1)
                var rows = table.getElementsByTagName("tr");

                // Melakukan iterasi pada setiap baris data
                for (var i = 0; i < rows.length; i++) {
                    rows[i].style.display = ""; // Menampilkan kembali semua baris yang sebelumnya disembunyikan oleh pencarian
                }
            }
        </script>
        <table>
            <thead>
                <tr>
                    <th>ID Pengembalian</th>
                    <th>ID Member</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Judul Buku</th>
                    <th>Jumlah Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop to display data transaksi pengembalian -->
                <?php
                if (!empty($pengembalianData)) {
                    foreach ($pengembalianData as $row) {
                        echo "<tr>";
                        echo "<td>" . $row["ID Pengembalian"] . "</td>";
                        echo "<td>" . $row["ID Member"] . "</td>";
                        echo "<td>" . $row["Nama Peminjam"] . "</td>";
                        echo "<td>" . $row["Tanggal Pinjam"] . "</td>";
                        echo "<td>" . $row["Tanggal Kembali"] . "</td>";
                        echo "<td>" . ($row["Judul Buku"] ?? 'Belum ada') . "</td>"; // Gunakan operator null coalescing untuk menampilkan pesan jika nilai NULL
                        echo "<td>" . ($row["Jumlah Buku"] ?? '0') . "</td>"; // Gunakan operator null coalescing untuk menampilkan pesan jika nilai NULL atau 0
                        echo "<td> <a href='hapus.php?id=" . $row['ID Pengembalian'] . "'>Hapus</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Tidak ada data pengembalian</td></tr>";
                }
                ?>

            </tbody>
        </table>
        <!-- Pagination or additional controls if needed -->


        <!-- Modal untuk menghapus data pengembalian -->
        <div class="modal fade" id="deletePengembalianModal" tabindex="-1" aria-labelledby="deletePengembalianModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePengembalianModalLabel">Hapus Pengembalian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data pengembalian ini?</p>
                        <!-- Form untuk menghapus data pengembalian -->
                        <form action="proses_hapus_pengembalian.php" method="POST">
                            <!-- Tambahkan field tersembunyi (misalnya ID) yang dibutuhkan untuk proses penghapusan -->
                            <input type="hidden" id="deletePengembalianID" name="deletePengembalianID">

                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <?php
        // Menutup koneksi database
        $conn->close();
        ?>

</body>

</html>