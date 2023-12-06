<div class="container-fluid">
    <div class="row">
        <?php
        include 'Functions/pesan_kilat.php';
        $db = new Database();
        $conn = $db->getConnection();
        require 'Functions/Kategori.php';

        $kategori = new Kategori($conn);

        $add = $kategori->addKategoriFromForm();
        $edit = $kategori->editKategoriFromForm();
        $hapus = $kategori->deleteKategoriFromForm();

        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kategori</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-bs-whatever="@mdo">
                    <i class="fa fa-plus"></i> Tambah Kategori
                </button>
            </div>
            <div class="row">
                <div class="col-lg-2">

                </div>
                <?php
                // Sesuaikan logika PHP yang diperlukan untuk menampilkan pesan kesalahan atau sukses, jika ada
                if(isset($_SESSION['_flashdata'])) {
                    echo "<br>";
                    foreach($_SESSION['_flashdata'] as $key => $val) {
                        echo get_flashdata($key);
                    }
                }
                ?>

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
                            $no = 1;
                            $query = "SELECT * FROM kategori order by ID_KATEGORI ASC";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <th scope="row">
                                        <?= $no++ ?>
                                    </th>
                                    <td>
                                        <?= $row['NAMA_KATEGORI'] ?>
                                    </td>
                                    <td>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#editModal<?= $row['ID_KATEGORI'] ?>"
                                            class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"
                                                aria-hidden="true"></i> Edit</a>
                                        <!-- Modal untuk mengedit data kategori -->
                                        <div class="modal fade" id="editModal<?= $row['ID_KATEGORI'] ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="editModalLabel<?= $row['ID_KATEGORI'] ?>"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Data Kategori
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="index.php?page=kategori" method="post">
                                                        <div class="modal-body overflow-y-scroll">
                                                            <!-- Input untuk ID Kategori yang akan diedit (disediakan dalam sebuah input tersembunyi) -->
                                                            <input type="hidden" name="ID_KATEGORI"
                                                                value="<?= $row['ID_KATEGORI'] ?>">
                                                            <div class="mb-3">
                                                                <label for="editNamaKategori" class="col-form-label">Nama
                                                                    Kategori Baru:</label>
                                                                <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                <input type="text" name="NAMA_KATEGORI" class="form-control"
                                                                    id="editNamaKategori"
                                                                    value="<?= $row['NAMA_KATEGORI'] ?>">
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

                                        <a href="index.php?page=kategori&delete_id=<?= $row['ID_KATEGORI'] ?>"
                                            onclick="return confirm('Hapus Data kategori?');" class="btn btn-danger btn-xs">
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
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Kategori</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="" method="post">

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nama Kategori:</label>
                                        <input type="text" name="nama_kategori" class="form-control"
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
<div class="modal fade" id="deleteModal<?= $row['ID_KATEGORI'] ?>" tabindex="-1"
    aria-labelledby="deleteModalLabel<?= $row['ID_KATEGORI'] ?>" aria-hidden="true">
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


</div>
</main>
</div>
</div>