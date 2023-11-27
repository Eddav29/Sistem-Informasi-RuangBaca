<div class="container-fluid">
    <div class="row">
        <?php
        include "menu.php";
        include "Config/koneksi.php";

        // $query_total = "SELECT count(id) as jml from buku";
        // $result_total = mysqli_query($koneksi,$query_total);
        // $row_total = mysqli_fetch_assoc($result_total);


        // $query_dipinjam = "SELECT count(id) as jml from detail_peminjaman";
        // $result_dipinjam = mysqli_query($koneksi, $query_dipinjam);
        // $row_dipinjam = mysqli_fetch_assoc($result_dipinjam);


        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5>16</h5>
                            <h5><i class="fa fa-users fa-2x" aria-hidden="true"></i></h5>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Anggota</h5>
                            <p class="card-text">jumlah anggota terdaftar</p>

                            
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5>16</h5>
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
                            <h5>16</h5>
                            <h5><i class="fa fa-user fa-2x" aria-hidden="true"></i></h5>
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
                            <h5>16</h5>
                            <h5><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i></h5>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Transaksi</h5>
                            <p class="card-text">Total jumlah transaksi</p>
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
                            
                            <a href="index.php?page=anggota" class="btn btn-primary"><i class="fa fa-users" aria-hidden="true"></i> Kelola</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-bar-chart-line-fill" aria-hidden="true"></i>  STATISTIK</h5>
                            <p class="card-text">Total Jabatan: <?= $row_jabatan['jml'] ?>.</p>
                            <p class="card-text">Total Inventaris: <?= $row['']?></p>
                            <a href="index.php?page=jabatan" class="btn btn-primary"><i class="fa fa-puzzle-piece" aria-hidden="true"></i> Kelola</a>
                        </div>
                    </div>
                </div>
            </div>
            <BR></BR>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa fa-users"></i>  MEMBER</h5>
                            <h5 class="card-title" text-right>Lihat Selengkapnya >></h5>
                        </div>

                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa fa-book"> BOOK</i></h5>
                            <h5 class="card-title" text-right>Lihat Selengkapnya >></h5>

                        </div>

                    </div>

                </div>

            </div>
            <br></br>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa fa-users"></i>  MEMBER</h5>
                            <h5 class="card-title" text-right>Lihat Selengkapnya >></h5>
                        </div>

                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title"><i class="fa fa-book"> BOOK</i></h5>
                            <h5 class="card-title" text-right>Lihat Selengkapnya >></h5>

                        </div>

                    </div>

                </div>

            </div>
        </main>
    </div>
</div>
