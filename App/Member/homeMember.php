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
$query_history = "SELECT COUNT(*) AS history_count 
                  FROM PEMINJAMAN AS p
                  JOIN member AS m ON p.ID_MEMBER = m.ID_MEMBER
                  WHERE p.ID_MEMBER = ?";
$stmt_history = mysqli_prepare($conn, $query_history);

// Check if the statement was prepared successfully
if ($stmt_history) {
    // Bind the parameter
    mysqli_stmt_bind_param($stmt_history, "s", $userID);

    // Execute the query
    mysqli_stmt_execute($stmt_history);

    // Get the result set
    $result_history = mysqli_stmt_get_result($stmt_history);
    
    // Fetch the row
    $row_history = mysqli_fetch_assoc($result_history);

    // Close the statement
    mysqli_stmt_close($stmt_history);
} else {
    // Handle the error if the statement was not prepared successfully
    echo "Error in preparing statement for history: " . mysqli_error($conn);
}

// Fetch counts for notifications
$query_notifications = "SELECT COUNT(*) AS notification_count 
                        FROM BUKU AS b
                        JOIN DETAILPEMINJAMAN AS dp ON b.ID_BUKU = dp.ID_BUKU
                        JOIN PEMINJAMAN AS p ON dp.ID_PEMINJAMAN = p.ID_PEMINJAMAN
                        JOIN member AS m ON p.ID_MEMBER = m.ID_MEMBER
                        WHERE p.ID_MEMBER = ?";
$stmt_notifications = mysqli_prepare($conn, $query_notifications);

// Check if the statement was prepared successfully
if ($stmt_notifications) {
    // Bind the parameter
    mysqli_stmt_bind_param($stmt_notifications, "s", $userID);

    // Execute the query
    mysqli_stmt_execute($stmt_notifications);

    // Get the result set
    $result_notifications = mysqli_stmt_get_result($stmt_notifications);
    
    // Fetch the row
    $row_notifications = mysqli_fetch_assoc($result_notifications);

    // Close the statement
    mysqli_stmt_close($stmt_notifications);
} else {
    // Handle the error if the statement was not prepared successfully
    echo "Error in preparing statement for notifications: " . mysqli_error($conn);
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
                            <h5><?= $row_notifications['notification_count'] ?></h5>
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
                                    $query = "SELECT p.*, b.JUDUL_BUKU FROM peminjaman p
                                    JOIN DETAILPEMINJAMAN dp ON p.ID_PEMINJAMAN = dp.ID_PEMINJAMAN
                                    JOIN BUKU b ON dp.ID_BUKU = b.ID_BUKU
                                    WHERE p.ID_MEMBER = ?";
                                    $stmt = mysqli_prepare($conn, $query);

                                    // Check if the statement was prepared successfully
                                    if ($stmt) {
                                        // Bind the parameter
                                        mysqli_stmt_bind_param($stmt, "s", $userID);

                                        // Execute the query
                                        mysqli_stmt_execute($stmt);

                                        // Get the result set
                                        $result = mysqli_stmt_get_result($stmt);

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
                                        }

                                        // Close the statement
                                        mysqli_stmt_close($stmt);
                                    } else {
                                        // Handle the error if the statement was not prepared successfully
                                        echo "Error in preparing statement: " . mysqli_error($conn);
                                    }
                                    ?>

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