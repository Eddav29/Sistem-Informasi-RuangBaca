<div class="container-fluid">
    <div class="row">
        <?php
        include 'App/Admin/menu.php';   
        $db = new Database();
        
        // Get the database connection
        $conn = $db->getConnection();
        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Penulis</h1>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                        <i class="fa fa-plus"></i>Tambah Penulis
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
                                <th scope="col">Id Penulis</th>
                                <th scope="col">Nama Penulis</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $no = 1;
                        $query = "SELECT * FROM penulis order by id_penulis desc";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <th scope="row"><?= $no++ ?></th>
                                <td><?= $row['NAMA_PENULIS'] ?></td>
                                <td>
                                    <a href="index.php?page=buku/edit&id=<?= $row['id'] ?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i>Edit</a>
                                    <a href="fungsi/hapus.php?buku=hapus&id=<?= $row['id'] ?>" onclick="javascript:return confirm('Hapus Data Buku?');" class="btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i>Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                        </div>

                
                <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Penulis</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post">
                                <div >
                                    <div class="mb-3 position">
                                        <label for="recipient-name" class="col-form-label">Nama Penulis :</label>
                                        <input type="text" name="judul_buku" class="form-control" id="recipient-name">
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

