<div class="container-fluid ">
    <div class="row">
        <?php

        //include "menu.php";
        // $query_total = "SELECT count(id) as jml from buku";
        // $result_total = mysqli_query($koneksi,$query_total);
        // $row_total = mysqli_fetch_assoc($result_total);
        $db = new Database();
        $conn = $db->getConnection();

        // $query_dipinjam = "SELECT count(id) as jml from detail_peminjaman";
        // $result_dipinjam = mysqli_query($koneksi, $query_dipinjam);
        // $row_dipinjam = mysqli_fetch_assoc($result_dipinjam);


        ?>

        <main class="col-md-9 col-lg-12 px-md-4 m=0 ms-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1><h5<i class="fa-solid fa-user fa-2x" aria-hidden="true"></i></h5>
            </div>
            <div class="row">
                <div class="col-sm-3 m-auto">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5>121</h5>
                            <h5><i class="fa-solid fa-clock-rotate-left fa-2x" aria-hidden="true"></i></h5>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">History</h5>
                            <p class="card-text">Total jumlah history</p>


                        </div>
                    </div>
                </div>
                <div class="col-sm-3 m-auto">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5>4</h5>
                            <h5><i class="fa-solid fa-bell fa-2x" aria-hidden="true"></i></h5>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Notifikasi</h5>
                            <p class="card-text">Jumlah total notifikasi</p>
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
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-bar-chart-line-fill" aria-hidden="true"></i> STATISTIK BUKU</h5>
                            <p class="card-text">Total Inventaris: 50</p>
                            <p class="card-text">Buku Dipinjam: 30</p>
                            <p class="card-text">Buku Di rak: 20</p>
                        </div>
                    </div>
                </div>
            </div>
            <BR></BR>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa-solid fa-clock-rotate-left"></i> HISTORY</h5>
                            <a href="index.php?page=History" class="btn btn-primary"> Lihat Selengkapnya >></a>
                        </div>
                        <div class="table-responsive small">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">No</th>
                                        <th scope="col">JUDUL BUKU</th>
                                        <th scope="col">TGL PEMINJAMAN</th>
                                        <th scope="col">TGL PENGEMBALIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query = $query = "SELECT b.JUDUL_BUKU, p.TANGGAL_PEMINJAMAN, p.TANGGAL_PENGEMBALIAN
                                    FROM buku b
                                    JOIN DETAILPEMINJAMAN dp ON b.ID_BUKU = dp.ID_BUKU
                                    JOIN PEMINJAMAN p ON dp.ID_PEMINJAMAN = p.ID_PEMINJAMAN
                                    ORDER BY p.ID_PEMINJAMAN DESC";
                                    $result = mysqli_query($conn, $query);

                                    $count = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $no++ ?></th>
                                            <td><?= $row['JUDUL_BUKU'] ?></td>
                                            <td><?= $row['TANGGAL_PEMINJAMAN'] ? date('Y-m-d', strtotime($row['TANGGAL_PEMINJAMAN'])) : 'N/A' ?></td>
                                            <td><?= $row['TANGGAL_PENGEMBALIAN'] ? date('Y-m-d', strtotime($row['TANGGAL_PENGEMBALIAN'])) : 'N/A' ?></td>
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
                        <h5 class="card-title"><i class="fa-solid fa-bell"></i> NOTIFIKASI</h5>
                            <a href="index.php?page=Notifikasi" class="btn btn-primary"> Lihat Selengkapnya >></a>

                        </div>
                        <div class="table-responsive small">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Penulis</th>
                                        <th scope="col">Jumlah</th>
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
                

                </div>
                    </div>

                </div>

            </div>
        </main>
    </div>
</div>