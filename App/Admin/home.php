<div class="container-fluid ">
    <div class="row">
        <?php


        // $query_total = "SELECT count(id_buku) as jml from buku";
        // $result_total = mysqli_query($koneksi,$query_total);
        // $row_total = mysqli_fetch_assoc($result_total);
        $db = new Database();
        $conn = $db->getConnection();

        // $query_dipinjam = "SELECT count(id) as jml from detail_peminjaman";
        // $result_dipinjam = mysqli_query($koneksi, $query_dipinjam);
        // $row_dipinjam = mysqli_fetch_assoc($result_dipinjam);


        ?>

        <main class="col-md-9 col-lg-12 px-md-4 ms-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>
            <?php
// Assuming you have established a database connection and fetched the counts

// Fetch total members
$queryMembers = "SELECT COUNT(*) AS totalMembers FROM member where level= 'Member'";
$resultMembers = mysqli_query($conn, $queryMembers);
$rowMembers = mysqli_fetch_assoc($resultMembers);
$totalMembers = $rowMembers['totalMembers'];

// Fetch total books
$queryBooks = "SELECT COUNT(*) AS totalBooks FROM buku";
$resultBooks = mysqli_query($conn, $queryBooks);
$rowBooks = mysqli_fetch_assoc($resultBooks);
$totalBooks = $rowBooks['totalBooks'];

// Fetch total petugas
$queryPetugas = "SELECT COUNT(*) AS totalPetugas FROM member WHERE level = 'Admin'";
$resultPetugas = mysqli_query($conn, $queryPetugas);
$rowPetugas = mysqli_fetch_assoc($resultPetugas);
$totalPetugas = $rowPetugas['totalPetugas'];

// Fetch total peminjaman
$queryPeminjaman = "SELECT COUNT(*) AS totalPeminjaman FROM peminjaman";
$resultPeminjaman = mysqli_query($conn, $queryPeminjaman);
$rowPeminjaman = mysqli_fetch_assoc($resultPeminjaman);
$totalPeminjaman = $rowPeminjaman['totalPeminjaman'];
?>

<div class="row">
    <div class="col-sm-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5><?= $totalMembers ?></h5>
                <h5><i class="fa fa-users fa-2x" aria-hidden="true"></i></h5>
            </div>
            <div class="card-body">
                <h5 class="card-title">Member</h5>
                <p class="card-text">jumlah member terdaftar</p>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5><?= $totalBooks ?></h5>
                <h5><i class="fa fa-book fa-2x" aria-hidden="true"></i></h5>
            </div>
            <div class="card-body">
                <h5 class="card-title">Buku</h5>
                <p class="card-text">jumlah buku terdaftar</p>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5><?= $totalPetugas ?></h5>
                <h5><i class="fa-solid fa-user-tie fa-2x" aria-hidden="true"></i></h5>
            </div>
            <div class="card-body">
                <h5 class="card-title">Petugas</h5>
                <p class="card-text">jumlah petugas terdaftar</p>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5><?= $totalPeminjaman ?></h5>
                <h5><i class="fa-solid fa-truck-ramp-box fa-2x" aria-hidden="true"></i></h5>
            </div>
            <div class="card-body">
                <h5 class="card-title">Peminjaman</h5>
                <p class="card-text">Total jumlah peminjaman</p>
            </div>
        </div>
    </div>
</div>

            <br>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fa fa-bars" aria-hidden="true"></i> DATA RUANG BACA</h5>
                            <div>
                                <h6 class="card-title">Nama Ruangan</h6>
                                <p class="card-text">Ruang Baca JTI Polinema</p>
                                <h6 class="card-title">Alamat</h6>
                                <p class="card-text">Jl. Soekarno Hatta</p>
                                <h6 class="card-title">Tentang</h6>
                                <p class="card-text">Ruang Baca</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
// Mendapatkan total inventaris
$queryTotalInventaris = "SELECT COUNT(*) AS total_inventaris FROM buku";
$resultTotalInventaris = mysqli_query($conn, $queryTotalInventaris);
$rowTotalInventaris = mysqli_fetch_assoc($resultTotalInventaris);
$totalInventaris = $rowTotalInventaris['total_inventaris'];

// Mendapatkan total buku yang dipinjam
$queryBukuDipinjam = "SELECT COUNT(*) AS total_buku_dipinjam FROM detailpeminjaman WHERE STATUS_PEMINJAMAN = 'Dipinjam'";
$resultBukuDipinjam = mysqli_query($conn, $queryBukuDipinjam);
$rowBukuDipinjam = mysqli_fetch_assoc($resultBukuDipinjam);
$totalBukuDipinjam = $rowBukuDipinjam['total_buku_dipinjam'];

// Mendapatkan total buku dirak
$queryBukuDirak = "SELECT COUNT(*) AS total_buku_dirak FROM buku WHERE KETERSEDIAAN = 'Tersedia'";
$resultBukuDirak = mysqli_query($conn, $queryBukuDirak);
$rowBukuDirak = mysqli_fetch_assoc($resultBukuDirak);
$totalBukuDirak = $rowBukuDirak['total_buku_dirak'];

// Mendapatkan data kategori untuk diagram lingkaran
$queryKategori = "SELECT k.NAMA_KATEGORI, COUNT(dkb.ID_BUKU) AS jumlah FROM kategori k
                  LEFT JOIN detail_kategori_buku dkb ON k.ID_KATEGORI = dkb.ID_KATEGORI
                  GROUP BY k.ID_KATEGORI";
