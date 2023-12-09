<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <title>DataTable Example</title>
    <style>
        .container-fluid {
            width: auto;
            padding: 20px;
            box-sizing: border-box;
            /* Untuk mempertahankan total lebar termasuk padding */
        }

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
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 95%;
            /* Mengatur lebar kotak paling dalam */
            margin: 0 auto;
            border: 10px;
        }


        .table-container {
            display: flexbox;
            margin-top: 20px;
            padding: 20px;
            line-break: ;
            border: 1px solid black;
            /* Tambahkan border untuk luaran .table-container */
            margin-bottom: 20px;
            /* Tambahkan margin-bottom agar terlihat jarak antar tabel */
        }

        .table-peminjaman {
            display: flex;
            background-color: #36ABFF;
            font-weight: 400;
            line-height: 39px;
            color: #fff;
            margin-bottom: 20px;
            padding: 0 10px;
            /* Tambahkan padding agar teks tidak terlalu dekat dengan tepi */
        }

        .table-kembali {
            margin-top: 15px;
            background-color: #5FBA62;
            font-weight: 400;
            line-height: 39px;
            color: #fff;
            margin-bottom: 20px;
            padding: 0 10px;
            /* Tambahkan padding agar teks tidak terlalu dekat dengan tepi */
        }

        table {

            display: flexbox;
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
            margin-bottom: 10px;
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
    <!-- Sertakan CSS DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Sertakan script jQuery -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Sertakan script DataTables -->
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

</head>

<body>



    <div class="container-fluid">
        <div class="row">

            <?php
            include 'Functions/pesan_kilat.php';
            $db = new Database();
            $conn = $db->getConnection();
            require 'Functions/Peminjaman.php';

            $peminjaman = new peminjaman($conn);
            $add = $peminjaman->addPeminjamanFromForm();
            $edit = $peminjaman->editPeminjamanFromForm();
            $hapus = $peminjaman->deletePeminjamanFromForm();



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

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="table-container">

                    <div class="table-peminjaman">Tabel Peminjaman</div>
                    <!-- Tombol "Tambah" untuk menambahkan data -->
                    <button type="button" class="add-button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-bs-whatever="@mdo">
                        <i class="fa fa-plus"></i>Tambah Peminjam</button>


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
                    <table id="tablePeminjaman">
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
                                    echo "<td>" . ($row["Judul Buku"] ?? 'Belum ada') . "</td>"; // Gunakan operator null coalescing untuk menampilkan pesan jika nilai NULL
                                    echo "<td>" . ($row["Jumlah Buku"] ?? '0') . "</td>"; // Gunakan operator null coalescing untuk menampilkan pesan jika nilai NULL atau 0
                                    echo "<td>" . $row["Status"] . "</td>";
                                    echo "<td>";

                                    ?>
                                    <!-- Tombol Edit dan Hapus dalam bentuk button -->


                                    <!-- HTML & PHP -->
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-warning btn-xs" data-bs-toggle="modal"
                                            data-bs-target="#myModal<?= $row["ID Peminjaman"]; ?>">
                                            <i class="fa fa-pencil-square-o"></i> Edit
                                        </button>
                                        <!-- Tombol Hapus -->
                                        <a href="index.php?page=peminjaman&delete_id=<?= $row['ID Peminjaman'] ?>"
                                            onclick="javascript:return confirm('Hapus Data Peminjaman?');"
                                            class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>

                                        <!-- Modal untuk Edit -->
                                        <div id="myModal<?= $row["ID Peminjaman"]; ?>" class="modal fade"
                                            data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                            aria-labelledby="myModalLabel<?= $row["ID Peminjaman"]; ?>" aria-hidden="true"
                                            tabindex="-1">
                                            <!-- Isi dari modal -->
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel<?= $row["ID Peminjaman"]; ?>">
                                                            <i class="fa fa-users"></i> Edit Data Peminjaman
                                                        </h5>
                                                        <button type="button" class="btn-close-style" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Form untuk Edit -->
                                                    <form action="" method="post">
                                                        <div class="modal-body custom-modal-body">
                                                            <div class="mb-3">
                                                                <label for="recipient-name" class="col-form-label">ID
                                                                    Peminjam:</label>
                                                                <input type="text" name="ID_MEMBER" class="form-control"
                                                                    method="post" id="recipient-name">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="recipient-name" class="col-form-label">ID
                                                                    Buku:</label>
                                                                <input type="hidden" name="ID_BUKU" class="form-control"
                                                                    method="post" id="recipient-name">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="JUDUL_BUKU" class="col-form-label">Judul
                                                                    Buku:</label>
                                                                <select name="JUDUL_BUKU" class="form-select" id="JUDUL_BUKU">
                                                                    <option value="">Pilih Judul Buku</option>
                                                                    <?php
                                                                    // Ambil data judul buku dari tabel 'buku'
                                                                    $judul_buku_query = "SELECT JUDUL_BUKU FROM BUKU";
                                                                    $judul_buku_result = mysqli_query($conn, $judul_buku_query);

                                                                    // Periksa apakah query berhasil dijalankan
                                                                    if ($judul_buku_result) {
                                                                        // Loop melalui setiap baris hasil query dan tambahkan sebagai opsi dropdown
                                                                        while ($row = mysqli_fetch_assoc($judul_buku_result)) {
                                                                            echo "<option value='" . $row['ID_BUKU'] . "'>" . $row['JUDUL_BUKU'] . "</option>";
                                                                        }
                                                                    } else {
                                                                        // Tampilkan pesan jika terjadi kesalahan saat mengambil data
                                                                        echo "Gagal mengambil data judul buku: " . mysqli_error($conn);
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>


                                                            <div class="mb-3">
                                                                <label for="JUMLAH_BUKU" class="col-form-label">Jumlah
                                                                    Buku:</label>
                                                                <input type="number" name="JUMLAH_BUKU" class="form-control"
                                                                    id="JUMLAH_BUKU">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="TANGGAL_PEMINJAMAN" class="col-form-label">Tanggal
                                                                    Peminjaman:</label>
                                                                <input type="date" name="TANGGAL_PEMINJAMAN"
                                                                    class="form-control" id="TANGGAL_PEMINJAMAN">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="TANGGAL_PENGEMBALIAN" class="col-form-label">Tanggal
                                                                    Pengembalian:</label>
                                                                <input type="date" name="TANGGAL_PENGEMBALIAN"
                                                                    class="form-control" id="TANGGAL_PENGEMBALIAN">
                                                            </div>
                                                            <!-- Input tersembunyi untuk ID member -->
                                                            <input type="hidden" name="ID_MEMBER"
                                                                value="<?= $row['ID Member'] ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="reset" class="btn btn-primary"
                                                                onclick="resetData()">Reset</button>
                                                            <button type="submit" name="update" class="btn btn-success">Save
                                                                Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>




                                        </div>
                                    <?php } ?>
                            </tbody>



                            <?php
                            echo "</td>";
                            echo "</tr>";
                            }
                            ?>


                        </tbody>
                    </table>
                </div>

                <!-- Modal untuk menambahkan data peminjaman -->

                <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel<?= $row["ID Peminjaman"]; ?>">
                                    <i class="fa fa-users"></i> Tambah Data Peminjaman
                                </h5>
                                <button type="button" class="btn-close-style" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <form action="index.php?page=peminjaman" method="post">
                                <div class="modal-body custom-modal-body">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">ID Peminjam:</label>
                                        <input type="text" name="ID_MEMBER" class="form-control" method="post"
                                            id="recipient-name">
                                    </div>
                                    <div class="mb-3">

                                        <input type="hidden" name="ID_BUKU" class="form-control" method="post"
                                            id="recipient-name" value="id_buku_valid">
                                    </div>
                                    <div class="mb-3">
                                        <label for="JUDUL_BUKU" class="col-form-label">Judul Buku:</label>
                                        <select name="JUDUL_BUKU" class="form-select" id="JUDUL_BUKU">
                                            <option value="">Pilih Judul Buku</option>
                                            <?php
                                            // Ambil data judul buku dari tabel 'buku'
                                            $judul_buku_query = "SELECT JUDUL_BUKU FROM BUKU";
                                            $judul_buku_result = mysqli_query($conn, $judul_buku_query);

                                            // Periksa apakah query berhasil dijalankan
                                            if ($judul_buku_result) {
                                                // Loop melalui setiap baris hasil query dan tambahkan sebagai opsi dropdown
                                                while ($row = mysqli_fetch_assoc($judul_buku_result)) {
                                                    echo "<option value='" . $row['ID_BUKU'] . "'>" . $row['JUDUL_BUKU'] . "</option>";
                                                }
                                            } else {
                                                // Tampilkan pesan jika terjadi kesalahan saat mengambil data
                                                echo "Gagal mengambil data judul buku: " . mysqli_error($conn);
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="JUMLAH_BUKU" class="col-form-label">Jumlah Buku:</label>
                                        <input type="number" name="JUMLAH_BUKU" class="form-control" id="JUMLAH_BUKU">
                                    </div>
                                    <div class="mb-3">
                                        <label for="TANGGAL_PEMINJAMAN" class="col-form-label">Tanggal
                                            Peminjaman:</label>
                                        <input type="date" name="TANGGAL_PEMINJAMAN" class="form-control"
                                            id="TANGGAL_PEMINJAMAN">
                                    </div>
                                    <div class="mb-3">
                                        <label for="TANGGAL_PENGEMBALIAN" class="col-form-label">Tanggal
                                            Pengembalian:</label>
                                        <input type="date" name="TANGGAL_PENGEMBALIAN" class="form-control"
                                            id="TANGGAL_PENGEMBALIAN">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-primary" onclick="resetData()">Reset</button>
                                    <button type="submit" name="submit" class="btn btn-success ms-2"
                                        aria-hidden="true"><i class="fa fa-floppy-o"></i> Submit</button>
                                </div>
                            </form>
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
                                    echo "<td>";
                                    ?>
                                    <!-- Tombol Hapus dalam bentuk button -->
                                    <button type="button" class="btn btn-danger btn-xs"
                                        onclick="deleteConfirmation(<?= $row['ID Pengembalian'] ?>)"><i
                                            class="fa fa-trash"></i>Hapus</button>
                                    <?php
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>Tidak ada data pengembalian</td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>

                    <?php
                    // Menutup koneksi database
                    $conn->close();
                    ?>
            </main>

        </div>
    </div>
</body>

</html>