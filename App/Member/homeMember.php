<div class="container-fluid ">
    <div class="row">
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is logged in
        if (!isset($_SESSION["userID"]) || !isset($_SESSION["userLevel"])) {
            header("Location: App/Katalog/index.php");
            exit();
        }

        // Retrieve ID_MEMBER from the session
        $userID = $_SESSION["userID"];
        $userLevel = $_SESSION["userLevel"];

        // Include your database connection file or establish a connection here

        $database = new Database();
        $conn = $database->getConnection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch counts for history and notifications
        $query_history = "SELECT COUNT(*) AS history_count FROM PEMINJAMAN";
        $result_history = mysqli_query($conn, $query_history);
        $row_history = mysqli_fetch_assoc($result_history);

        // Query the database for notification count
        $query_notifications_count = "SELECT COUNT(*) AS notification_count FROM peminjaman p
                              JOIN DETAILPEMINJAMAN dp ON p.ID_PEMINJAMAN = dp.ID_PEMINJAMAN
                              WHERE p.ID_MEMBER = ? AND p.TANGGAL_PENGEMBALIAN >= CURDATE()";

        $stmt_notifications_count = mysqli_prepare($conn, $query_notifications_count);

        if ($stmt_notifications_count) {
            mysqli_stmt_bind_param($stmt_notifications_count, "s", $userID);
            mysqli_stmt_execute($stmt_notifications_count);

            $result_notifications_count = mysqli_stmt_get_result($stmt_notifications_count);
            $row_notifications_count = mysqli_fetch_assoc($result_notifications_count);

            $notificationCount = $row_notifications_count['notification_count'];

            // Close the statement
            mysqli_stmt_close($stmt_notifications_count);
        } else {
            echo "Error in the query: " . mysqli_error($conn);
        }

        ?>
        <main class="col-md-9 col-lg-12 px-md-4 m=0 ms-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <h5<i class="fa-solid fa-clover fa-2x" aria-hidden="true"></i></h5>
            </div>
            <div class="row">
                <div class="col-sm-3 m-auto">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5><?= $row_history['history_count'] ?></h5>
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
                            <h5><?= $notificationCount ?></h5>
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