$resultKategori = mysqli_query($conn, $queryKategori);
$dataKategori = array();

while ($rowKategori = mysqli_fetch_assoc($resultKategori)) {
    $dataKategori[] = $rowKategori;
}
?>
<div class="col-sm-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><i class="bi bi-bar-chart-line-fill" aria-hidden="true"></i> STATISTIK</h5>
            <div class="d-flex justify-content-between">
                <div>
                    <p class="card-text">Total Inventaris:<?= $totalInventaris?></p>
                    <p class="card-text">Buku Dipinjam:<?= $totalBukuDipinjam?></p>
                    <p class="card-text">Buku Dirak:<?= $totalBukuDirak?></p>
                </div>
                <canvas id="kategoriChart" width="400" height="185"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById('kategoriChart').getContext('2d');
    var kategoriChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Total Inventaris', 'Buku Dipinjam', 'Buku Dirak'],
            datasets: [{
                data: [<?= $totalInventaris ?>, <?= $totalBukuDipinjam ?>, <?= $totalBukuDirak ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
});
</script>


            </div>
            <BR></BR>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa fa-users"></i> MEMBER</h5>
                            <a href="index.php?page=Member" class="btn btn-primary"> Lihat Selengkapnya >></a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">USERNAME</th>
                                        <th scope="col">NAMA</th>
                                        <th scope="col">ALAMAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT * FROM member where level = 'Member' order by id_member asc";
                                    $result = mysqli_query($conn, $query);

                                    $count = 0;

                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $no++ ?></th>
                                            <td><?= $row['USERNAME_MEMBER'] ?></td>
                                            <td><?= $row['NAMA_MEMBER'] ?></td>
                                            <td><?= $row['ALAMAT'] ?></td>

                                        </tr>
                                    <?php
                                        $count++;
                                        if ($count == 5) {
                                            break;
                                        }
                                    } ?>
                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa fa-book"> BOOK</i></h5>
                            <a href="index.php?page=Buku" class="btn btn-primary"> Lihat Selengkapnya >></a>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Ketersediaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT * FROM buku order by id_buku desc";
                                    $result = mysqli_query($conn, $query);

                                    $count = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $no++ ?></th>
                                            <td><?= $row['JUDUL_BUKU'] ?></td>
                                            <td><?= $row['DESKRIPSI'] ?></td>
                                            <td><?= $row['KETERSEDIAAN'] ?></td>
                                        </tr>
                                    <?php
                                        $count++;
                                        if ($count == 5) {
                                            break;
                                        }
                                    } ?>
                                </tbody>

                            </table>
                        </div>


                    </div>

                </div>

            </div>
            <br></br>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa fa-user-tie"></i> PETUGAS</h5>
                            <a href="index.php?page=Buku" class="btn btn-primary"> Lihat Selengkapnya >></a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Petugas</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Alamat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT * FROM member where level = 'Admin' order by id_member asc";
                                    $result = mysqli_query($conn, $query);

                                    $count = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $no++ ?></th>
                                            <td><?= $row['USERNAME_MEMBER'] ?></td>
                                            <td><?= $row['NAMA_MEMBER'] ?></td>
                                            <td><?= $row['ALAMAT'] ?></td>

                                        </tr>
                                    <?php
                                        $count++;
                                        if ($count == 5) {
                                            break;
                                        }
                                    } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa-solid fa-truck-ramp-box"> PEMINJAMAN</i></h5>
                            <a href="index.php?page=Buku" class="btn btn-primary"> Lihat Selengkapnya >></a>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Peminjaman</th>
                                        <th scope="col">ID Member</th>
                                        <th scope="col">Tanggal Peminjaman</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT * FROM peminjaman order by id_peminjaman asc";
                                    $result = mysqli_query($conn, $query);

                                    $count = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $no++ ?></th>
                                            <td><?= $row['ID_MEMBER'] ?></td>
                                            <td><?= $row['TANGGAL_PEMINJAMAN'] ?></td>
                                            <td><?= $row['ATTRIBSTATUSUTE_26'] ?></td>

                                        </tr>
                                    <?php
                                        $count++;
                                        if ($count == 5) {
                                            break;
                                        }
                                    } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>

            </div>
            <br></br>

            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa-solid fa-list"></i> KATEGORI</h5>
                            <a href="index.php?page=Buku" class="btn btn-primary" width="75px"> Lihat Selengkapnya >></a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Petugas</th>
                                        <th scope="col">Nama Kategori</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT * FROM kategori order by id_kategori asc";
                                    $result = mysqli_query($conn, $query);

                                    $count = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $no++ ?></th>
                                            <td><?= $row['NAMA_KATEGORI'] ?></td>
                                        </tr>
                                    <?php
                                        $count++;
                                        if ($count == 5) {
                                            break;
                                        }
                                    } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa-solid fa-user-pen"> PENULIS</i></h5>
                            <a href="index.php?page=Buku" class="btn btn-primary"> Lihat Selengkapnya >></a>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Penulis</th>
                                        <th scope="col">Nama Penulis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = "SELECT * FROM penulis order by id_penulis asc";
                                    $result = mysqli_query($conn, $query);

                                    $count = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $no++ ?></th>
                                            <td><?= $row['NAMA_PENULIS'] ?></td>
                                        </tr>
                                    <?php
                                        $count++;
                                        if ($count == 5) {
                                            break;
                                        }
                                    } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>
</div>