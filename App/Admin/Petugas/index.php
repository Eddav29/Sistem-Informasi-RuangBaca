<div class="container-fluid">
    <div class="row">
        <?php
        include 'Functions/pesan_kilat.php';
        $db = new Database();
        $conn = $db->getConnection();
        require 'Functions/Petugas.php';

        $petugas = new Petugas($conn);

        $add = $petugas->addPetugasFromForm();
        $edit = $petugas->editPetugasFromForm();
        $hapus = $petugas->deletePetugasFromForm();

        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Petugas</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-bs-whatever="@mdo">
                    <i class="fa fa-plus"></i> Tambah Petugas
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
                    <table class="table table-striped">
                        <thead>
                        <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jenis Identitas</th>
                                <th scope="col">Nomor Identitas</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Level</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT * FROM member order by ID_MEMBER ASC";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <th scope="row">
                                        <?= $no++ ?>
                                    </th>
                                    <th scope="row"><?= $no++ ?></th>
                                    <td><?= $row['USERNAME_MEMBER'] ?></td>
                                    <td><?= $row['PASSWORD_MEMBER'] ?></td>
                                    <td><?= $row['NAMA_MEMBER'] ?></td>
                                    <td><?= $row['JENIS_IDENTITAS'] ?></td>
                                    <td><?= $row['NOMOR_IDENTITAS'] ?></td>
                                    <td><?= $row['ALAMAT'] ?></td>
                                    <td><?= $row['level'] ?></td>
                                    <td>
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#editModal<?= $row['ID_MEMBER'] ?>"
                                            class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"
                                                aria-hidden="true"></i> Edit</a>

                                        <!-- Modal untuk mengedit data petugas -->
                                        <div class="modal fade" id="editModal<?= $row['ID_MEMBER'] ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="editModalLabel<?= $row['ID_MEMBER'] ?>"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Data Petugas
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="index.php?page=petugas" method="post" class="overflow-y-scroll ">
                                                        <div class="modal-body overflow-y-scroll">
                                                            <!-- Input untuk ID Kategori yang akan diedit (disediakan dalam sebuah input tersembunyi) -->
                                                            <input type="hidden" name="ID_MEMBER"
                                                                value="<?= $row['ID_MEMBER'] ?>">
                                                            <div class="mb-3">
                                                                <label for="editUsernameMember" class="col-form-label">Username
                                                                    Petugas Baru:</label>
                                                                <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                <input type="text" name="USERNAME_MEMBER" class="form-control"
                                                                    id="editUsernameMember"
                                                                    value="<?= $row['USERNAME_MEMBER'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editPasswordMember" class="col-form-label">Password
                                                                    Petugas Baru:</label>
                                                                <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                <input type="text" name="PASSWORD_MEMBER" class="form-control"
                                                                    id="editPasswordMember"
                                                                    value="<?= $row['PASSWORD_MEMBER'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editNamaMember" class="col-form-label">Nama
                                                                    Petugas Baru:</label>
                                                                <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                <input type="text" name="NAMA_MEMBER" class="form-control"
                                                                    id="editNamaMember"
                                                                    value="<?= $row['NAMA_MEMBER'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editJenisIdentitasMember" class="col-form-label">Jenis Identitas
                                                                    Petugas Baru:</label>
                                                                <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                <input type="text" name="JENIS_IDENTITAS" class="form-control"
                                                                    id="editJenisIdentitasMember"
                                                                    value="<?= $row['JENIS_IDENTITAS'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editNomorIdentitasMember" class="col-form-label">Nomor Identitas
                                                                    Petugas Baru:</label>
                                                                <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                <input type="text" name="NOMOR_IDENTITAS" class="form-control"
                                                                    id="editNomorIdentitasMember"
                                                                    value="<?= $row['NOMOR_IDENTITAS'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editAlamatMember" class="col-form-label">Alamat
                                                                    Petugas Baru:</label>
                                                                <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                <input type="text" name="ALAMAT" class="form-control"
                                                                    id="editAlamatMember"
                                                                    value="<?= $row['ALAMAT'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editLevelMember" class="col-form-label">Level
                                                                    Petugas Baru:</label>
                                                                <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                <input type="text" name="level" class="form-control"
                                                                    id="editLevelMember"
                                                                    value="<?= $row['level'] ?>">
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

                                        <a href="index.php?page=petugas&delete_id=<?= $row['ID_MEMBER'] ?>"
                                            onclick="return confirm('Hapus Data petugas?');" class="btn btn-danger btn-xs">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>


                <!-- Modal untuk menambahkan petugas baru -->

                <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Petugas</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="" method="post" class="overflow-y-scroll ">

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Username :</label>
                                        <input type="text" name="username_petugas" class="form-control"
                                            id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Password :</label>
                                        <input type="text" name="password_petugas" class="form-control"
                                            id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nama :</label>
                                        <input type="text" name="nama_petugas" class="form-control"
                                            id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Jenis Identitas :</label>
                                        <input type="text" name="jenis_identitas" class="form-control"
                                            id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nomor Identitas :</label>
                                        <input type="text" name="nomor_identitas" class="form-control"
                                            id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Alamat :</label>
                                        <input type="text" name="alamat" class="form-control"
                                            id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Level :</label>
                                        <input type="text" name="level" class="form-control"
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
<div class="modal fade" id="deleteModal<?= $row['ID_MEMEBER'] ?>" tabindex="-1"
    aria-labelledby="deleteModalLabel<?= $row['ID_MEMBER'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel<?= $row['ID_MEMBER'] ?>">Hapus Data Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <form action="index.php?page=petugas" method="post">
                    <input type="hidden" name="ID_MEMBER" value="<?= $row['ID_MEMBER'] ?>">
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