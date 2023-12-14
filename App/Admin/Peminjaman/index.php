<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <title>DataTable Example</title>
    <style>
        .item {
    margin: 10px 0;
        }
        /* Styling for mobile */
@media (max-width: 768px) {
  .container {
    flex-direction: column;
  }
}
       .table-title {
    font-size: 24px;
    font-weight: bold;
    text-align: left;
    color: #333;
    text-transform: uppercase;
    margin-bottom: 10px;
    border-bottom: 2px solid #333;
    padding-bottom: 5px;
}

        .container-fluid {
            width: auto;
            padding: 20px;
            box-sizing: border-box;
            margin: 0 auto;
            /* Menengahkan kotak luar dengan nilai auto untuk sisi kiri dan kanan */
            text-align: center;
            /* Untuk memastikan konten di dalamnya berada di tengah secara horizontal */
        }

        .container-fluid {
            width: auto;
            padding: 20px;
            box-sizing: border-box;
            margin: 0 auto;
            /* Menengahkan kotak luar dengan nilai auto untuk sisi kiri dan kanan */
            text-align: center;
            /* Untuk memastikan konten di dalamnya berada di tengah secara horizontal */
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

        /* .container {
            
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    margin: 0 auto;
    border: 10px;
} */


        .table-container {
            width: 200%;

  margin: 0 auto;

  justify-content: space-between;

            margin-top: 20px;
            padding: 20px;
            line-break: ;
            padding: 200px;
            border: 1px solid black;
            /* Tambahkan border untuk luaran .table-container */
            margin-bottom: 20px;
            /* Tambahkan margin-bottom agar terlihat jarak antar tabel */
        }

        .table-peminjaman {

            margin-top: 15px;
            /* display: flex; */
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
            width: 80%;
            /* Mengatur lebar tabel menjadi 80% dari lebar parent atau container */

            display: flexbox;

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
            margin-bottom: 20px;
            /* Sesuaikan margin agar posisinya di atas tabel */
            /* margin-right: 20px; */
            /* Beri margin untuk penempatan yang lebih baik */
        }

        .space-above-button {
            margin-top: 10px;
            /* Sesuaikan nilai margin-top sesuai kebutuhan Anda */
        }
        /* Mengatur tata letak baris dan posisi teks serta nilai di dalam modal */
.modal-body .form-group {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

/* Memberikan lebar yang sesuai untuk elemen teks */
.modal-body .form-group .col-form-label {
    flex: 0 0 40%;
    text-align: left;
    padding-right: 10px;
}

/* Mengatur lebar nilai agar berada di sisi kanan */
.modal-body .form-group .form-control,
.modal-body .form-group .form-select {
    flex: 0 0 55%;
}

    </style>
    <!-- Sertakan CSS DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- Sertakan script jQuery -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Sertakan script DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>

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
            //$peminjaman = new DetailPeminjaman($conn);
            $add = $peminjaman->addPeminjamanFromForm();
            $edit = $peminjaman->editPeminjamanFromForm();
            $hapus = $peminjaman->deletePeminjamanFromForm();
            $editKembali = $peminjaman->editPengembalianFromForm();



            // Query untuk mendapatkan data transaksi peminjaman
            $stmtPeminjaman = $conn->prepare("
            SELECT
            PEMINJAMAN.ID_PEMINJAMAN AS 'ID Peminjaman',
            PEMINJAMAN.ID_MEMBER AS 'ID Member',
           
            BUKU.ID_BUKU,
            MEMBER.NAMA_MEMBER AS 'Nama Peminjam',
            PEMINJAMAN.TANGGAL_PEMINJAMAN AS 'Tanggal Pinjam',
            PEMINJAMAN.TANGGAL_PENGEMBALIAN AS 'Tanggal Kembali',
            BUKU.JUDUL_BUKU AS 'Judul Buku',
            COUNT(DETAILPEMINJAMAN.ID_BUKU) AS 'Jumlah Buku',
            ATTRIBSTATUSUTE_26 AS 'Status',
            PEMINJAMAN.DENDA AS 'Denda'
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
            SELECT ID_PEMINJAMAN, ID_BUKU, STATUS_PEMINJAMAN, STATUS_BUKU
            FROM DETAILPEMINJAMAN
        
            GROUP BY ID_PEMINJAMAN;
            
        ");

            $stmtPengembalian->execute();
            $resultPengembalian = $stmtPengembalian->get_result();
            $pengembalianData = $resultPengembalian->fetch_all(MYSQLI_ASSOC);

            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="table-container">
                    
                <h2 class="table-title">Tabel Transaksi</h2>
                    <div class="table-peminjaman">Tabel Peminjaman</div>
                    <!-- Tombol "Tambah" untuk menambahkan data -->

                    <button type="button" class="add-button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-bs-whatever="@mdo">
                        <i class="fa fa-plus"></i>Tambah Peminjam</button>

                    <!-- Table for Peminjaman CRUD -->
                    <table id="tablePeminjaman">
                        <table class="table table-striped table-data">
                            <div class="table-responsive small">
                                <thead>
                                    <tr>
                                        <th>ID Peminjaman</th>
                                        <th>ID Member</th>
                                        <th>Nama Peminjam</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <!-- <th>Judul Buku</th> -->
                                        <th>status Peminjaman</th>
                                        <th>Denda</th>
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
                                            // echo "<td>" . ($row["Judul Buku"] ?? 'Belum ada') . "</td>"; // Gunakan operator null coalescing untuk menampilkan pesan jika nilai NULL                                    
                                            echo "<td>" . $row["Status"] . "</td>";
                                            echo "<td>" . $row["Denda"] . "</td>";

                                            echo "<td>";

                                            ?>
                                            <!-- Tombol Edit dan Hapus dalam bentuk button -->


                                            <!-- HTML & PHP -->
                                            <div class="d-flex">

                                                <a href='index.php?page=edit&id=<?= $row["ID Peminjaman"]; ?>'
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#myModal<?= $row['ID Peminjaman']; ?>"
                                                    class="btn btn-warning btn-xs m-1"><i
                                                        class="fa fa-pencil-square-o"></i>Edit</a>

                                                <!-- Tombol Hapus -->
                                                <a href="index.php?page=peminjaman&delete_id=<?= $row['ID Peminjaman'] ?>"
                                                    onclick="javascript:return confirm('Hapus Data Peminjaman?');"
                                                    class="btn btn-danger btn-xs m-1">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                                <!-- Modal untuk Edit -->
                                                <div id="myModal<?= $row["ID Peminjaman"]; ?>" class="modal fade"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                                    aria-labelledby="myModalLabel<?= $row["ID Peminjaman"]; ?>"
                                                    aria-hidden="true" tabindex="-1">
                                                    <!-- Isi dari modal -->
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="myModalLabel<?= $row["ID Peminjaman"]; ?>">
                                                                    <i class="fa fa-users"></i> Edit Data Peminjaman
                                                                </h5>
                                                                <button type="button" class="btn-close-style"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>



                                                            <!-- Form untuk Edit -->
                                                            <div style="height: 400px; overflow-y: auto;">
                                                                <form action="" method="post">
                                                                    <div class="modal-body custom-modal-body">
                                                                        <div class="mb-3 row form-group">
                                                                            <input type="hidden" name="ID_PEMINJAMAN"
                                                                                class="form-control" id="ID_PEMINJAMAN"
                                                                                value="<?= $row['ID Peminjaman'] ?>">
                                                                        </div>
                                                                        <div class="mb-3 row form-group">
                                                                            <label for="ID_MEMBER" class="col-form-label">ID
                                                                                Member:</label>
                                                                            <input type="text" name="ID_MEMBER"
                                                                                class="form-control" id="ID_MEMBER"
                                                                                value="<?= isset($row['ID Member']) ? $row['ID Member'] : '' ?>">
                                                                        </div>
                                                                        <div class="mb-3 row form-group">
                                                                            <input type="hidden" name="ID_BUKU"
                                                                                class="form-control" method="post" id="ID_BUKU">
                                                                        </div>
                                                                        <div class="mb-3 row form-group">
                                                                            <label for="ID_BUKU_TAMBAH1"
                                                                                class="col-form-label">Pilih Buku:</label>
                                                                            <select name="ID_BUKU_TAMBAH1[]" class="form-select"
                                                                                id="ID_BUKU_TAMBAH1" multiple>
                                                                                <?php
                                                                                // Query untuk mengambil data buku dari tabel 'BUKU'
                                                                                $queryBuku = "SELECT ID_BUKU, JUDUL_BUKU FROM BUKU";
                                                                                $resultBuku = mysqli_query($conn, $queryBuku);

                                                                                // Periksa apakah query berhasil dijalankan
                                                                                if ($resultBuku) {
                                                                                    // Loop melalui setiap baris hasil query dan tampilkan sebagai option dalam select
                                                                                    while ($rowBuku = mysqli_fetch_assoc($resultBuku)) {
                                                                                        echo '<option value="' . $rowBuku['ID_BUKU'] . '">' . $rowBuku['JUDUL_BUKU'] . '</option>';
                                                                                    }
                                                                                } else {
                                                                                    // Tampilkan pesan jika terjadi kesalahan saat mengambil data
                                                                                    echo "Gagal mengambil data buku: " . mysqli_error($conn);
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <div class="mb-3 row form-group">
                                                                                <div class="space-above-button">
                                                                                    <input type="button" value="Tambahkan"
                                                                                        onclick="addSelectedBooksTambah1()">
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row form-group">
                                                                                <label for="selectedBooksTambah1"
                                                                                    class="col-form-label">Buku yang
                                                                                    Dipilih:</label>
                                                                                <select name="selectedBooksTambah1[]"
                                                                                    id="selectedBooksTambah1"
                                                                                    class="form-select" multiple></select>
                                                                            </div>
                                                                            <script>
                                                                                function addSelectedBooksTambah1() {
                                                                                    var select = document.getElementById1(
                                                                                        "ID_BUKU_TAMBAH1");
                                                                                    var selectedItems = [];
                                                                                    var selectedBooks = document.getElementById1(
                                                                                        "selectedBooksTambah1");

                                                                                    for (var i = 0; i < select.options
                                                                                        .length; i++) {
                                                                                        if (select.options[i].selected) {
                                                                                            selectedItems.push(select.options[i]);
                                                                                        }
                                                                                    }

                                                                                    selectedItems.forEach(function (item) {
                                                                                        selectedBooks.appendChild(item
                                                                                            .cloneNode(true));
                                                                                    });
                                                                                }
                                                                            </script>
                                                                        </div>
                                                                        <div class="mb-3 row form-group">
                                                                            <label for="tanggal_peminjaman1"
                                                                                class="col-sm-3 col-form-label">Tanggal
                                                                                Peminjaman</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="date" class="form-control"
                                                                                    id="tanggal_peminjaman1"
                                                                                    name="tanggal_peminjaman1"
                                                                                    value="<?= $row['Tanggal Pinjam'] ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3 row form-group">
                                                                            <label for="tanggal_pengembalian1"
                                                                                class="col-sm-3 col-form-label">Tanggal
                                                                                Pengembalian</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="date" class="form-control"
                                                                                    id="tanggal_pengembalian1"
                                                                                    name="tanggal_pengembalian1"
                                                                                    value="<?= $row['Tanggal Kembali'] ?>">
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        // Pastikan $row memiliki nilai yang valid sebelum mengakses elemen array di dalamnya
                                                                        if (isset($row) && isset($row['Status'])) {
                                                                            $statusValue = $row['Status'];
                                                                        } else {
                                                                            $statusValue = ''; // Atur nilai default jika $row tidak terdefinisi atau elemen array-nya tidak ada
                                                                        }
                                                                        ?>
                                                                        <div class="mb-3">
                                                                            <label for="STATUS"
                                                                                class="col-sm-3 col-form-label">Status
                                                                                Peminjaman</label><br>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" class="form-check-input"
                                                                                    id="STATUS" name="STATUS" value="Dipinjam"
                                                                                    <?= ($statusValue === 'Dipinjam') ? 'checked' : '' ?>>
                                                                                <label class="form-check-label"
                                                                                    for="STATUS">Dipinjam</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio" class="form-check-input"
                                                                                    id="STATUS" name="STATUS" value="Selesai"
                                                                                    <?= ($statusValue === 'Selesai') ? 'checked' : '' ?>>
                                                                                <label class="form-check-label"
                                                                                    for="STATUS">Selesai</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3 row form-group">
                                                                            <label for="DENDA"
                                                                                class="col-sm-3 col-form-label">Denda</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" class="form-control"
                                                                                    id="DENDA" name="DENDA"
                                                                                    value="<?= $row['Denda'] ?>">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="reset" class="btn btn-primary"
                                                                            onclick="resetData()">Reset</button>
                                                                        <button type="update" name="update"
                                                                            class="btn btn-success"
                                                                            onclick="saveChanges(<?= $row['ID Peminjaman'] ?>)">Save
                                                                            Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
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
                            </div>
                        </table>
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
                            <div style="height: 700px; overflow-y: auto;">
                                <!-- <form action="proses_simpan.php" method="post"> -->
                                <form action="" method="post">
                                    <div class="modal-body custom-modal-body">
                                        <div class="mb-3 row form-group">
                                            <label for="recipient-name" class="col-form-label">ID Peminjam:</label>
                                            <input type="text" name="ID_MEMBER" class="form-control" method="post"
                                                id="ID_MEMBER" required>
                                        </div>
                                        <div class="mb-3 row form-group">

                                            <input type="hidden" name="ID_BUKU" class="form-control" method="post"
                                                id="ID_BUKU">
                                        </div>

                                        <div class="mb-3 row form-group">

                                            <label for="ID_BUKU_TAMBAH" class="col-form-label">Pilih Buku:</label>
                                            <select name="ID_BUKU_TAMBAH[]" class="form-select" id="ID_BUKU_TAMBAH"
                                                multiple required>
                                                <?php
                                                // Query untuk mengambil data buku dari tabel 'BUKU'
                                                $query = "SELECT ID_BUKU, JUDUL_BUKU FROM BUKU";
                                                $result = mysqli_query($conn, $query);

                                                // Periksa apakah query berhasil dijalankan
                                                if ($result) {
                                                    // Loop melalui setiap baris hasil query dan tampilkan sebagai option dalam select
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . $row['ID_BUKU'] . '">' . $row['JUDUL_BUKU'] . '</option>';
                                                    }
                                                } else {
                                                    // Tampilkan pesan jika terjadi kesalahan saat mengambil data
                                                    echo "Gagal mengambil data buku: " . mysqli_error($conn);
                                                }
                                                ?>
                                            </select>
                                            <div class="mb-3 row form-group">
                                                <div class="space-above-button">

                                                    <input type="button" value="Tambahkan"
                                                        onclick="addSelectedBooksTambah()">
                                                </div>
                                            </div>
                                            <div class="mb-3 row form-group">
                                                <label for="selectedBooksTambah" class="col-form-label">Buku yang
                                                    Dipilih:</label>
                                                <select name="selectedBooksTambah" id="selectedBooksTambah"
                                                    class="form-select" multiple>
                                                </select>
                                            </div>



                                            <script>
                                                function addSelectedBooksTambah() {
                                                    var select = document.getElementById("ID_BUKU_TAMBAH");
                                                    var selectedItems = [];
                                                    var selectedBooks = document.getElementById("selectedBooksTambah");

                                                    for (var i = 0; i < select.options.length; i++) {
                                                        if (select.options[i].selected) {
                                                            selectedItems.push(select.options[i]);
                                                        }
                                                    }

                                                    selectedItems.forEach(function (item) {
                                                        selectedBooks.appendChild(item.cloneNode(true));
                                                    });
                                                }
                                            </script>

                                        </div>

                                        <div class="mb-3 row form-group">
                                            <label for="TANGGAL_PEMINJAMAN" class="col-form-label">Tanggal
                                                Peminjaman:</label>
                                            <input type="date" name="TANGGAL_PEMINJAMAN" class="form-control"
                                                id="TANGGAL_PEMINJAMAN">
                                        </div>
                                        <div class="mb-3 row form-group">
                                            <label for="TANGGAL_PENGEMBALIAN" class="col-form-label">Tanggal
                                                Pengembalian:</label>
                                            <input type="date" name="TANGGAL_PENGEMBALIAN" class="form-control"
                                                id="TANGGAL_PENGEMBALIAN">
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">



                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-primary"
                                            onclick="resetData()">Reset</button>
                                        <button type="submit" name="submit" class="btn btn-success ms-2"
                                            aria-hidden="true"><i class="fa fa-floppy-o"></i> Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- <script>
                            function resetForm() {
                                document.getElementById("exampleModal").reset(); // Reset form dengan id "exampleModal"
                            }
                            </script> -->
                        </div>
                    </div>
                </div>





                <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                <div class="table-container">
                    <div class="table-kembali">Tabel Pengembalian</div>

                    <div class="table-responsive small">
                        <table class="table table-striped table-data">
                            <!-- Bagian Header Tabel -->
                            <thead>
                                <tr>
                                    <th>ID Peminjaman</th>
                                    <th>ID Buku</th>
                                    <th>Status Peminjaman</th>
                                    <th>Status Buku</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil data dari tabel DETAILPEMINJAMAN
                                
                                // Query untuk mengambil data dari tabel DETAILPEMINJAMAN dengan status 'Kembali'
                                $query_detail_peminjaman = "SELECT dp.ID_PEMINJAMAN, dp.ID_BUKU, dp.STATUS_PEMINJAMAN, dp.STATUS_BUKU
                                                            FROM DETAILPEMINJAMAN dp
                                                            INNER JOIN PEMINJAMAN p ON dp.ID_PEMINJAMAN = p.ID_PEMINJAMAN
                                                            WHERE dp.STATUS_PEMINJAMAN = 'Selesai'";

                                // $query_detail_peminjaman = "SELECT ID_PEMINJAMAN, ID_BUKU, STATUS_PEMINJAMAN, STATUS_BUKU FROM DETAILPEMINJAMAN 
                                //           WHERE STATUS_PEMINJAMAN = 'Kembali'";
                                
                                $result_detail_peminjaman = mysqli_query($conn, $query_detail_peminjaman);

                                if ($result_detail_peminjaman && mysqli_num_rows($result_detail_peminjaman) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_detail_peminjaman)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['ID_PEMINJAMAN'] . "</td>";
                                        echo "<td>" . $row['ID_BUKU'] . "</td>"; // Tampilkan ID buku
                                        echo "<td>" . $row['STATUS_PEMINJAMAN'] . "</td>";
                                        echo "<td>" . $row['STATUS_BUKU'] . "</td>";
                                        echo "<td>";

                                        // Tombol Edit
                                        echo "<a href='#editModal" . $row['ID_PEMINJAMAN'] . "' class='btn btn-warning btn-xs m-1' data-bs-toggle='modal'><i class='fa fa-pencil-square-o'></i> Edit</a>";

                                        // Tombol Hapus
                                        echo "<a href='index.php?page=peminjaman&delete_id=" . $row['ID_PEMINJAMAN'] . "' onclick=\"return confirm('Hapus Data Peminjaman?');\" class='btn btn-danger btn-xs m-1'><i class='fa fa-trash'></i> Hapus</a>";

                                        echo "</td>";
                                        echo "</tr>";

                                        echo "<div id='editModal" . $row['ID_PEMINJAMAN'] . "' class='modal'>";
                                        echo "<div class='modal-dialog modal-dialog-centered'>"; // Menambahkan kelas 'modal-dialog-centered'
                                        echo "<div class='modal-content'>";
                                        echo "<div class='modal-header'>";
                                        echo "<h5 class='modal-title'>Edit Data Buku</h5>";
                                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                        echo "</div>";
                                        echo "<div class='modal-body'>";
                                        echo "<form method='post' action='index.php?page=Peminjaman'>";
                                        echo "<input type='hidden' name='ID_PEMINJAMAN' value='" . $row['ID_PEMINJAMAN'] . "'>";
                                        echo '<div class="mb-3">';
                                        echo '<label for="STATUS_BUKU" class="col-sm-3 col-form-label">Status Buku</label><br>';
                                        echo '<div class="form-check form-check-inline">';
                                        echo '<input type="radio" class="form-check-input" id="STATUS_BUKU" name="STATUS_BUKU" value="Bagus" ' . (($statusValue === 'bagus') ? 'checked' : '') . '>';
                                        echo '<label class="form-check-label" for="STATUS_BUKU">Bagus</label>';
                                        echo '</div>';
                                        echo '<div class="form-check form-check-inline">';
                                        echo '<input type="radio" class="form-check-input" id="STATUS_BUKU" name="STATUS_BUKU" value="Rusak" ' . (($statusValue === 'Rusak') ? 'checked' : '') . '>';
                                        echo '<label class="form-check-label" for="STATUS_BUKU">Rusak</label>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo "<button type='update' class='btn btn-primary mt-3'>Simpan</button>";
                                        echo "</form>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Tidak ada data pengembalian</td></tr>";
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>
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