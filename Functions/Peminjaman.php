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
    public function addPeminjaman($id_member, $id_buku, $jumlah_buku, $tanggal_peminjaman, $tanggal_pengembalian)
    {
        $id_member = mysqli_real_escape_string($this->conn, $id_member);
        $id_buku = mysqli_real_escape_string($this->conn, $id_buku);
        $jumlah_buku = mysqli_real_escape_string($this->conn, $jumlah_buku);
        $tanggal_peminjaman = mysqli_real_escape_string($this->conn, $tanggal_peminjaman);
        $tanggal_pengembalian = mysqli_real_escape_string($this->conn, $tanggal_pengembalian);

        // Query untuk menambahkan peminjaman
        $insert_query_peminjaman = "INSERT INTO PEMINJAMAN (ID_MEMBER, ID_BUKU, TANGGAL_PEMINJAMAN, TANGGAL_PENGEMBALIAN, ATTRIBSTATUSUTE_26, DENDA)
                                    VALUES ('$id_member', '$id_buku', '$tanggal_peminjaman', '$tanggal_pengembalian', 'Dipinjam', 0)";

        $result_peminjaman = mysqli_query($this->conn, $insert_query_peminjaman);

        // Ambil ID_PEMINJAMAN yang baru saja di-generate
        $new_peminjaman_id = mysqli_insert_id($this->conn);

        // Cek apakah peminjaman berhasil ditambahkan
        if ($result_peminjaman) {
            // Ubah status peminjaman menjadi 'Kembali' jika ada logika pengembalian
            $update_status_query = "UPDATE PEMINJAMAN SET ATTRIBSTATUSUTE_26 = 'Kembali' WHERE ID_PEMINJAMAN = '$new_peminjaman_id'";
            $result_update_status = mysqli_query($this->conn, $update_status_query);

        } else {



        }
    }




    public function addPeminjamanFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Ambil data dari form
            $id_member = $_POST['ID_MEMBER'];
            $id_buku = $_POST['ID_BUKU'];
            $jumlah_buku = $_POST['JUMLAH_BUKU'];
            $tanggal_peminjaman = $_POST['TANGGAL_PEMINJAMAN'];
            $tanggal_pengembalian = $_POST['TANGGAL_PENGEMBALIAN'];

            // Panggil fungsi untuk menyimpan ke database
            $result_peminjaman = $this->addPeminjaman($id_member, $id_buku, $jumlah_buku, $tanggal_peminjaman, $tanggal_pengembalian);

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



    public function addPengembalian($id_member, $tanggal_pengembalian)
    {
        // Simpan data pengembalian ke tabel PENGEMBALIAN
        $id_member = mysqli_real_escape_string($this->conn, $id_member);
        $tanggal_pengembalian = mysqli_real_escape_string($this->conn, $tanggal_pengembalian);

        $insert_query_pengembalian = "INSERT INTO PENGEMBALIAN (ID_MEMBER, TANGGAL_PENGEMBALIAN) VALUES ('$id_member', '$tanggal_pengembalian')";
        $result_pengembalian = mysqli_query($this->conn, $insert_query_pengembalian);

        return $result_pengembalian;
    }


    public function editPeminjaman($id_member, $judul_buku)
    {
        $id_member = mysqli_real_escape_string($this->conn, $id_member); // Escape ID
        $judul_buku = mysqli_real_escape_string($this->conn, $judul_buku);

        $update_query = "UPDATE peminjaman SET JUDUL_BUKU = '$judul_buku' WHERE ID_MEMBER = '$id_member'"; // Tambahkan klausa WHERE

        $result = mysqli_query($this->conn, $update_query);

        return $result;
    }


    public function editPeminjamanFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if (!empty($_POST['ID_MEMBER']) && !empty($_POST['JUDUL_BUKU'])) {
                $id_member = $_POST['ID_MEMBER'];
                $judul_buku = $_POST['JUDUL_BUKU'];

                $result = $this->editPeminjaman($id_member, $judul_buku);

                if ($result) {
                    pesan('success', 'Kategori Telah Diubah.');
                } else {
                    pesan('danger', 'Gagal Mengubah Kategori: ' . mysqli_error($this->conn));
                }
            }

            header("Location: index.php?page=kategori");
            exit;
        }
    }


    public function hapusPeminjaman($id_member)
    {
        $id_member = mysqli_real_escape_string($this->conn, $id_member); // Escape ID

        $delete_query = "DELETE FROM PEMINJAMAN WHERE ID_MEMBER = '$id_member'"; // Query hapus peminjaman

        $result = mysqli_query($this->conn, $delete_query);

        return $result;
    }

    public function deletePeminjamanFromForm()
    {
        if (isset($_GET['delete_id'])) {
            $id_member = $_GET['delete_id']; // Ambil ID peminjaman

            $result = $this->hapusPeminjaman($id_member); // Panggil fungsi hapusPeminjaman

            if ($result) {
                pesan('success', 'Data Peminjaman Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Data Peminjaman: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=peminjaman");
            exit;
        }
    }

}