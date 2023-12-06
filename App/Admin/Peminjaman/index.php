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
            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

            <!-- Bootstrap JS -->
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

            <?php
            include 'Functions/pesan_kilat.php';
            $db = new Database();
            $conn = $db->getConnection();
            require 'Functions/Peminjaman.php';

            $peminjaman = new peminjaman($conn);
            $add = $peminjaman->addPeminjamanFromForm();
            $edit = $peminjaman->editPeminjamanFromForm();



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
            P.ID_PEMINJAMAN AS 'ID Peminjaman',
            P.ID_MEMBER AS 'ID Member',
            M.NAMA_MEMBER AS 'Nama Peminjam',
            P.TANGGAL_PEMINJAMAN AS 'Tanggal Pinjam',
            P.TANGGAL_PENGEMBALIAN AS 'Tanggal Kembali',
            DP.ID_BUKU AS 'ID Buku',
            DP.STATUS_PEMINJAMAN AS 'Status Peminjaman',
            DP.STATUS_BUKU AS 'Status Buku'
        FROM 
            PEMINJAMAN P
        INNER JOIN 
            DETAILPEMINJAMAN DP ON P.ID_PEMINJAMAN = DP.ID_PEMINJAMAN
        LEFT JOIN 
            MEMBER M ON P.ID_MEMBER = M.ID_MEMBER;
        
        
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
                            if(!empty($peminjamanData)) {
                                foreach($peminjamanData as $row) {
                                    echo "<tr>";
                                    echo "<td>".$row["ID Peminjaman"]."</td>";
                                    echo "<td>".$row["ID Member"]."</td>";
                                    echo "<td>".$row["Nama Peminjam"]."</td>";
                                    echo "<td>".$row["Tanggal Pinjam"]."</td>";
                                    echo "<td>".$row["Tanggal Kembali"]."</td>";
                                    echo "<td>".($row["Judul Buku"] ?? 'Belum ada')."</td>"; // Gunakan operator null coalescing untuk menampilkan pesan jika nilai NULL
                                    echo "<td>".($row["Jumlah Buku"] ?? '0')."</td>"; // Gunakan operator null coalescing untuk menampilkan pesan jika nilai NULL atau 0
                                    echo "<td>".$row["Status"]."</td>";
                                    echo "<td>";
                                    ?>
                                    <!-- Tombol Edit dan Hapus dalam bentuk button -->

                                    <button type="button" class="btn btn-warning btn-xs"
                                        onclick="location.href='Peminjaman.php?id=<?= $row['ID Peminjaman'] ?>'">
                                        <i class="fa fa-pencil-square-o"></i> Edit
                                    </button>


                                    <button type="button" class="btn btn-danger btn-xs"
                                        onclick="deleteConfirmation(<?= $row['ID Peminjaman'] ?>)"><i
                                            class="fa fa-trash"></i>Hapus</button>
                                    <?php
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>Tidak ada data peminjaman</td></tr>";
                            }
                            ?>


                        </tbody>
                    </table>
                    <!-- Modal untuk menambahkan data peminjam -->

                    <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static"
                        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Data Peminjaman</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form action="" method="post">

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ID Peminjam:</label>
                                            <input type="text" name="ID_MEMBER" class="form-control" method="post"
                                                id="recipient-name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ID Buku:</label>
                                            <input type="hidden" name="ID_BUKU" class="form-control" method="post"
                                                id="recipient-name">
                                        </div>

                                        <div class="mb-3">
                                            <label for="JUDUL_BUKU" class="col-form-label">Judul Buku:</label>
                                            <input type="text" name="JUDUL_BUKU" class="form-control" id="JUDUL_BUKU">
                                        </div>
                                        <div class="mb-3">
                                            <label for="JUMLAH_BUKU" class="col-form-label">Jumlah Buku:</label>
                                            <input type="number" name="JUMLAH_BUKU" class="form-control"
                                                id="JUMLAH_BUKU">
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
                                        <div class="mb-3 d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                aria-hidden="true">
                                                <i class="fa fa-times"></i> Close
                                            </button>
                                            <button type="submit" name="submit" class="btn btn-primary ms-2"
                                                aria-hidden="true">
                                                <i class="fa fa-floppy-o"></i> Simpan
                                            </button>
                                        </div>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>




                    <!-- Modal untuk mengedit data peminjaman -->
                    <div class="modal fade" id="editModal<?= $row['ID_MEMBER'] ?>" tabindex="-1"
                        aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Peminjam</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <!-- Form untuk mengedit data peminjaman -->
                                <form action="Functions/Kategori.php" method="POST">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="editNama" class="form-label">Nama Peminjam</label>
                                            <input type="text" class="form-control" id="editNama" name="NAMA_MEMBER"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="judul_buku" class="col-form-label">Judul Buku:</label>
                                            <input type="text" name="JUDUL_BUKU" class="form-control" id="judul_buku">
                                        </div>
                                        <div class="mb-3">
                                            <label for="jumlah_buku" class="col-form-label">Jumlah Buku:</label>
                                            <input type="number" name="JUMLAH_BUKU" class="form-control"
                                                id="jumlah_buku">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_peminjaman" class="col-form-label">Tanggal
                                                Peminjaman:</label>
                                            <input type="date" name="tanggal_peminjaman" class="form-control"
                                                id="tanggal_peminjaman">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_pengembalian" class="col-form-label">Tanggal
                                                Pengembalian:</label>
                                            <input type="date" name="tanggal_pengembalian" class="form-control"
                                                id="tanggal_pengembalian">
                                        </div>
                                        <!-- Tambahkan field lainnya sesuai kebutuhan -->

                                        <div class="mb-3 d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                aria-hidden="true">
                                                <i class="fa fa-times"></i> Close
                                            </button>
                                            <button type="submit" name="submit" class="btn btn-primary ms-2"
                                                aria-hidden="true">
                                                <i class="fa fa-floppy-o"></i> Simpan
                                            </button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal untuk Hapus Peminjaman -->
                <div class="modal fade" id="deleteModal<?= $row['ID_MEMBER'] ?>" tabindex="-1"
                    aria-labelledby="deleteModalLabel<?= $row['ID_MEMBER'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel<?= $row['ID_MEMBER'] ?>">Hapus Data
                                    Peminjaman</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Anda yakin ingin menghapus data peminjaman untuk ID Member
                                    <?= $row['ID_MEMBER'] ?>?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <form action="index.php?page=peminjaman" method="post">
                                    <input type="hidden" name="ID_MEMBER" value="<?= $row['ID_MEMBER'] ?>">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="deletePeminjaman" class="btn btn-danger">Hapus</button>
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
            <!-- Table for Pengembalian CRUD -->
            <table id="tablePengembalian">
                <thead>
                    <tr>
                        <th>ID Pengembalian</th> <!-- Ubah judul kolom menjadi ID Pengembalian -->
                        <th>ID Member</th>
                        <th>Nama Pengembali</th> <!-- Ubah judul kolom menjadi Nama Pengembali -->
                        <th>Tanggal Kembali</th> <!-- Ubah judul kolom menjadi Tanggal Kembali -->
                        <th>Tanggal Dikembalikan</th>
                        <th>Judul Buku</th>
                        <th>Jumlah Buku</th>
                        <th>Status</th> <!-- Ubah judul kolom menjadi Status -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop to display data transaksi detailpeminjaman -->
                    <?php
                    if(!empty($pengembalianData)) {
                        foreach($pengembalianData as $row) {
                            echo "<tr>";
                            echo "<td>".$row["ID Pengembalian"]."</td>"; // Ubah ID Peminjaman menjadi ID Pengembalian
                            echo "<td>".$row["ID Member"]."</td>";
                            echo "<td>".$row["Nama Pengembali"]."</td>"; // Ubah Nama Peminjam menjadi Nama Pengembali
                            echo "<td>".$row["Tanggal Kembali"]."</td>"; // Ubah Tanggal Pinjam menjadi Tanggal Kembali
                            echo "<td>".$row["Tanggal Dikembalikan"]."</td>"; // Tambah kolom Tanggal Dikembalikan jika diperlukan
                            echo "<td>".($row["Judul Buku"] ?? 'Belum ada')."</td>";
                            echo "<td>".($row["Jumlah Buku"] ?? '0')."</td>";
                            echo "<td>".$row["Status"]."</td>";
                            echo "<td>";
                            ?>
                            <!-- Tombol Edit dan Hapus dalam bentuk button -->
                            <button type="button" class="btn btn-warning btn-xs"
                                onclick="location.href='Pengembalian.php?id=<?= $row['ID Pengembalian'] ?>'"><i
                                    class="fa fa-pencil-square-o"></i>Edit</button>
                            <button type="button" class="btn btn-danger btn-xs"
                                onclick="deleteConfirmation(<?= $row['ID Pengembalian'] ?>)"><i
                                    class="fa fa-trash"></i>Hapus</button>
                            <?php
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>Tidak ada data pengembalian</td></tr>";
                    }
                    ?>

                </tbody>
            </table>


            </tbody>
            </table>
            <!-- Pagination or additional controls if needed -->


            <!-- Modal untuk menghapus data pengembalian -->
            <div class="modal fade" id="deletePengembalianModal" tabindex="-1"
                aria-labelledby="deletePengembalianModalLabel" aria-hidden="true">
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
                <script>
                    $(document).ready(function () {
                        $('ID Peminjaman').DataTable(); // Ganti #tablePeminjaman dengan ID tabel Peminjaman Anda
                        $('ID Pengembalian').DataTable(); // Ganti #tablePengembalian dengan ID tabel Pengembalian Anda
                    });
                </script>
            </div>


            <?php
            // Menutup koneksi database
            $conn->close();
            ?>
            </main>

        </div>
    </div>
</body>

</html>