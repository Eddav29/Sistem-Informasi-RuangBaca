<div class="container-fluid">
    <div class="row">
        <?php
        include 'Functions/pesan_kilat.php';
        $db = new Database();
        $conn = $db->getConnection();
        require 'Functions/Kategori.php';
        if (isset($_SESSION['_flashdata'])) {
            echo "<br>";
            foreach ($_SESSION['_flashdata'] as $key => $val) {
                echo get_flashdata($key);
            }
        }


        $kategori = new Kategori($conn);

        $add = $kategori->addKategoriFromForm();
        $edit = $kategori->editKategoriFromForm();
        $hapus = $kategori->deleteKategoriFromForm();

        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kategori</h1>
            </div>

            <!-- Tampilan Tabel Kategori -->
            <div class="row">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                        <i class="fa fa-plus"></i>Tambah Kategori
                    </button>
                </div>

                <!-- ... Bagian PHP Tambah Kategori ... -->

                <div class="table-responsive small">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama Kategori</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_kategori = "SELECT * FROM KATEGORI";
                            $result_kategori = $conn->query($sql_kategori);

                            if ($result_kategori->num_rows > 0) {
                                while ($row_kategori = $result_kategori->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <th scope="row">
                                            <?= $row_kategori["ID_KATEGORI"] ?>
                                        </th>
                                        <td>
                                            <?= $row_kategori["NAMA_KATEGORI"] ?>
                                        </td>
                                        <td>
                                            <a href='indexKategori.php?action=edit&id=<?= $row_kategori["ID_KATEGORI"] ?>' class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i>Edit</a>
                                            <a href='indexKategori.php?action=hapus&id=<?= $row_kategori["ID_KATEGORI"] ?>' onclick="javascript:return confirm('Hapus Data Kategori?');" class="btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i>Hapus</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal Tambah Kategori -->
                <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Kategori</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post">

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nama Kategori:</label>

                                        <!-- ... Form Tambah Kategori ... -->
                                        <form action="indexKategori.php" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Nama Kategori
                                                        :</label>
                                                    <input type="text" name="nama_kategori" class="form-control" id="recipient-name">
                                                </div>
                                                <div class="mb-3 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Close</button>
                                                    <button type="submit" name="submit" class="btn btn-primary ms-2" aria-hidden="true"><i class="fa fa-floppy-o"></i>
                                                        Simpan</button>
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
<div class="modal fade" id="deleteModal<?= $row['ID_KATEGORI'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $row['ID_KATEGORI'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel<?= $row['ID_KATEGORI'] ?>">Hapus Data Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <form action="index.php?page=kategori" method="post">
                    <input type="hidden" name="ID_KATEGORI" value="<?= $row['ID_KATEGORI'] ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>