<div class="container-fluid">
    <div class="row">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <?php

        include 'Functions/pesan_kilat.php';
        $db = new Database();
        $conn = $db->getConnection();
        require 'Functions/Penulis.php';
        $penulis = new Penulis($conn);
        $add = $penulis->addPenulisFromForm();
        $delete = $penulis->hapusPenulisFromForm();
        $edit = $penulis->editPenulisFromForm();

        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Penulis</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                    <i class="fa fa-plus"></i> Tambah Data
                </button>
            </div>
            <div class="row">
                <div class="col-lg-2">

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
                            $query = "SELECT * FROM penulis order by id_penulis asc";
                            // $result = mysqli_query($conn, $query);
                            $result = mysqli_query($conn, $query);
                            if (!$result) {
                                die("Query error: " . mysqli_error($conn));
                            }
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr id="<?= $row['ID_PENULIS'] ?>">
                                    <!-- <th scope="row"><?= $no++ ?></th> -->
                                    <td><?= $row['ID_PENULIS'] ?></td>
                                    <td><?= $row['NAMA_PENULIS'] ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#myModal<?= $row['ID_PENULIS']; ?>" class="btn btn-warning btn-xs m-1"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href="index.php?page=penulis&idPenulis=<?= $row['ID_PENULIS'] ?>" onclick="javascript:return confirm('Hapus Data Penulis?');" class="btn btn-danger btn-xs m-1"><i class="fa fa-trash"></i></a>
                                        </div>
                                        <div id="myModal<?= $row['ID_PENULIS'] ?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="myModalLabel<?= $row['ID_PENULIS'] ?>" aria-hidden="true" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel"><i class="fa fa-users"></i> Edit Data Penulis</h5>
                                                        <button type="button" class="btn-close-style " data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                    <form action="index.php?page=penulis" method="post">
                                                        <div class="modal-body custom-modal-body">
                                                            <div class="mb-3 row form-group">
                                                                <label for="judul_buku" class="col-sm-3 col-form-label">ID Penulis</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" id="id_penulis1" name="id_penulis1" value="<?= $row['ID_PENULIS'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row form-group">
                                                                <label for="judul_buku" class="col-sm-3 col-form-label">Nama Penulis</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" id="namapenulis1" name="namapenulis1" value="<?= $row['NAMA_PENULIS'] ?>">
                                                                </div>
                                                            </div>
                                                            <!-- <input type="hidden" id="penulisId" class="form-control"> -->

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="reset" class="btn btn-primary" onclick="resetData()">Reset</button>
                                                            <button type="submit" name="update" class="btn btn-success">Save Changes</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>


                <div id="exampleModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-users"></i> Tambah Penulis</h5>
                                <button type="button" class="btn-close-style " data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <form action="" method="post">
                                <div class="modal-body custom-modal-body">
                                    <div class="mb-3 row form-group">
                                        <label for="judul_buku" class="col-sm-3 col-form-label">ID Penulis</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="id_penulis" class="form-control" id="id_penulis">
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">
                                        <label for="judul_buku" class="col-sm-3 col-form-label">Nama Penulis</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="namapenulis" class="form-control" id="namapenulis">
                                        </div>
                                    </div>
                                    <input type="hidden" id="penulisId" class="form-control">

                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-primary" onclick="resetData()">Reset</button>
                                    <button type="submit" name="submit" class="btn btn-success ms-2" aria-hidden="true"><i class="fa fa-floppy-o"></i> Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>