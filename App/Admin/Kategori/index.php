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
                    <i class="fa fa-plus"></i>Tambah Kategori
                </button>
            </div>

            <!-- Tampilan Tabel Kategori -->
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
                                <th scope="col">Nama Kategori</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT * FROM kategori order by ID_KATEGORI ASC";
                            $result = mysqli_query($conn, $query);
                            while ($row_kategori = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr>
                                    <th scope="row">
                                        <?= $row_kategori["ID_KATEGORI"] ?>
                                    </th>
                                    <td>
                                        <?= $row_kategori["NAMA_KATEGORI"] ?>
                                    </td>
                                    <td>
                                        <div class="d-flex ">
                                            <a href="#" data-bs-toggle="modal" data-role="update"
                                                data-bs-target="#editModal<?= $row_kategori['ID_KATEGORI'] ?>"
                                                class="btn btn-warning btn-xs">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                            </a>
                                            <a href="index.php?page=kategori&id=<?= $row_kategori['ID_KATEGORI'] ?>"
                                                onclick="javascript:return confirm('Hapus Data Kategori?');"
                                                class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                            <!-- Modal Edit Kategori-->
                                            <div class="modal fade" id="editModal<?= $row_kategori['ID_KATEGORI'] ?>"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="editModalLabel<?= $row_kategori['ID_KATEGORI'] ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">
                                                                <i class="fa-solid fa-list"></i> Edit Kategori
                                                            </h5>
                                                            <button type="button" class="btn-close-style"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                        <form action="index.php?page=kategori" method="post">
                                                            <div class="modal-body overflow-y-scroll">
                                                                <!-- Input untuk ID Kategori yang akan diedit (disediakan dalam sebuah input tersembunyi) -->
                                                                <input type="hidden" name="ID_KATEGORI"
                                                                    value="<?= $row_kategori['ID_KATEGORI'] ?>">
                                                                <div class="mb-3">
                                                                    <label for="editnamaKategori"
                                                                        class="col-form-label">Nama
                                                                        Kategori Baru:</label>
                                                                    <!-- Input untuk Nama Kategori yang akan diedit -->
                                                                    <input type="text" name="NAMA_KATEGORI"
                                                                        class="form-control" id="editnamaKategori"
                                                                        value="<?= $row_kategori['NAMA_KATEGORI'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="reset" class="btn btn-primary"
                                                                    onclick="resetData()">Reset</button>

                                                                <button type="submit" name="update" class="btn btn-success"
                                                                    onclick="saveChanges(<?= $row_kategori['ID_KATEGORI'] ?>)">Save
                                                                    Changes</button>
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


                <!-- Modal Tambah Kategori -->
                <div id="exampleModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"
                    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel "><i class="fa-solid fa-list"></i> Tambah
                                    Kategori
                                </h5>
                                <button type="button" class="btn-close-style " data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <!-- ... Form Tambah Kategori ... -->
                            <form action="" method="post">

                                <div class="modal-body custom-modal-body">
                                    <div class="mb-3 row form-group">
                                        <label for="recipient-name" class="col-form-label">Nama Kategori:</label>
                                        <input type="text" name="nama_kategori" class="form-control"
                                            id="recipient-name">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-primary"
                                            onclick="resetData()">Reset</button>
                                        <button type="submit" name="submit" class="btn btn-success ms-2"
                                            aria-hidden="true"><i class="fa fa-floppy-o"></i> Submit</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>




        </main>
    </div>
</div>