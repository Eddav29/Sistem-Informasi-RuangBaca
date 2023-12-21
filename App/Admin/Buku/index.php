<div class="container-fluid">
    <div class="row">
        <?php
        include 'Functions/pesan_kilat.php';
        $db = new Database();
        $conn = $db->getConnection();
        require 'Functions/Book.php';
        $book = new Book($conn);
        $add = $book->addBookFromForm();
        $edit = $book->editBookFromForm();
        $delete = $book->hapusBukuFromForm();

        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Buku</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-bs-whatever="@mdo">
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
                            $query = "SELECT buku.*, GROUP_CONCAT(DISTINCT penulis.NAMA_PENULIS) AS NAMA_PENULIS, kategori.NAMA_KATEGORI 
                                        FROM buku
                                        LEFT JOIN detail_penulis_buku ON buku.ID_BUKU = detail_penulis_buku.ID_BUKU
                                        LEFT JOIN penulis ON detail_penulis_buku.ID_PENULIS = penulis.ID_PENULIS
                                        LEFT JOIN detail_kategori_buku ON buku.ID_BUKU = detail_kategori_buku.ID_BUKU
                                        LEFT JOIN kategori ON detail_kategori_buku.ID_KATEGORI = kategori.ID_KATEGORI
                                        GROUP BY buku.ID_BUKU";

                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <!-- <th scope="row"><?= $no++ ?></th> -->
                                    <td><?= $row['ID_BUKU'] ?></td>
                                    <td><?= $row['JUDUL_BUKU'] ?></td>
                                    <td><?= $row['DESKRIPSI'] ?></td>
                                    <td><?= $row['KETERSEDIAAN'] ?></td>
                                    <td><?= $row['TANGGAL_PENGADAAN'] ?></td>
                                    <td><?= $row['TAHUN_TERBIT'] ?></td>
                                    <td><?= $row['PENERBIT'] ?></td>
                                    <td><?= $row['RAK'] ?></td>
                                    <td><?= $row['IMG'] ?></td>
                                    <td><?= $row['STATUS_BUKU'] ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <a href='index.php?page=info&id=<?= $row["ID_BUKU"] ?>' data-bs-toggle="modal" data-bs-target="#info<?= $row['ID_BUKU']; ?>" class="btn btn-primary btn-xs m-1"><i class="fa fa-info-circle"></i></a>
                                            <a href='index.php?page=edit&id=<?= $row["ID_BUKU"] ?>' data-bs-toggle="modal" data-bs-target="#myModal<?= $row['ID_BUKU']; ?>" class="btn btn-warning btn-xs m-1"><i class="fa fa-pencil-square-o"></i></a>
                                            <a href="index.php?page=buku&idBuku=<?= $row['ID_BUKU'] ?>" onclick="javascript:return confirm('Hapus Data Buku?');" class="btn btn-danger btn-xs m-1"><i class="fa fa-trash"></i></a>
                                        </div>
                                        <div id="info<?= $row['ID_BUKU']?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-info-circle"></i> Detail Buku</h5>
                                                        <button type="button" class="btn-close-style " data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body custom-modal-body">
                                                        <h5>Judul Buku:     <?= $row['JUDUL_BUKU'] ?></h5><br>
                                                        <h5>Penulis   :     <?= $row['NAMA_PENULIS'] ?></h5><br>
                                                        <h5>Kategori  :     <?= $row['NAMA_KATEGORI']?></h5><br>
                                                        <h5>Penerbit  :     <?= $row['PENERBIT']?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- modal edit -->
                                        <div id="myModal<?= $row['ID_BUKU']?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel"><i
                                                                class="fa fa-book"></i> Edit Buku</h5>
                                                        <button type="button" class="btn-close-style "
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                    <form action="index.php?page=buku" method="post" id="editForm">
                                                    <div class="modal-body custom-modal-body">
                                                        <div class="mb-3 row form-group">
                                                            <label for="judul_buku1" class="col-sm-3 col-form-label">Judul Buku</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="judul_buku1" name="judul_buku1" value="<?= $row['JUDUL_BUKU']?>">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row form-group">
                                                            <label for="deskripsi1" class="col-sm-3 col-form-label">Deskripsi</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="deskripsi1" name="deskripsi1" value="<?= $row['DESKRIPSI'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row form-group">
                                                            <label for="kategori1[]" class="col-sm-3 col-form-label">Kategori</label>
                                                            <div class="col-sm-9">
                                                                <select name="kategori1[]" id="kategori1" class="form-select">
                                                                    <option selected>Kategori</option>
                                                                    <?php
                                                                        $queryKategori = "SELECT * FROM kategori";
                                                                        $resultKategori = mysqli_query($conn, $queryKategori);
                                                                        while($rowKategori = mysqli_fetch_assoc($resultKategori)){
                                                                        ?>
                                                                        <option value="<?= $rowKategori['ID_KATEGORI']?>"><?= $rowKategori['NAMA_KATEGORI'] ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-3 row form-group" id="row-<?php echo $row['ID_BUKU']; ?>">
                                                            <label for="penulis1[]" class="col-sm-3 col-form-label">Penulis</label>
                                                            <div class="col-sm-9">
                                                                <div id="writers-container-edit-<?php echo $row['ID_BUKU']; ?>">
                                                                    <select name="penulis1[]" class="form-select">
                                                                        <option selected>Penulis</option>
                                                                        <?php
                                                                        $queryPenulis = "SELECT * FROM penulis";
                                                                        $resultPenulis = mysqli_query($conn, $queryPenulis);
                                                                        while ($rowPenulis = mysqli_fetch_assoc($resultPenulis)) {
                                                                        ?>
                                                                            <option value="<?= $rowPenulis['ID_PENULIS'] ?>"><?= $rowPenulis['NAMA_PENULIS'] ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <br>
                                                                
                                                                <button class="btn btn-primary" onclick="addWriterEdit('writers-container-edit-<?php echo $row['ID_BUKU']; ?>')">Add Writer</button>
                                                            </div>
                                                        </div>


                                                        <div class="mb-3">
                                                            <label for="ketersediaan1" class="col-sm-3 col-form-label">Ketersediaan</label>
                                                            <br>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" class="form-check-input" id="ketersediaan1" name="ketersediaan1" value="Tersedia"<?= ($row['KETERSEDIAAN'] === 'Tersedia') ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="inlineradio1">Tersedia</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" class="form-check-input" id="ketersediaan1" name="ketersediaan1" value="Tidak Tersedia"<?= ($row['KETERSEDIAAN'] === 'Tidak Tersedia') ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="inlineradio1">Tidak Tersedia</label>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row form-group">
                                                            <label for="tanggal_pengadaan1" class="col-sm-3 col-form-label">Tanggal Pengadaann</label>
                                                            <div class="col-sm-9">
                                                                <input type="date" class="form-control" id="tanggal_pengadaan1" name="tanggal_pengadaan1" value="<?= $row['TANGGAL_PENGADAAN'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row form-group">
                                                            <label for="tahun_terbit1" class="col-sm-3 col-form-label">Tahun Terbit</label>
                                                            <div class="col-sm-9">
                                                                <input type="number" class="form-control" id="tahun_terbit1" name="tahun_terbit1" value="<?= $row['TAHUN_TERBIT'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row form-group">
                                                            <label for="penerbit1" class="col-sm-3 col-form-label">Penerbit</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="penerbit1" name="penerbit1" value="<?= $row['PENERBIT']?>">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row form-group">
                                                            <label for="rak1" class="col-sm-3 col-form-label">Rak</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="rak1" name="rak1" value="<?= $row['RAK']?>">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row form-group">
                                                            <label for="file1" class="col-sm-3 col-form-label">Img</label>
                                                            <div class="col-sm-9">
                                                                <!-- Input type "file" allows users to choose a new image file -->
                                                                <input type="file" class="form-control" id="file1" name="newFile" required>
                                                                <!-- Hidden input to store the existing image file name -->
                                                                <input type="hidden" name="img1" value="<?= $row['IMG'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status_buku1" class="col-sm-3 col-form-label">Status</label>
                                                            <select name="status_buku1" class="form-select" aria-label="Default select example">
                                                                <option selected>Pilih Status</option>
                                                                <option value="Bagus" <?= ($row['STATUS_BUKU'] == 'Bagus') ? 'selected' : '' ?>>Bagus</option>
                                                                <option value="Rusak" <?= ($row['STATUS_BUKU'] == 'Rusak') ? 'selected' : '' ?>>Rusak</option>
                                                                <option value="Hilang" <?= ($row['STATUS_BUKU'] == 'Hilang') ? 'selected' : '' ?>>Hilang</option>
                                                            </select>
                                                        </div>
                                                        <input type="hidden" id="bookId" name="bookId" value="<?= $row['ID_BUKU']?>" class="form-control">

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="reset" class="btn btn-primary"
                                                                    onclick="resetData()">Reset</button>
                                                                <button type="submit" name="update"
                                                                    class="btn btn-success">Save
                                                                    Changes</button>
                                                                <!-- <button href="#" type="submit1" id="save" name="save" class="btn btn-success">Save Changes</button> -->

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

                <div id="exampleModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"
                    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-users"></i> Tambah Buku</h5>
                                <button type="button" class="btn-close-style " data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data" >
                                <div class="modal-body custom-modal-body">
                                    <div class="mb-3 row form-group">
                                        <label for="recipient-name" class="col-sm-3 col-form-label">Judul</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="judul_buku" class="form-control" id="judul_buku">
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">
                                        <label for="judul_buku" class="col-sm-3 col-form-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="deskripsi" class="form-control" id="deskripsi">
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">
                                        <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                                        <div class="col-sm-9">
                                            <select name="kategori[]" id="kategori" class="form-select">
                                                <option selected>Kategori</option>
                                                <?php
                                                    $queryKategori = "SELECT * FROM kategori";
                                                    $resultKategori = mysqli_query($conn, $queryKategori);
                                                    while($rowKategori = mysqli_fetch_assoc($resultKategori)){
                                                    ?>
                                                    <option value="<?= $rowKategori['ID_KATEGORI']?>"><?= $rowKategori['NAMA_KATEGORI'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">
                                        <label for="penulis[]" class="col-sm-3 col-form-label">Penulis</label>
                                        <div class="col-sm-9">
                                            <div id="writers-container-create">
                                                <select name="penulis[]" class="form-select">
                                                    <option selected>Penulis</option>
                                                    <?php
                                                    $queryPenulis = "SELECT * FROM penulis";
                                                    $resultPenulis = mysqli_query($conn, $queryPenulis);
                                                    while ($rowPenulis = mysqli_fetch_assoc($resultPenulis)) {
                                                        ?>
                                                        <option value="<?= $rowPenulis['ID_PENULIS'] ?>"><?= $rowPenulis['NAMA_PENULIS'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <br>
                                            <button class="btn btn-primary" onclick="addWriter('writers-container-create')">Add Writer</button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="ketersediaan" class="col-form-label">Ketersediaan :</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="ketersediaan" value="Tersedia" id="tersedia">
                                            <label class="form-check-label" for="tersedia">Tersedia</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="ketersediaan" value="Tidak Tersedia" id="tidak-tersedia">
                                            <label class="form-check-label" for="tidak-tersedia">Tidak Tersedia</label>
                                        </div>
                                    </div>

                                    <div class="mb-3 row form-group">
                                        <label for="tanggal_pengadaan" class="col-sm-3 col-form-label">Tanggal Pengadaan</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="tanggal_pengadaan" class="form-control"
                                                id="tanggal_pengadaan">
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">
                                        <label for="recipient-name" class="col-sm-3 col-form-label">Tahun Terbit</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="tahun_terbit"
                                                name="tahun_terbit">
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">
                                        <label for="penerbit1" class="col-sm-3 col-form-label">Penerbit</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="penerbit" name="penerbit">
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">
                                        <label for="recepient-name" class="col-sm-3 col-form-label">Rak</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="rak" name="rak">
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">
                                        <label for="recepient-name" class="col-sm-3 col-form-label">Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" name="file" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row form-group">
                                    <label for="status_buku" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                        <select name="status_buku" class="form-select" aria-label="Default select example">
                                            <option selected>Pilih Status</option>
                                            <option value="Bagus">Bagus</option>
                                            <option value="Rusak">Rusak</option>
                                            <option value="Hilang">Hilang</option>
                                        </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="memberId" class="form-control">

                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-primary" onclick="resetData()">Reset</button>
                                    <button type="submit" name="submit" class="btn btn-success ms-2"
                                        aria-hidden="true"><i class="fa fa-floppy-o"></i> Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <script>
                        function addWriter(containerId) {
        var container = document.getElementById(containerId);

        // Create a new div for the writer
        var writerDiv = document.createElement('div');
        writerDiv.className = 'mb-3 row form-group';

        // Create a label element
        var label = document.createElement('label');
        label.className = 'col-sm-3 col-form-label';
        label.textContent = 'Penulis';

        // Create a div for the select element
        var selectDiv = document.createElement('div');
        selectDiv.className = 'col-sm-9';

        // Create a select element
        var select = document.createElement('select');
        select.name = 'penulis[]';
        select.className = 'form-select';

        // Add a default option
        var defaultOption = document.createElement('option');
        defaultOption.selected = true;
        defaultOption.textContent = 'Penulis';
        select.appendChild(defaultOption);

        // Populate select with options from PHP
        <?php
        $queryPenulis = "SELECT * FROM penulis";
        $resultPenulis = mysqli_query($conn, $queryPenulis);
        while ($rowPenulis = mysqli_fetch_assoc($resultPenulis)) {
        ?>
            var option = document.createElement('option');
            option.value = '<?= $rowPenulis['ID_PENULIS'] ?>';
            option.textContent = '<?= $rowPenulis['NAMA_PENULIS'] ?>';
            select.appendChild(option);
        <?php
        }
        ?>

        // Append the select to the selectDiv
        selectDiv.appendChild(select);

        // Append the label and selectDiv to the new writerDiv
        writerDiv.appendChild(label);
        writerDiv.appendChild(selectDiv);

        // Append the new writerDiv to the container
        container.appendChild(writerDiv);
    }


    function addWriterEdit(containerId) {
        var container = document.getElementById(containerId);

        // Create a new div for the writer
        var writerDiv = document.createElement('div');
        writerDiv.className = 'mb-3 row form-group';

        // Create a label element
        var label = document.createElement('label');
        label.className = 'col-sm-3 col-form-label';
        label.textContent = 'Penulis1';

        // Create a div for the select element
        var selectDiv = document.createElement('div');
        selectDiv.className = 'col-sm-9';

        // Create a select element
        var select = document.createElement('select');
        select.name = 'penulis1[]';
        select.className = 'form-select';

        // Add a default option
        var defaultOption = document.createElement('option');
        defaultOption.selected = true;
        defaultOption.textContent = 'Penulis';
        select.appendChild(defaultOption);

        // Populate select with options from PHP
        <?php
        $queryPenulis = "SELECT * FROM penulis";
        $resultPenulis = mysqli_query($conn, $queryPenulis);
        while ($rowPenulis = mysqli_fetch_assoc($resultPenulis)) {
        ?>
            var option = document.createElement('option');
            option.value = '<?= $rowPenulis['ID_PENULIS'] ?>';
            option.textContent = '<?= $rowPenulis['NAMA_PENULIS'] ?>';
            select.appendChild(option);
        <?php
        }
        ?>

        // Append the select to the selectDiv
        selectDiv.appendChild(select);

        // Append the label and selectDiv to the new writerDiv
        writerDiv.appendChild(label);
        writerDiv.appendChild(selectDiv);

        // Append the new writerDiv to the container
        container.appendChild(writerDiv);
    }

                        function resetData() {
                        var form = document.getElementById('editForm');
                        var form1 = document.getElementById('myModal');
                        form.reset();
                    }
                </script>
            </div>
        </main>
    </div>
</div>