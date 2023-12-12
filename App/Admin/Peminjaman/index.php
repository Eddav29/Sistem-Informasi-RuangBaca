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
            display: flexbox;
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
            $add = $peminjaman->addPeminjamanFromForm();
            $edit = $peminjaman->editPeminjamanFromForm();
            $hapus = $peminjaman->deletePeminjamanFromForm();



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
            SELECT
            PEMINJAMAN.ID_PEMINJAMAN AS 'ID Pengembalian',
            PEMINJAMAN.ID_MEMBER AS 'ID Member',
            MEMBER.NAMA_MEMBER AS 'Nama Peminjam',
            PEMINJAMAN.TANGGAL_PEMINJAMAN AS 'Tanggal Pinjam',
            PEMINJAMAN.TANGGAL_PENGEMBALIAN AS 'Tanggal Kembali',
            BUKU.JUDUL_BUKU AS 'Judul Buku',
            COUNT(DETAILPEMINJAMAN.ID_BUKU) AS 'Jumlah Buku',
            PEMINJAMAN.DENDA AS 'Denda'
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
                                        <th>status</th>
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


                                                            <!-- <div class="modal fade" id="editModal<?= $row['ID Peminjaman'] ?>"
                                                                data-bs-backdrop="static" tabindex="-1" role="dialog"
                                                                data-bs-keyboard="false"
                                                                aria-labelledby="editModalLabel<?= $row['ID Peminjaman'] ?>"
                                                                aria-hidden="true">
                                                                <div
                                                                    class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="editModalLabel<?= $row['ID Peminjaman']; ?>">
                                                                                <i class="fa-solid fa-list"></i> Edit peminjaman
                                                                            </h5>
                                                                            <button type="button" class="btn-close-style"
                                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                                <i class="fa-solid fa-xmark"></i>
                                                                            </button>
                                                                        </div> -->



                                                                        <!-- Form untuk Edit -->
                                                                        <div style="height: 400px; overflow-y: auto;">
                                                                            <form action="" method="post">
                                                                                <div class="modal-body custom-modal-body">


                                                                                    <div class="mb-3 row form-group">


                                                                                        <input type="hidden"
                                                                                            name="ID_PEMINJAMAN"
                                                                                            class="form-control"
                                                                                            id="ID_PEMINJAMAN"
                                                                                            value="<?= $row['ID Peminjaman'] ?>">

                                                                                    </div>

                                                                                    <div class="mb-3 row form-group">
                                                                                        <label for="recipient-name"
                                                                                            class="col-form-label">ID
                                                                                            Member:</label>
                                                                                        <input type="text" name="ID_MEMBER"
                                                                                            class="form-control" id="ID_MEMBER"
                                                                                            value="<?= isset($row['ID_MEMBER']) ? $row['ID_MEMBER'] : '' ?>">

                                                                                    </div>

                                                                                    <div class="mb-3 row form-group">


                                                                                        <input type="hidden" name="ID_BUKU"
                                                                                            class="form-control" method="post"
                                                                                            id="ID_BUKU">
                                                                                    </div>

                                                                                    <div class="mb-3 row form-group">

                                                                                        <label for="ID_BUKU_EDIT"
                                                                                            class="col-form-label">Pilih
                                                                                            Buku:</label>
                                                                                        <select name="ID_BUKU_EDIT[]"
                                                                                            class="form-select"
                                                                                            id="ID_BUKU_EDIT" multiple>
                                                                                            <?php
                                                                                            // Query untuk mengambil data buku dari tabel 'BUKU'
                                                                                            $query = "SELECT ID_BUKU,JUDUL_BUKU FROM BUKU";
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

                                                                                                <input type="button"
                                                                                                    value="Tambahkan"
                                                                                                    onclick="addSelectedBooks()">
                                                                                            </div>
                                                                                        </div>


                                                                                        <div class="mb-3 row form-group">
                                                                                            <label for="selectedBooks"
                                                                                                class="col-form-label">Buku yang
                                                                                                Dipilih:</label>
                                                                                            <select name="selectedBooks"
                                                                                                id="selectedBooks"
                                                                                                class="form-select" multiple>
                                                                                            </select>
                                                                                        </div>

                                                                                        <script>
                                                                                            function addSelectedBooks() {
                                                                                                var select = document
                                                                                                    .getElementById(
                                                                                                        "ID_BUKU_EDIT");
                                                                                                var selectedItems = [];
                                                                                                var selectedBooks = document
                                                                                                    .getElementById(
                                                                                                        "selectedBooks");

                                                                                                for (var i = 0; i < select.options
                                                                                                    .length; i++) {
                                                                                                    if (select.options[i]
                                                                                                        .selected) {
                                                                                                        selectedItems.push(select
                                                                                                            .options[i]);
                                                                                                    }
                                                                                                }

                                                                                                selectedItems.forEach(function (
                                                                                                    item) {
                                                                                                    selectedBooks
                                                                                                        .appendChild(item
                                                                                                            .cloneNode(true)
                                                                                                        );
                                                                                                });
                                                                                            }
                                                                                        </script>


                                                                                    </div>


                                                                                    <div class="mb-3 row form-group">
                                                                                        <label for="tanggal_peminjaman1"
                                                                                            class="col-sm-3 col-form-label">Tanggal
                                                                                            Peminjaman</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="date"
                                                                                                class="form-control"
                                                                                                id="tanggal_peminjaman1"
                                                                                                name="tanggal_peminjaman1"
                                                                                                value="<?= $row['TANGGAL_PEMINJAMAN'] ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-3 row form-group">
                                                                                        <label for="tanggal_pengembalian1"
                                                                                            class="col-sm-3 col-form-label">Tanggal
                                                                                            Pengembalian</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="date"
                                                                                                class="form-control"
                                                                                                id="tanggal_pengembalian1"
                                                                                                name="tanggal_pengembalian1"
                                                                                                value="<?= $row['TANGGAL_PENGEMBALIAN'] ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                    // Pastikan $row memiliki nilai yang valid sebelum mengakses elemen array di dalamnya
                                                                                    if (isset($row) && isset($row['ATTRIBSTATUSUTE_26'])) {
                                                                                        $statusValue = $row['ATTRIBSTATUSUTE_26'];
                                                                                    } else {
                                                                                        $statusValue = ''; // Atur nilai default jika $row tidak terdefinisi atau elemen array-nya tidak ada
                                                                                    }
                                                                                    ?>
                                                                                    <div class="mb-3">
                                                                                        <label for="STATUS"
                                                                                            class="col-sm-3 col-form-label">Status</label><br>
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input type="radio"
                                                                                                class="form-check-input"
                                                                                                id="STATUS" name="STATUS"
                                                                                                value="Dipinjam"
                                                                                                <?= ($statusValue === 'Dipinjam') ? 'checked' : '' ?>>
                                                                                            <label class="form-check-label"
                                                                                                for="STATUS">Dipinjam</label>
                                                                                        </div>
                                                                                        <div
                                                                                            class="form-check form-check-inline">
                                                                                            <input type="radio"
                                                                                                class="form-check-input"
                                                                                                id="STATUS" name="STATUS"
                                                                                                value="Kembali"
                                                                                                <?= ($statusValue === 'Kembali') ? 'checked' : '' ?>>
                                                                                            <label class="form-check-label"
                                                                                                for="STATUS">Kembali</label>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="mb-3 row form-group">
                                                                                        <label for="DENDA"
                                                                                            class="col-sm-3 col-form-label">
                                                                                            Denda</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="number"
                                                                                                class="form-control" id="DENDA"
                                                                                                name="DENDA"
                                                                                                value="<?= $row['DENDA'] ?>">
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="reset" class="btn btn-primary"
                                                                                        onclick="resetData()">Reset</button>

                                                                                    <button type="update" name="update"
                                                                                        class="btn btn-success"
                                                                                        onclick="saveChanges(<?= $row['ID_PEMINJAMAN'] ?>)">Save
                                                                                        Changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>

