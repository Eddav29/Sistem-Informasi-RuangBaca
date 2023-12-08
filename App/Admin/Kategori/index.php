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
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Kategori</h1>
            </div>

            <!-- Tampilan Tabel Kategori -->
            <div class="row">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-bs-whatever="@mdo">
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
                                            <a href="#" data-role="update" data-id="<?= $row_kategori['ID_KATEGORI']; ?>"
                                                class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i>Edit</a>

                                            <a href='index.php?page=kategori&id=<?= $row_kategori["ID_KATEGORI"] ?>'
                                                onclick="javascript:return confirm('Hapus Data Kategori?');"
                                                class="btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i>Hapus</a>
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
                                        <!-- ... Form Tambah Kategori ... -->
                                        <form action="indexKategori.php" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label">Nama Kategori
                                                        :</label>
                                                    <input type="text" name="nama_kategori" class="form-control"
                                                        id="recipient-name">
                                                </div>
                                                <div class="mb-3 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal" aria-hidden="true"><i
                                                            class="fa fa-times"></i> Close</button>
                                                    <button type="submit" name="submit" class="btn btn-primary ms-2"
                                                        aria-hidden="true"><i class="fa fa-floppy-o"></i>
                                                        Simpan</button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                        </div>


                    </div>
                </div>
            </div>



            <!-- Modal Edit Kategori -->
            <div id="myModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-book"></i> Edit Kategori
                            </h5>
                            <button type="button" class="btn-close-style " data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <div class="mb-3 row form-group">
                                <label for="nama_kategori" class="col-sm-3 col-form-label">Nama Kategori</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" class="form-control" id="id_kategori" name="id_kategori">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-primary" onclick="resetData()">Reset</button>
                            <button type="button" class="btn btn-success" id="save">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    $(document).on('click', 'a[data-role=update]', function () {
                        var id_kategori = $(this).data('id_kategori');
                        var nama_kategori = $('#' + id_kategori).find('td[data-target=nama_kategori]').text();

                        $('#NAMA_KATEGORI').val(nama_kategori);
                        $('#ID_KATEGORI').val(id_kategori);
                        $('#myModal').modal('show');
                    });

                    $('#save').click(function () {
                        var id_kategori = $('#ID_KATEGORI').val();
                        var nama_kategori = $('#NAMA_KATEGORI').val();

                        $.ajax({
                            url: 'Functions/Kategori.php',
                            method: 'post',
                            data: {
                                id_kategori: id_kategori,
                                nama_kategori: nama_kategori,
                                update: 'update_kategori'
                            },
                            success: function (response) {
                                $('#' + id_kategori).children('td[data-target=nama_kategori]').text(nama_kategori);
                                $('#myModal').modal('hide');
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    });
                });
            </script>




    </div>
    </main>
</div>
</div>