<div class="container-fluid">
    <div class="row">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <?php

    include 'Functions/pesan_kilat.php';
    $db = new Database();
    $conn = $db->getConnection();
        require 'Functions/Member.php';
        $member = new Member($conn);
        $add = $member->addMemberFromForm();
        $delete = $member->hapusMemberFromForm();
        $edit = $member->editMemberFromForm();

        
        ?>  

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Member</h1>
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
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jenis Identitas</th>
                                <th scope="col">Nomor Identitas</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Level</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT * FROM member where level = 'Member' order by id_member asc";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr id="<?= $row['ID_MEMBER'] ?>">
                                <!-- <th scope="row"><?= $no++ ?></th> -->
                                <td><?= $row['ID_MEMBER'] ?></td>
                                <td><?= $row['USERNAME_MEMBER'] ?></td>
                                <td><?= $row['PASSWORD_MEMBER'] ?></td>
                                <td><?= $row['NAMA_MEMBER'] ?></td>
                                <td><?= $row['JENIS_IDENTITAS'] ?></td>
                                <td><?= $row['NOMOR_IDENTITAS'] ?></td>
                                <td><?= $row['ALAMAT'] ?></td>
                                <td><?= $row['level'] ?></td>
                                <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#myModal<?=$row['ID_MEMBER'] ;?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i>Edit</a>
                                <a href="index.php?page=member&idMember=<?= $row['ID_MEMBER']?>" onclick="javascript:return confirm('Hapus Data Buku?');" class="btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i>Hapus</a>
                                <div id="myModal<?= $row['ID_MEMBER']?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="myModalLabel<?=$row['ID_MEMBER'] ?>" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-users"></i>  Edit Data Member</h5>
                <button type="button" class="btn-close-style " data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="index.php?page=member" method="post">
            <div class="modal-body custom-modal-body">
                <div class="mb-3 row form-group">
                    <label for="judul_buku" class="col-sm-3 col-form-label">ID Member</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="id_member1" name="id_member1" value="<?=$row['ID_MEMBER']?>">
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="judul_buku" class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="username1" name="username1" value="<?=$row['USERNAME_MEMBER']?>">
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="deskripsi" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="password1" name="password1" value="<?=$row['PASSWORD_MEMBER']?>">
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="ketersediaan" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama1" name="nama1" value="<?=$row['NAMA_MEMBER']?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Jenis Identitas</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="iden1" id="iden1" value="KTM" <?= ($row['JENIS_IDENTITAS'] === 'KTM') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="inlineRadio1">KTM</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="iden1" id="iden1" value="KTP" <?= ($row['JENIS_IDENTITAS'] === 'KTP') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="inlineRadio2">KTP</label>
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="recipient-name" class="col-sm-3 col-form-label">Nomor Identitas</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="noIden1" name="noIden1" value="<?=$row['NOMOR_IDENTITAS']?>">
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="recepient-name" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="alamat1" name="alamat1" value="<?=$row['ALAMAT']?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Level</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="level1" id="level1" value="Admin" <?= ($row['level'] === 'Admin') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="inlineRadio1">Admin</label> 
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="level1" id="level1" value="Member" <?= ($row['level'] === 'Member') ? 'checked' : '' ?>>
                        <label class="form-check-label" for="inlineRadio2">Member</label>
                    </div>
                </div>
                <input type="hidden" id="memberId" class="form-control">
                
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


                <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm " role="document">
                        <div class="modal-content h-100 ">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Member</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post" class="vh-100" style="padding-bottom: 10rem;">
                                <div class="modal-body overflow-y-scroll h-100 ">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">ID_Member</label>
                                        <input type="text" name="id_member" class="form-control" id="id_member">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Username</label>
                                        <input type="text" name="username" class="form-control" id="username">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="nama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Password</label>
                                        <input type="text" name="password" class="form-control" id="password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Jenis Identitas</label>
                                        <select name="iden" id="iden" class="form-select" aria-label="Default select example">
                                            <option selected>Pilih Identitas</option>
                                            <option value="KTM">KTM</option>
                                            <option value="KTP">KTP</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Nomor Identitas</label>
                                        <input type="text" name="noIdentitas" class="form-control" id="noIdentitas">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" id="alamat">
                                    </div>
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Level</label>
                                        <select name="level" id="level" class="form-select" aria-label="Default select example">
                                            <option value="Member">Member</option>
                                        </select>
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