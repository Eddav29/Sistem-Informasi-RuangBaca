<div class="container-fluid">
    <div class="row">
    
    <?php
       include "../menu.php";
       require "../../../Config/koneksi.php";
        $db = new Database();
        $conn = $db->getConnection();
        ?>  

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Petugas</h1>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                        <i class="fa fa-plus"></i>Tambah Petugas
                    </button>
                </div>

                <?php
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
                                <th scope="col">ID</th>
                                <th scope="col">Username Petugas</th>
                                <th scope="col">Password Petugas</th>
                                <th scope="col">Nama Petugas</th>
                                <th scope="col">Tanggal Pengadaan</th>
                                <th scope="col">Jenis Identitas</th>
                                <th scope="col">Nomor Identitas</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Level</th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT * FROM member m where m.level like 'admin' order by id_member desc" ;

                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        
                        ?>
                            <tr>
                                <th scope="row"><?= $no++ ?></th>
                                <td><?= $row['USERNAME_MEMBER'] ?></td>
                                <td><?= $row['PASSWORD_MEMBER'] ?></td>
                                <td><?= $row['NAMA_MEMBER'] ?></td>
                                <td><?= $row['JENIS_IDENTITAS'] ?></td>
                                <td><?= $row['NOMOR_IDENTITAS'] ?></td>
                                <td><?= $row['ALAMAT'] ?></td>
                                <td><?= $row['level'] ?></td>
                                <td>
                                    <a href="index.php?page=buku/edit&id=<?= $row['id'] ?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i>Edit</a>
                                    <a href="fungsi/hapus.php?buku=hapus&id=<?= $row['id'] ?>" onclick="javascript:return confirm('Hapus Data Buku?');" class="btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i>Hapus</a>
                                </td>
                            </tr>
                            <?php 
                            }
                        } else {
                            echo "Query tidak berhasil dieksekusi: " . mysqli_error($conn);
                        }
                        ?>
                        </tbody>

                    </table>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Petugas</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Username Petugas :</label>
                                        <input type="text" name="judul_buku" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Password Petugas :</label>
                                        <input type="text" name="deskripsi" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nama Petugas :</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="ketersediaan" value="Tersedia">
                                            <label class="form-check-label" for="inlineRadio1">Jenis Identitas :</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nomor Identitas :</label>
                                        <input type="date" name="tanggal_pengadaan" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Alamat :</label>
                                        <input type="year" name="tahun_penerbit" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Level :</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="status_buku" value="Rusak">
                                            <label class="form-check-label" for="inlineRadio1">Admin</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="status_buku" value="Bagus">
                                            <label class="form-check-label" for="inlineRadio2">Member</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Close</button>
                                        <button type="submit" name="submit" class="btn btn-primary ms-2" aria-hidden="true"><i class="fa fa-floppy-o"></i> Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
