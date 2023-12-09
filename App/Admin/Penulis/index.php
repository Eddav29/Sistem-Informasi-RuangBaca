<div class="container-fluid">
    <div class="row">
        <?php
        include 'Functions/pesan_kilat.php';
        $db = new Database();
        $conn = $db->getConnection();
        require 'Functions/Penulis.php';

        $penulis = new Penulis($conn);

        $add = $penulis->addPenulisFromForm();
        $edit = $penulis->editPenulisFromForm();
        $hapus = $penulis->deletePenulisFromForm();

        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="text-dark">Penulis</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-bs-whatever="@mdo">
                    <i class="fa fa-plus"></i> Tambah Penulis
                </button>
            </div>
            <div class="row">
                <div class="col-lg-2">

                </div>
                <?php
                // Sesuaikan logika PHP yang diperlukan untuk menampilkan pesan kesalahan atau sukses, jika ada
                if (isset($_SESSION['_flashdata'])) {
                    echo "<br>";
                    foreach ($_SESSION['_flashdata'] as $key => $val) {
                        echo get_flashdata($key);
                    }
                }
                ?>

                <div class="table-responsive small">
                    <table class="table table-striped table-data">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama Penulis</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT * FROM penulis order by ID_PENULIS ASC";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <th scope="row">
                                        <?= $no++ ?>
                                    </th>
                                    <td>
                                        <?= $row['NAMA_PENULIS'] ?>
                                    </td>
                                    <td>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#editModal<?= $row['ID_PENULIS'] ?>"
                                            class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"
                                                aria-hidden="true"></i> Edit</a>
                                        <!-- Modal untuk mengedit data kategori -->
                                        <div class="modal fade" id="editModal<?= $row['ID_PENULIS'] ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="editModalLabel<?= $row['ID_PENULIS'] ?>"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Data Penulis
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="index.php?page=penulis" method="post">
                                                        <div class="modal-body overflow-y-scroll">
                                                            <!-- Input untuk ID Kategori yang akan diedit (disediakan dalam sebuah input tersembunyi) -->
                                                            <input type="hidden" name="ID_PENULIS"
                                                                value="<?= $row['ID_PENULIS'] ?>">
                                                            <div class="mb-3">
                                                                <label for="editNamaPenulis" class="col-form-label">Nama
                                                                    Penulis Baru:</label>
                                                                <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                <input type="text" name="NAMA_PENULIS" class="form-control"
                                                                    id="editNamaPenulis"
                                                                    value="<?= $row['NAMA_PENULIS'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" name="update"
                                                                class="btn btn-primary">Simpan Perubahan</button>
                                                        </div>
                                                    </form>


                                                </div>
                                            </div>
                                        </div>

                                        <a href="index.php?page=penulis&delete_id=<?= $row['ID_PENULIS'] ?>"
                                            onclick="return confirm('Hapus Data penulis?');" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>


                <!-- Modal untuk menambahkan kategori baru -->

                <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Penulis</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="" method="post">
                                <form action="indexKategori.php" method="POST">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">Nama Penulis:</label>
                                            <input type="text" name="nama_penulis" class="form-control"
                                                id="recipient-name">
                                        </div>
                                        <div class="mb-3 d-flex justify-content-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                aria-hidden="true"><i class="fa fa-times"></i> Close</button>
                                            <button type="submit" name="submit" class="btn btn-primary ms-2"
                                                aria-hidden="true"><i class="fa fa-floppy-o"></i> Simpan</button>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>


            </div>
        </main>
    </div>
</div>


<!-- Modal untuk Hapus -->
<div class="modal fade" id="deleteModal<?= $row['ID_PENULIS'] ?>" tabindex="-1"
    aria-labelledby="deleteModalLabel<?= $row['ID_PENULIS'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel<?= $row['ID_PENULIS'] ?>">Hapus Data Penulis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <form action="index.php?page=penulis" method="post">
                    <input type="hidden" name="ID_PENULIS" value="<?= $row['ID_PENULIS'] ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>