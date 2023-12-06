<div class="container-fluid">
    <div class="row">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <?php
        include 'App/Admin/menu.php';
        include 'Functions/pesan_kilat.php';
        $db = new Database();
        $conn = $db->getConnection();
        require 'Functions/Book.php';
        $book = new Book($conn);
        $add = $book->addBookFromForm();

        $delete = $book->hapusBukuFromForm();

        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Buku</h1>
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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Ketersediaan</th>
                                <th scope="col">Tanggal Pengadaan</th>
                                <th scope="col">Tahun Terbit</th>
                                <th scope="col">Penerbit</th>
                                <th scope="col">Rak</th>
                                <th scope="col">Img</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT * FROM buku";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr id="<?= $row['ID_BUKU'] ?>">
                                    <th scope="row"><?= $no++ ?></th>
                                    <td data-target="judul_buku"><?= $row['JUDUL_BUKU'] ?></td>
                                    <td data-target="deskripsi"><?= $row['DESKRIPSI'] ?></td>
                                    <td data-target="ketersediaan"><?= $row['KETERSEDIAAN'] ?></td>
                                    <td data-target="tanggal_pengadaan"><?= $row['TANGGAL_PENGADAAN'] ?></td>
                                    <td data-target="tahun_terbit"><?= date('Y', strtotime($row['TAHUN_TERBIT'])) ?></td>
                                    <td data-target="penerbit"><?= $row['PENERBIT'] ?></td>
                                    <td data-target="rak"><?= $row['RAK'] ?></td>
                                    <td data-target="img"><?= $row['IMG'] ?></td>
                                    <td data-target="status_buku"><?= $row['STATUS_BUKU'] ?></td>
                                    <td>
                                        <a href="#" data-role="update" data-id="<?= $row['ID_BUKU']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i>Edit</a>
                                        <a href="index.php?page=buku&idBuku=<?= $row['ID_BUKU'] ?>" onclick="javascript:return confirm('Hapus Data Buku?');" class="btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i>Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm " role="document">
                        <div class="modal-content h-100 ">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Buku</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post" class="vh-100" style="padding-bottom: 10rem;">
                                <div class="modal-body overflow-y-scroll h-100 ">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Judul :</label>
                                        <input type="text" name="judul_buku" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Deskripsi :</label>
                                        <input type="text" name="deskripsi" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Ketersediaan :</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="ketersediaan" value="Tersedia">
                                            <label class="form-check-label" for="tersedia">Tersedia</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="ketersediaan" value="Tidak Tersedia">
                                            <label class="form-check-label" for="tidak-tersedia">Tidak Tersedia</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Tanggal Pengadaan:</label>
                                        <input type="date" name="tanggal_pengadaan" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Tahun Penerbit:</label>
                                        <input type="text" name="tahun_penerbit" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Penerbit :</label>
                                        <input type="text" name="penerbit" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Rak :</label>
                                        <input type="text" name="rak" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Image :</label>
                                        <input type="text" name="img" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Status :</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="status_buku" value="Rusak">
                                            <label class="form-check-label" for="inlineRadio1">Rusak</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="status_buku" value="Bagus">
                                            <label class="form-check-label" for="inlineRadio2">Bagus</label>
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
                <div id="myModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-book"></i> Edit Buku</h5>
                                <button type="button" class="btn-close-style " data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div class="modal-body custom-modal-body">
                                <div class="mb-3 row form-group">
                                    <label for="judul_buku" class="col-sm-3 col-form-label">Judul Buku</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="judul_buku1" name="judul_buku1">
                                    </div>
                                </div>
                                <div class="mb-3 row form-group">
                                    <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="deskripsi1" name="deskripsi1">
                                    </div>
                                </div>
                                <div class="mb-3 row form-group">
                                    <label for="ketersediaan" class="col-sm-3 col-form-label">Ketersediaan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="ketersediaan1" name="ketersediaan1">
                                    </div>
                                </div>
                                <div class="mb-3 row form-group">
                                    <label for="tanggal_pengadaan" class="col-sm-3 col-form-label">Tanggal Pengadaann</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="tanggal_pengadaan1" name="tanggal_pengadaan1">
                                    </div>
                                </div>
                                <div class="mb-3 row form-group">
                                    <label for="tahun_terbit" class="col-sm-3 col-form-label">Tahun Terbit</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="tahun_terbit1" name="tahun_terbit1">
                                    </div>
                                </div>
                                <div class="mb-3 row form-group">
                                    <label for="penerbit" class="col-sm-3 col-form-label">Penerbit</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="penerbit1" name="penerbit1">
                                    </div>
                                </div>
                                <div class="mb-3 row form-group">
                                    <label for="rak" class="col-sm-3 col-form-label">Rak</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="rak1" name="rak1">
                                    </div>
                                </div>
                                <div class="mb-3 row form-group">
                                    <label for="img" class="col-sm-3 col-form-label">Img</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="img1" name="img1">
                                    </div>
                                </div>
                                <div class="mb-3 row form-group">
                                    <label for="judul_buku" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="status_buku1" name="status_buku1">
                                    </div>
                                </div>
                                <input type="hidden" id="bookId" class="form-control">

                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-primary" onclick="resetData()">Reset</button>
                                <a href="#" id="save" name="save" class="btn btn-success">Save Changes</a>
                                <!-- <button href="#" type="submit1" id="save" name="save" class="btn btn-success">Save Changes</button> -->

                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $(document).on('click', 'a[data-role=update]', function() {
                            var id = $(this).data('id');
                            var judul_buku = $('#' + id).find('td[data-target=judul_buku]').text();
                            var deskripsi = $('#' + id).find('td[data-target=deskripsi]').text();
                            var ketersediaan = $('#' + id).find('td[data-target=ketersediaan]').text();
                            var tanggal_pengadaan = $('#' + id).find('td[data-target=tanggal_pengadaan]').text();
                            var tahun_terbit = $('#' + id).find('td[data-target=tahun_terbit]').text();
                            var penerbit = $('#' + id).find('td[data-target=penerbit]').text();
                            var rak = $('#' + id).find('td[data-target=rak]').text();
                            var img = $('#' + id).find('td[data-target=img]').text();
                            var status_buku = $('#' + id).find('td[data-target=status]').text();

                            $('#judul_buku1').val(judul_buku);
                            $('#deskripsi1').val(deskripsi);
                            $('#ketersediaan1').val(ketersediaan);
                            $('#tanggal_pengadaan1').val(tanggal_pengadaan);
                            $('#tahun_terbit1').val(tahun_terbit);
                            $('#penerbit1').val(penerbit);
                            $('#rak1').val(rak);
                            $('#img1').val(img);
                            $('#status_buku1').val(status_buku);
                            $('#bookId').val(id);
                            $('#myModal').modal('show');
                        });

                        $('#save').click(function() {
                            var id = $('#bookId').val();
                            var judul_buku = $('#judul_buku1').val();
                            var deskripsi = $('#deskripsi1').val();
                            var ketersediaan = $('#ketersediaan1').val();
                            var tanggal_pengadaan = $('#tanggal_pengadaan1').val();
                            var tahun_terbit = $('#tahun_terbit1').val();
                            var penerbit = $('#penerbit1').val();
                            var rak = $('#rak1').val();
                            var img = $('#img1').val();
                            var status_buku = $('#status_buku1').val();

                            $.ajax({
                                url: 'Functions/Book.php',
                                method: 'post',
                                data: {
                                    judul_buku: judul_buku,
                                    deskripsi: deskripsi,
                                    ketersediaan: ketersediaan,
                                    tanggal_pengadaan: tanggal_pengadaan,
                                    tahun_terbit: tahun_terbit,
                                    penerbit: penerbit,
                                    rak: rak,
                                    img: img,
                                    status_buku: status_buku,
                                    bookId: id // Include the bookId in the data

                                },
                                success: function(response) {
                                    $('#' + id).children('td[data-target=judul_buku]').text(judul_buku);
                                    $('#' + id).children('td[data-target=deskripsi]').text(deskripsi);
                                    $('#' + id).children('td[data-target=tanggal_pengadaan]').text(tanggal_pengadaan);
                                    $('#' + id).children('td[data-target=tahun_terbit]').text(tahun_terbit);
                                    $('#' + id).children('td[data-target=penerbit]').text(penerbit);
                                    $('#' + id).children('td[data-target=rak]').text(rak);
                                    $('#' + id).children('td[data-target=img]').text(img);
                                    $('#myModal').modal('hide');
                                }
                            });
                        });
                    });
                </script>


            </div>
        </main>
    </div>
</div>