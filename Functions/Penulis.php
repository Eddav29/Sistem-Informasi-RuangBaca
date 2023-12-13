<?php

class Penulis
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    public function addPenulis($id, $namapenulis)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $namapenulis = mysqli_real_escape_string($this->conn, $namapenulis);
        
        $insert_query = "INSERT INTO PENULIS (ID_PENULIS, NAMA_PENULIS) 
                     VALUES ('$id', '$namapenulis')";

        $result = mysqli_query($this->conn, $insert_query);

        return $result;
    }

    public function addPenulisFromForm()
    {
        if (isset($_POST['submit'])) {
            $id = $_POST['id_penulis'];
            $namapenulis = $_POST['namapenulis'];
            
            //$hashed_password = md5($password);

            // Assuming $book is an instance of your Book class
            $result = $this->addPenulis($id, $namapenulis);

            if ($result) {
                ob_start();
                // Book added successfully
                // You can redirect to a success page or perform any other actions
                // For example, you can use header("Location: success.php");
                pesan('success', "Penulis Baru Ditambahkan.");
                header("Location: index.php?page=Penulis");
            } else {
                pesan('danger', "Gagal Menambahkan Penulis Karena: " . mysqli_error($this->conn));
            }
        }
    }


    public function edit($id, $namapenulis)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $namapenulis = mysqli_real_escape_string($this->conn, $namapenulis);

        $queryEditPenulis = "UPDATE penulis SET 
    NAMA_PENULIS = '$namapenulis'
    WHERE ID_PENULIS = '$id'";

        $result = mysqli_query($this->conn, $queryEditPenulis);

        return $result;
    }

    public function editPenulisFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if (isset($_POST['update'])) {
                $id = $_POST['id_penulis1'];
                $namapenulis = $_POST['namapenulis1'];


                // Assuming $book is an instance of your Book class
                $result = $this->edit($id, $namapenulis);

                if ($result) {
                    ob_start();
                    pesan('success', "Member Telah Diedit.");
                    header("Location: index.php?page=Penulis");
                } else {
                    pesan('danger', "Gagal Edit Penulis Karena: " . mysqli_error($this->conn));
                }
            }
        }
    }



    public function hapusPenulis($idPenulis)
    {
        $idPenulis = mysqli_real_escape_string($this->conn, $idPenulis); // Escape ID


        $delete_query = "DELETE FROM penulis WHERE ID_PENULIS = '$idPenulis'"; // 

        $result = mysqli_query($this->conn, $delete_query);

        return $result;
    }
    public function hapusPenulisFromForm()
    {
        if (isset($_GET['idPenulis'])) {
            $idPenulis = $_GET['idPenulis'];

            $result = $this->hapusPenulis($idPenulis);

            if ($result) {
                pesan('success', 'Penulis Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Penulis: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=Penulis");
            exit;
        }
    }
}
