<?php
class Peminjaman
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getpeminjaman()
    {
        $peminjaman_query = "SELECT * FROM peminjaman";
        $peminjaman_result = mysqli_query($this->conn, $peminjaman_query);

        return $peminjaman_result;
    }



    public function searchpeminjaman($query)
    {
        $query = '%' . mysqli_real_escape_string($this->conn, $query) . '%';

        $sql = "SELECT * FROM PEMINJAMAN WHERE NAMA_MEMBER LIKE ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $query);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }

    public function addPeminjaman($id_member, $id_buku_tambah, $tanggal_peminjaman, $tanggal_pengembalian)
    {
        $id_member = mysqli_real_escape_string($this->conn, $id_member);
        $tanggal_peminjaman = mysqli_real_escape_string($this->conn, $tanggal_peminjaman);
        $tanggal_pengembalian = mysqli_real_escape_string($this->conn, $tanggal_pengembalian);

        // Insert into PEMINJAMAN table
        $insert_query_peminjaman = "INSERT INTO PEMINJAMAN (ID_MEMBER, TANGGAL_PEMINJAMAN, TANGGAL_PENGEMBALIAN, ATTRIBSTATUSUTE_26, DENDA)
                                    VALUES ('$id_member', '$tanggal_peminjaman', '$tanggal_pengembalian', 'Dipinjam', 0)";
        $result_peminjaman = mysqli_query($this->conn, $insert_query_peminjaman);

        // Get the last inserted ID_PEMINJAMAN
        $id_peminjaman = mysqli_insert_id($this->conn);

        // Insert into DETAILPEMINJAMAN table for each selected book
        foreach ($id_buku_tambah as $id_buku) {
            $insert_query_detail = "INSERT INTO DETAILPEMINJAMAN (ID_PEMINJAMAN, ID_BUKU, STATUS_PEMINJAMAN, STATUS_BUKU)
                                    VALUES ($id_peminjaman, $id_buku, 'Dipinjam', 'Bagus')";
            mysqli_query($this->conn, $insert_query_detail);
        }

        return $result_peminjaman;
    }



    public function addPeminjamanFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Ambil data dari form
            $id_member = $_POST['ID_MEMBER'];
            $id_buku_tambah = $_POST['ID_BUKU_TAMBAH']; // Assuming this is an array of selected books
            $tanggal_peminjaman = $_POST['TANGGAL_PEMINJAMAN'];
            $tanggal_pengembalian = $_POST['TANGGAL_PENGEMBALIAN'];

            // Panggil fungsi untuk menyimpan ke database
            $result_peminjaman = $this->addPeminjaman($id_member, $id_buku_tambah, $tanggal_peminjaman, $tanggal_pengembalian);

            if ($result_peminjaman) {
                // Tampilkan pesan sukses atau redirect ke halaman lain
                pesan('success', "Peminjaman Berhasil Ditambahkan.");

                // Tambahkan data ke tabel PENGEMBALIAN jika diperlukan
                // Contoh: $this->addPengembalian($id_member, $tanggal_pengembalian);

                header("Location: index.php?page=peminjaman");
                exit(); // Pastikan untuk menambahkan exit() setelah header redirect
            } else {
                pesan('danger', "Gagal Menambahkan Peminjaman Karena: " . mysqli_error($this->conn));
            }
        }
    }




    public function editPeminjaman($id_peminjaman, $id_member, $tanggal_peminjaman, $tanggal_pengembalian, $status, $denda, $id_buku_edit)
    {
        $id_peminjaman = mysqli_real_escape_string($this->conn, $id_peminjaman);
        $id_member = mysqli_real_escape_string($this->conn, $id_member);
        $tanggal_peminjaman = mysqli_real_escape_string($this->conn, $tanggal_peminjaman);
        $tanggal_pengembalian = mysqli_real_escape_string($this->conn, $tanggal_pengembalian);
        $status_peminjaman = mysqli_real_escape_string($this->conn, $status);
        $denda = mysqli_real_escape_string($this->conn, $denda);

        // Update PEMINJAMAN table
        $update_query_peminjaman = "UPDATE PEMINJAMAN 
                            SET ID_MEMBER = '$id_member', 
                                TANGGAL_PEMINJAMAN = '$tanggal_peminjaman', 
                                TANGGAL_PENGEMBALIAN = '$tanggal_pengembalian',
                                ATTRIBSTATUSUTE_26 = '$status_peminjaman',
                                DENDA = '$denda'
                            WHERE ID_PEMINJAMAN = $id_peminjaman";
        $result_peminjaman = mysqli_query($this->conn, $update_query_peminjaman);

        // if ($result_peminjaman) {
        //     foreach ($id_buku_edit as $index => $id_buku) {
        //         $status_buku = mysqli_real_escape_string($this->conn, $status[$index]);
        //         $status_peminjaman_buku = mysqli_real_escape_string($this->conn, $status);
        //         $id_buku = mysqli_real_escape_string($this->conn, $id_buku);

        if ($result_peminjaman) {
            foreach ($id_buku_edit as $index => $id_buku) {
                // Kode pengamanan terhadap SQL Injection
                $status_buku = mysqli_real_escape_string($this->conn, $status[$index]);
                $id_buku = mysqli_real_escape_string($this->conn, $id_buku);

                // Menambahkan logika untuk mengubah status peminjaman buku menjadi 'Selesai'
                $update_detail_query = "UPDATE DETAILPEMINJAMAN 
                                            SET STATUS_PEMINJAMAN = '$status'
                                            WHERE ID_PEMINJAMAN = $id_peminjaman AND ID_BUKU = $id_buku";
                mysqli_query($this->conn, $update_detail_query);
            }
            return true; // Return true if the update was successful
        }
        return false;
    }
    public function editPeminjamanFromForm()
    {
        if (isset($_POST['update'])) {
            $id_peminjaman = mysqli_real_escape_string($this->conn, $_POST['ID_PEMINJAMAN']);
            $id_member = mysqli_real_escape_string($this->conn, $_POST['ID_MEMBER']);
            $status = $_POST['STATUS'];
            $tanggal_peminjaman = mysqli_real_escape_string($this->conn, $_POST['tanggal_peminjaman1']);
            $tanggal_pengembalian = mysqli_real_escape_string($this->conn, $_POST['tanggal_pengembalian1']);
            $id_buku_edit = $_POST['ID_BUKU_EDIT'];
            $denda = mysqli_real_escape_string($this->conn, $_POST['DENDA']);

            // Call the function to save to the database
            $result_peminjaman = $this->editPeminjaman($id_peminjaman, $id_member, $tanggal_peminjaman, $tanggal_pengembalian, $status, $denda, $id_buku_edit);

            if ($result_peminjaman) {
                pesan('success', "Peminjaman Berhasil Diubah.");
                header("Location: index.php?page=peminjaman");
                exit();
            } else {
                pesan('danger', "Gagal Mengubah Peminjaman Karena: " . mysqli_error($this->conn));
            }
        }
    }



    // public function editPeminjamanFromForm()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    //         if (isset($_POST['ID_PEMINJAMAN'])) {
    //             $id_peminjaman = $_POST['ID_PEMINJAMAN'];

    //             // Panggil fungsi untuk mengambil data peminjaman berdasarkan ID
    //             $existingData = $this->getPeminjamanById($id_peminjaman);

    //             if ($existingData) {
    //                 // Ambil data dari form jika diisi, jika tidak, gunakan data yang ada sebelumnya
    //                 $id_member = isset($_POST['ID_MEMBER']) ? $_POST['ID_MEMBER'] : $existingData['ID_MEMBER'];
    //                 $id_buku_edit = isset($_POST['ID_BUKU_EDIT']) ? $_POST['ID_BUKU_EDIT'] : [];
    //                 $tanggal_peminjaman = isset($_POST['tanggal_peminjaman1']) ? $_POST['tanggal_peminjaman1'] : $existingData['TANGGAL_PEMINJAMAN'];
    //                 $tanggal_pengembalian = isset($_POST['tanggal_pengembalian1']) ? $_POST['tanggal_pengembalian1'] : $existingData['TANGGAL_PENGEMBALIAN'];
    //                 $status = isset($_POST['STATUS']) ? $_POST['STATUS'] : $existingData['ATTRIBSTATUSUTE_26'];
    //                 $denda = isset($_POST['DENDA']) ? $_POST['DENDA'] : $existingData['DENDA'];

    //                 // Panggil fungsi untuk menyimpan ke database
    //                 $result_peminjaman = $this->editPeminjaman($id_peminjaman, $id_member, $id_buku_edit, $tanggal_peminjaman, $tanggal_pengembalian, $status, $denda);

    //                 if ($result_peminjaman) {
    //                     // Tampilkan pesan sukses atau redirect ke halaman lain
    //                     pesan('success', "Peminjaman Berhasil Ditambahkan.");

    //                     // Tambahkan data ke tabel PENGEMBALIAN jika diperlukan
    //                     // Contoh: $this->addPengembalian($id_member, $tanggal_pengembalian);

    //                     header("Location: index.php?page=peminjaman");
    //                     exit(); // Pastikan untuk menambahkan exit() setelah header redirect
    //                 } else {
    //                     pesan('danger', "Gagal Menambahkan Peminjaman Karena: " . mysqli_error($this->conn));
    //                 }
    //             } else {
    //                 pesan('danger', "Data Peminjaman tidak ditemukan.");
    //             }
    //         } else {
    //             pesan('danger', "ID Peminjaman tidak tersedia.");
    //         }
    //     }
    // }

    public function hapusPeminjaman($id_peminjaman)
    {
        $id_peminjaman = mysqli_real_escape_string($this->conn, $id_peminjaman); // Escape ID

        // First delete related records in detailpeminjaman table
        $delete_detail_query = "DELETE FROM detailpeminjaman WHERE ID_PEMINJAMAN = '$id_peminjaman'";
        $result_detail = mysqli_query($this->conn, $delete_detail_query);

        if (!$result_detail) {
            // Handle error in deleting dependent records
            // This might involve logging the error or taking appropriate action
            // Return or handle this error as needed
            return false;
        }

        // Then delete the record in the peminjaman table
        $delete_query = "DELETE FROM PEMINJAMAN WHERE ID_PEMINJAMAN = '$id_peminjaman'"; // Query hapus peminjaman
        $result = mysqli_query($this->conn, $delete_query);

        return $result;
    }

    public function deletePeminjamanFromForm()
    {
        if (isset($_GET['delete_id'])) {
            $id_peminjaman = $_GET['delete_id']; // Ambil ID peminjaman

            $result = $this->hapusPeminjaman($id_peminjaman); // Panggil fungsi hapusPeminjaman

            if ($result) {
                pesan('success', 'Data Peminjaman Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Data Peminjaman: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=peminjaman");
            exit;
        }
    }

    // public function addPengembalian($id_member, $tanggal_pengembalian)
    // {
    //     // Simpan data pengembalian ke tabel PENGEMBALIAN
    //     $id_member = mysqli_real_escape_string($this->conn, $id_member);
    //     $tanggal_pengembalian = mysqli_real_escape_string($this->conn, $tanggal_pengembalian);

    //     $insert_query_pengembalian = "INSERT INTO PENGEMBALIAN (ID_MEMBER, TANGGAL_PENGEMBALIAN) VALUES ('$id_member', '$tanggal_pengembalian')";
    //     $result_pengembalian = mysqli_query($this->conn, $insert_query_pengembalian);

    //     return $result_pengembalian;
    // }

    // Fungsi untuk menambahkan data peminjaman ke tabel pengembalian
    // public function tambahKeTabelPengembalian($id_peminjaman, $id_member, $tanggal_peminjaman, $tanggal_pengembalian, $denda)
    // {
    //     // Lakukan operasi INSERT ke tabel pengembalian
    //     $insert_query_pengembalian = "INSERT INTO pengembalian (ID_PEMINJAMAN, ID_MEMBER, TANGGAL_PEMINJAMAN, TANGGAL_PENGEMBALIAN, DENDA) 
    //                               VALUES ('$id_peminjaman', '$id_member', '$tanggal_peminjaman', '$tanggal_pengembalian', '$denda')";

    //     $result_pengembalian = mysqli_query($this->conn, $insert_query_pengembalian);

    //     return $result_pengembalian;
    // }

    // Fungsi untuk mengubah status peminjaman menjadi Kembali
    // public function ubahStatusPeminjamanMenjadiKembali($id_peminjaman)
    // {
    //     // Lakukan operasi UPDATE untuk mengubah status peminjaman menjadi Kembali
    //     $update_query_peminjaman = "UPDATE PEMINJAMAN SET ATTRIBSTATUSUTE_26 = 'Kembali' WHERE ID_PEMINJAMAN = '$id_peminjaman'";
    //     $result_peminjaman = mysqli_query($this->conn, $update_query_peminjaman);

    //     return $result_peminjaman;


    //     // Bagian logika aplikasi Anda untuk menambahkan data ke tabel pengembalian saat status peminjaman berubah menjadi Kembali
    //     if ($status_peminjaman == 'Kembali') {
    //         // Panggil fungsi untuk menambahkan data ke tabel pengembalian
    //         $result_pengembalian = $this->tambahKeTabelPengembalian($id_peminjaman, $id_member, $tanggal_peminjaman, $tanggal_pengembalian, $denda);

    //         if ($result_pengembalian) {
    //             // Jika berhasil ditambahkan ke tabel pengembalian, ubah status peminjaman menjadi Kembali
    //             $result_status_peminjaman = $this->ubahStatusPeminjamanMenjadiKembali($id_peminjaman);

    //             if ($result_status_peminjaman) {
    //                 // Tampilkan pesan sukses atau lakukan tindakan lain setelah berhasil mengubah status peminjaman
    //                 pesan('success', 'Data Peminjaman Berhasil Dikembalikan dan Ditambahkan ke Tabel Pengembalian');
    //             } else {
    //                 pesan('danger', 'Gagal Mengubah Status Peminjaman Menjadi Kembali');
    //             }
    //         } else {
    //             pesan('danger', 'Gagal Menambahkan Data Peminjaman ke Tabel Pengembalian');
    //         }
    //     }

    // }
}