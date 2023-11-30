<div class="container-fluid">
    <div class="row">

        <?php


        include 'App/Admin/menu.php';
        $db = new Database();
        $conn = $db->getConnection();
        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Buku</h1>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-bs-whatever="@mdo">
                        <i class="fa fa-plus"></i>Tambah Buku
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
                                <th scope="col">Judul</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Ketersediaan</th>
                                <th scope="col">Tanggal Pengadaan</th>
                                <th scope="col">Tahun Terbit</th>
                                <th scope="col">Penerbit</th>
                                <th scope="col">Rak</th>
                                <th scope="col">Img</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT * FROM buku order by id_buku desc";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <th scope="row">
                                        <?= $no++ ?>
                                    </th>
                                    <td>
                                        <?= $row['JUDUL_BUKU'] ?>
                                    </td>
                                    <td>
                                        <?= $row['DESKRIPSI'] ?>
                                    </td>
                                    <td>
                                        <?= $row['KETERSEDIAAN'] ?>
                                    </td>
                                    <td>
                                        <?= $row['TANGGAL_PENGADAAN'] ?>
                                    </td>
                                    <td>
                                        <?= $row['TAHUN_TERBIT'] ?>
                                    </td>
                                    <td>
                                        <?= $row['PENERBIT'] ?>
                                    </td>
                                    <td>
                                        <?= $row['RAK'] ?>
                                    </td>
                                    <td>
                                        <?= $row['IMG'] ?>
                                    </td>
                                    <td>
                                        <?= $row['STATUS_BUKU'] ?>
                                    </td>
                                    <td>
                                        <a href="index.php?page=buku/edit&id=<?= $row['id'] ?>"
                                            class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i>Edit</a>
                                        <a href="fungsi/hapus.php?buku=hapus&id=<?= $row['id'] ?>"
                                            onclick="javascript:return confirm('Hapus Data Buku?');"
                                            class="btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i>Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Buku</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                if (isset($_POST['submit'])) {
                                    include 'insert_function.php';
                                    insertData(
                                        $_POST['judul_buku'],
                                        $_POST['deskripsi'],
                                        $_POST['ketersediaan'],
                                        $_POST['tanggal_pengadaan'],
                                        $_POST['tahun_penerbit'],
                                        $_POST['penerbit'],
                                        $_POST['rak'],
                                        $_POST['img'],
                                        $_POST['status'],
                                    );
                                }
                            }
                            ?>
                     
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
                                            <input type="radio" class="form-check-input" name="ketersediaan"
                                                value="Tersedia">
                                            <label class="form-check-label" for="inlineRadio1">Tersedia</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="ketersediaan"
                                                value="Tidak Tersedia">
                                            <label class="form-check-label" for="inlineRadio2">Tidak Tersedia</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Tanggal Pengadaan:</label>
                                        <input type="date" name="tanggal_pengadaan" class="form-control"
                                            id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Tahun Penerbit:</label>
                                        <input type="year" name="tahun_penerbit" class="form-control"
                                            id="recipient-name">
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
                                            <input type="radio" class="form-check-input" name="status_buku"
                                                value="Rusak">
                                            <label class="form-check-label" for="inlineRadio1">Rusak</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="status_buku"
                                                value="Bagus">
                                            <label class="form-check-label" for="inlineRadio2">Bagus</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                            aria-hidden="true"><i class="fa fa-times"></i> Close</button>
                                        <button type="submit" name="submit" class="btn btn-primary ms-2"
                                            aria-hidden="true"><i class="fa fa-floppy-o"></i> Simpan</button>
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