<script>
    $(document).ready(function () {
    $(document).on('click', 'a[data-role=update]', function () {
        var id = $(this).data('id');
        var ID_PEMINJAMAN = $('#' + id).find('td[data-target=ID_PEMINJAMAN]').text();
        var ID_MEMBER = $('#' + id).find('td[data-target=ID_MEMBER]').text();
        var tanggal_peminjaman1 = $('#' + id).find('td[data-target=tanggal_peminjaman1]').text();
        var tanggal_pengembalian1 = $('#' + id).find('td[data-target=tanggal_pengembalian1]').text();
        var STATUS = $('#' + id).find('td[data-target=STATUS]').text();
        var DENDA = $('#' + id).find('td[data-target=DENDA]').text();

        $('#ID_PEMINJAMAN').val(ID_PEMINJAMAN);
        $('#ID_MEMBER').val(ID_MEMBER);
        $('#tanggal_peminjaman1').val(tanggal_peminjaman1);
        $('#tanggal_pengembalian1').val(tanggal_pengembalian1);
        $('input[name="STATUS"][value="' + STATUS + '"]').prop('checked', true);
        $('#DENDA').val(DENDA);
        $('#editModal').modal('show');
    });

    $('#update').click(function () {
        var ID_PEMINJAMAN = $('#ID_PEMINJAMAN').val();
        var ID_MEMBER = $('#ID_MEMBER').val();
        var tanggal_peminjaman1 = $('#tanggal_peminjaman1').val();
        var tanggal_pengembalian1 = $('#tanggal_pengembalian1').val();
        var STATUS = $('input[name="STATUS"]:checked').val();
        var DENDA = $('#DENDA').val();

        $.ajax({
            url: 'Functin/Peminjaman.php',
            method: 'post',
            data: {
                ID_PEMINJAMAN: ID_PEMINJAMAN,
                ID_MEMBER: ID_MEMBER,
                tanggal_peminjaman1: tanggal_peminjaman1,
                tanggal_pengembalian1: tanggal_pengembalian1,
                STATUS: STATUS,
                DENDA: DENDA
            },
            success: function (response) {
                // Tambahkan logika sesuai respons yang diterima
                // Misalnya, perbarui elemen HTML jika respons sukses
            },
            error: function () {
                alert('Gagal memperbarui data.');
            }
        });
    });
});

