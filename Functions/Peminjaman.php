<?php
class peminjaman
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
    public function addPeminjaman($id_member, $id_buku, $tanggal_peminjaman, $tanggal_pengembalian, $id_peminjaman)
    {
        $id_member = mysqli_real_escape_string($this->conn, $id_member); // Escape ID
        $id_buku = mysqli_real_escape_string($this->conn, $id_buku);
        $tanggal_peminjaman = mysqli_real_escape_string($this->conn, $tanggal_peminjaman);
        $tanggal_pengembalian = mysqli_real_escape_string($this->conn, $tanggal_pengembalian);
        $id_peminjaman = mysqli_real_escape_string($this->conn, $id_peminjaman);

        $insert_query_peminjaman = "INSERT INTO peminjaman (ID_MEMBER, ID_BUKU, TANGGAL_PEMINJAMAN, TANGGAL_PENGEMBALIAN,  ID_PEMINJAMAN)
        VALUES ('$id_member', '$id_buku', '$tanggal_peminjaman', '$tanggal_pengembalian',' $id_peminjaman')";


        $result_peminjaman = mysqli_query($this->conn, $insert_query_peminjaman);

        return $result_peminjaman;
    }


    public function addPeminjamanFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Ambil data dari form

            $id_member = $_POST['ID_MEMBER'];
            $id_buku = $_POST['ID_BUKU'];
            $tanggal_peminjaman = $_POST['TANGGAL_PEMINJAMAN'];
            $tanggal_pengembalian = $_POST['TANGGAL_PENGEMBALIAN'];
            $id_peminjaman = $_POST[' ID_PEMINJAMAN'];

            // Panggil fungsi untuk menyimpan ke database
            $result_peminjaman = $this->addPeminjaman($id_member, $id_buku, $tanggal_peminjaman, $tanggal_pengembalian, $id_peminjaman);

            if ($result_peminjaman) {
                ob_start();
                pesan('success', "Peminjaman Berhasil Ditambahkan.");

                // Tambahkan data ke tabel PENGEMBALIAN jika diperlukan
                // Contoh: $this->addPengembalian($id_member, $tanggal_pengembalian);
                header("Location: index.php?page=peminjaman");
                exit();
            } else {
                pesan('danger', "Gagal Menambahkan Peminjaman Karena: " . mysqli_error($this->conn));
            }
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


    public function editPeminjaman($id_member, $id_buku, $tanggal_peminjaman, $tanggal_pengembalian, $denda, $status, $id_peminjaman)
    {
        $id_member = mysqli_real_escape_string($this->conn, $id_member); // Escape ID
        $id_buku = mysqli_real_escape_string($this->conn, $id_buku);
        $tanggal_peminjaman = mysqli_real_escape_string($this->conn, $tanggal_peminjaman);
        $tanggal_pengembalian = mysqli_real_escape_string($this->conn, $tanggal_pengembalian);
        $status = mysqli_real_escape_string($this->conn, $status);
        $denda = mysqli_real_escape_string($this->conn, $denda);
        $id_peminjaman = mysqli_real_escape_string($this->conn, $id_peminjaman);

        $update_query = "UPDATE peminjaman SET 
    ID_MEMBER = '$id_member',
    ID_BUKU = '$id_buku',
    TANGGAL_PEMINJAMAN = '$tanggal_peminjaman',
    TANGGAL_PENGEMBALIAN = '$tanggal_pengembalian',
     ATTRIBSTATUSUTE_26 = '$status',
     DENDA = '$denda'
    WHERE ID_PEMINJAMAN = '$id_peminjaman'";

        $result = mysqli_query($this->conn, $update_query);

        return $result;
    }


    public function editPeminjamanFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if (!empty($_POST['ID_MEMBER']) && !empty($_POST['JUDUL_BUKU'])) {
                $id_member = $_POST['id_member1'];
                $id_buku = $_POST['id_buku1'];

                $tanggal_peminjaman = $_POST['tanggal_peminjaman1'];
                $tanggal_pengembalian = $_POST['tanggal_pengembalian1'];
                $status = $_POST['status2'];

                $id_peminjaman = $_POST['idPeminjaman1'];


                $result = $this->editPeminjaman($id_member, $id_buku, $tanggal_peminjaman, $tanggal_pengembalian, $status, $id_peminjaman);

                if ($result) {
                    pesan('success', 'Kategori Telah Diubah.');
                } else {
                    pesan('danger', 'Gagal Mengubah Kategori: ' . mysqli_error($this->conn));
                }
            }

            header("Location: index.php?page=peminjaman");
            exit;
        }
    }


    public function hapusPeminjaman($id_peminjaman)
    {
        $id_peminjaman = mysqli_real_escape_string($this->conn, $id_peminjaman); // Escape ID

        $delete_query = "DELETE FROM PEMINJAMAN WHERE ID Peminjaman = '$id_peminjaman'"; // Query hapus peminjaman

        $result = mysqli_query($this->conn, $delete_query);

        return $result;
    }

    public function deletePeminjamanFromForm()
    {
        if (isset($_GET['delete_id'])) {
            $id_peminjaman = $_GET['delete_id']; // Ambil ID peminjaman

            $result = $this->hapusPeminjaman($id_peminjaman); // Panggil fungsi hapusPeminjaman

            if ($result) {
                ob_start();
                pesan('success', 'Data Peminjaman Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Data Peminjaman: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=peminjaman");
            exit;
        }
    }

    public function hapusPengembalian($id_peminjaman)
    {
        $id_peminjaman = mysqli_real_escape_string($this->conn, $id_peminjaman); // Escape ID

        $delete_query = "DELETE FROM PEMINJAMAN WHERE ID Peminjaman = '$id_peminjaman'"; // Query hapus peminjaman

        $result = mysqli_query($this->conn, $delete_query);

        return $result;
    }

    public function deletePengembalianFromForm()
    {
        if (isset($_GET['delete'])) {
            $id_peminjaman = $_GET['delete']; // Ambil ID peminjaman

            $result = $this->hapusPengembalian($id_peminjaman); // Panggil fungsi hapusPeminjaman

            if ($result) {
                ob_start();
                pesan('success', 'Data Peminjaman Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Data Peminjaman: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=peminjaman");
            exit;
        }
    }

}