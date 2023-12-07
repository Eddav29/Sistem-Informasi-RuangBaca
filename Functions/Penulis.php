<?php
class Penulis
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getpenulis()
    {
        $penulis_query = "SELECT * FROM PENULIS";
        $penulis_result = mysqli_query($this->conn, $penulis_query);

        return $penulis_result;
    }


    public function searchpenulis($query)
    {
        $query = '%' . mysqli_real_escape_string($this->conn, $query) . '%';

        $sql = "SELECT * FROM PENULIS WHERE NAMA_PENULIS LIKE ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $query);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }
    public function addpenulis($nama_penulis)
    {
        $nama_penulis = mysqli_real_escape_string($this->conn, $nama_penulis);

        $insert_query = "INSERT INTO PENULIS (NAMA_PENULIS) VALUES ('$nama_penulis')";
        $result = mysqli_query($this->conn, $insert_query);

        return $result;
    }



    public function addPenulisFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $nama_penulis = $_POST['nama_penulis'];
            echo "Nama Penulis: " . $nama_penulis;
            // Assuming $book is an instance of your Book class
            $result = $this->addPenulis($nama_penulis);

            if ($result) {
                ob_start();
                // Book added successfully
                // You can redirect to a success page or perform any other actions
                // For example, you can use header("Location: success.php");
                pesan('success', "Kategori Baru Ditambahkan.");
                header("Location: index.php?page=penulis");
            } else {
                pesan('danger', "Gagal Menambahkan penulis Karena: " . mysqli_error($this->conn));
            }
        }
    }
    public function editpenulis($id_penulis, $nama_penulis)
    {
        $id_penulis = mysqli_real_escape_string($this->conn, $id_penulis); // Escape ID
        $nama_penulis = mysqli_real_escape_string($this->conn, $nama_penulis);

        $update_query = "UPDATE penulis SET NAMA_PENULIS = '$nama_penulis' WHERE ID_PENULIS = '$id_penulis'"; // Tambahkan klausa WHERE

        $result = mysqli_query($this->conn, $update_query);

        return $result;
    }


    public function editPenulisFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if (!empty($_POST['ID_PENULIS']) && !empty($_POST['NAMA_PENULIS'])) {
                $id_penulis = $_POST['ID_PENULIS'];
                $nama_penulis = $_POST['NAMA_PENULIS'];

                $result = $this->editpenulis($id_penulis, $nama_penulis);

                if ($result) {
                    pesan('success', 'Penulis Telah Diubah.');
                } else {
                    pesan('danger', 'Gagal Mengubah Penulis: ' . mysqli_error($this->conn));
                }
            }

            header("Location: index.php?page=penulis");
            exit;
        }
    }


    public function hapusPenulis($id_penulis)
    {
        $id_penulis = mysqli_real_escape_string($this->conn, $id_penulis); // Escape ID


        $update_query = "DELETE FROM penulis WHERE ID_PENULIS = '$id_penulis'"; // 

        $result = mysqli_query($this->conn, $update_query);

        return $result;
    }
    public function deletePenulisFromForm()
    {
        if (isset($_GET['delete_id'])) {
            $id_penulis = $_GET['delete_id'];

            $result = $this->hapusPenulis($id_penulis);

            if ($result) {
                pesan('success', 'Penulis Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Penulis: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=penulis");
            exit;
        }
    }
}