</script>

                                                            </div>
                                                            <!-- Tombol Hapus -->
                                                            <a href="index.php?page=peminjaman&delete_id=<?= $row['ID Peminjaman'] ?>"
                                                                onclick="javascript:return confirm('Hapus Data Peminjaman?');"
                                                                class="btn btn-danger btn-xs m-1">
                                                                <i class="fa fa-trash"></i> Hapus
                                                            </a>

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
                                <h5 class="modal-title" id="myModalLabel<?= $row["ID"]; ?>">
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
                                                id="ID_MEMBER">
                                        </div>
                                        <div class="mb-3 row form-group">

                                            <input type="hidden" name="ID_BUKU" class="form-control" method="post"
                                                id="ID_BUKU">
                                        </div>

                                        <div class="mb-3 row form-group">

                                            <label for="ID_BUKU_TAMBAH" class="col-form-label">Pilih Buku:</label>
                                            <select name="ID_BUKU_TAMBAH[]" class="form-select" id="ID_BUKU_TAMBAH"
                                                multiple>
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
                                        <button type="submit" name="sub" class="btn btn-success ms-2"
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


                    <table id="tablePengembalian">
                        <table class="table table-striped table-data">
                            <div class="table-responsive small">
                                <thead>
                                    <tr>
                                        <th>ID Pengembalian</th>
                                        <th>ID Member</th>
                                        <th>Nama Peminjam</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <!-- <th>Denda</th> -->

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
                                            // echo "<td>" . $row["Denda"] . "</td>";
                                    
                                            echo "<td>";
                                            ?>
                                            <!-- Tombol Hapus dalam bentuk button -->
                                            <!-- <button type="button" class="btn btn-danger btn-xs"
                                                onclick="deleteConfirmation(<?= $row['ID Pengembalian'] ?>)"><i
                                                    class="fa fa-trash"></i>Hapus</button> -->

                                            <a href="index.php?page=peminjaman&delete=<?= $row['ID Pengembalian'] ?>"
                                                onclick="javascript:return confirm('Hapus Data Pengembalian?');"
                                                class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                            <?php
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8'>Tidak ada data pengembalian</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </div>
                        </table>
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