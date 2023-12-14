<?php
class Kategori
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getkategori()
    {
        $kategori_query = "SELECT * FROM KATEGORI";
        $kategori_result = mysqli_query($this->conn, $kategori_query);

        return $kategori_result;
    }


    public function searchkategori($query)
    {
        $query = '%' . mysqli_real_escape_string($this->conn, $query) . '%';

        $sql = "SELECT * FROM KATEGORI WHERE NAMA_KATEGORI LIKE ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $query);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }
    public function addkategori($nama_kategori)
    {
        $nama_kategori = mysqli_real_escape_string($this->conn, $nama_kategori);

        $insert_query = "INSERT INTO KATEGORI (NAMA_KATEGORI) VALUES ('$nama_kategori')";
        $result = mysqli_query($this->conn, $insert_query);

        return $result;
    }



    public function addKategoriFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $nama_kategori = $_POST['nama_kategori'];
            echo "Nama Kategori: " . $nama_kategori;
            // Assuming $book is an instance of your Book class
            $result = $this->addKategori($nama_kategori);

            if ($result) {
                ob_start();
                // Book added successfully
                // You can redirect to a success page or perform any other actions
                // For example, you can use header("Location: success.php");
                pesan('success', "Kategori Baru Ditambahkan.");
                header("Location: index.php?page=kategori");
            } else {
                pesan('danger', "Gagal Menambahkan kategori Karena: " . mysqli_error($this->conn));
            }
        }
    }
    // Kategori.php

    public function editKategori($id_kategori, $nama_kategori)
    {
        $id_kategori = mysqli_real_escape_string($this->conn, $id_kategori);
        $nama_kategori = mysqli_real_escape_string($this->conn, $nama_kategori);

        $update_query = "UPDATE kategori SET NAMA_KATEGORI = '$nama_kategori' WHERE ID_KATEGORI = '$id_kategori'";
        $result = mysqli_query($this->conn, $update_query);

        return $result;
    }

    public function editKategoriFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if (!empty($_POST['ID_KATEGORI']) && !empty($_POST['NAMA_KATEGORI'])) {
                $id_kategori = $_POST['ID_KATEGORI'];
                $nama_kategori = $_POST['NAMA_KATEGORI'];

                $result = $this->editKategori($id_kategori, $nama_kategori);

                if ($result) {
                    ob_start();
                    pesan('success', 'kategori Telah Diubah.');
                    header("Location: index.php?page=kategori");
                } else {
                    pesan('danger', 'Gagal Mengubah kategori: ' . mysqli_error($this->conn));
                }
            }

            header("Location: index.php?page=Kategori");
            exit;
        }
    }


    public function hapusKategori($id_kategori)
    {
        $id_kategori = mysqli_real_escape_string($this->conn, $id_kategori); // Escape ID


        $update_query = "DELETE FROM kategori WHERE ID_KATEGORI = '$id_kategori'"; // 

        $result = mysqli_query($this->conn, $update_query);

        return $result;
    }
    public function deleteKategoriFromForm()
    {
        if (isset($_GET['id'])) {
            $id_kategori = $_GET['id'];

            $result = $this->hapusKategori($id_kategori);

            if ($result) {
                ob_start();
                pesan('success', 'Kategori Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Kategori: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=kategori");
            exit;
        }
    }
}
