<?php

class Member
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }





    public function addMember($id, $username, $password, $nama, $jenisIdentitas, $noIdentitas, $alamat, $level)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $username = mysqli_real_escape_string($this->conn, $username);
        $password = mysqli_real_escape_string($this->conn, $password);
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $jenisIdentitas = mysqli_real_escape_string($this->conn, $jenisIdentitas);
        $noIdentitas = mysqli_real_escape_string($this->conn, $noIdentitas);
        $alamat = mysqli_real_escape_string($this->conn, $alamat);
        $level = mysqli_real_escape_string($this->conn, $level);

        $insert_query = "INSERT INTO MEMBER (ID_MEMBER, USERNAME_MEMBER, PASSWORD_MEMBER, NAMA_MEMBER, JENIS_IDENTITAS, NOMOR_IDENTITAS, ALAMAT, level) 
                     VALUES ('$id', '$username', '$password', '$nama', '$jenisIdentitas', '$noIdentitas', '$alamat', '$level')";

        $result = mysqli_query($this->conn, $insert_query);

        return $result;
    }

    public function addMemberFromForm()
    {
        if (isset($_POST['submit'])) {
            $id = $_POST['id_member'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $nama = $_POST['nama'];
            $jenisIdentitas = $_POST['iden'];
            $noIdentitas = $_POST['noIdentitas'];
            $alamat = $_POST['alamat'];
            $level = $_POST['level'];

            $hashed_password = md5($password);

            // Assuming $book is an instance of your Book class
            $result = $this->addMember($id, $username, $hashed_password, $nama, $jenisIdentitas, $noIdentitas, $alamat, $level);

            if ($result) {
                ob_start();
                // Book added successfully
                // You can redirect to a success page or perform any other actions
                // For example, you can use header("Location: success.php");
                pesan('success', "Member Baru Ditambahkan.");
                header("Location: index.php?page=Member");
            } else {
                pesan('danger', "Gagal Menambahkan Member Karena: " . mysqli_error($this->conn));
            }
        }
    }


    public function edit($id, $username, $password, $nama, $jenisIdentitas, $noIdentitas, $alamat, $level)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $username = mysqli_real_escape_string($this->conn, $username);
        $password = mysqli_real_escape_string($this->conn, $password);
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $jenisIdentitas = mysqli_real_escape_string($this->conn, $jenisIdentitas);
        $noIdentitas = mysqli_real_escape_string($this->conn, $noIdentitas);
        $alamat = mysqli_real_escape_string($this->conn, $alamat);
        $level = mysqli_real_escape_string($this->conn, $level);

        $queryEditMember = "UPDATE member SET 
    USERNAME_MEMBER = '$username',
    PASSWORD_MEMBER = '$password',
    NAMA_MEMBER = '$nama',
    JENIS_IDENTITAS = '$jenisIdentitas',
    NOMOR_IDENTITAS = '$noIdentitas',
    ALAMAT = '$alamat',
    level = '$level'
    WHERE ID_MEMBER = '$id'";

        $result = mysqli_query($this->conn, $queryEditMember);

        return $result;
    }

    public function editMemberFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if (isset($_POST['update'])) {
                $id = $_POST['id_member1'];
                $username = $_POST['username1'];
                $password = $_POST['password1'];
                $nama = $_POST['nama1'];
                $jenisIdentitas = $_POST['iden1'];
                $noIdentitas = $_POST['noIden1'];
                $alamat = $_POST['alamat1'];
                $level = $_POST['level1'];


                // Assuming $book is an instance of your Book class
                $result = $this->edit($id, $username, $password, $nama, $jenisIdentitas, $noIdentitas, $alamat, $level);

                if ($result) {
                    ob_start();
                    pesan('success', "Member Telah Diedit.");
                    header("Location: index.php?page=Member");
                } else {
                    pesan('danger', "Gagal Edit Member Karena: " . mysqli_error($this->conn));
                }
            }
        }
    }



    public function hapusMember($idMember)
    {
        $idMember = mysqli_real_escape_string($this->conn, $idMember); // Escape ID


        $delete_query = "DELETE FROM member WHERE ID_MEMBER = '$idMember'"; // 

        $result = mysqli_query($this->conn, $delete_query);

        return $result;
    }
    public function hapusMemberFromForm()
    {
        if (isset($_GET['idMember'])) {
            $idMember = $_GET['idMember'];

            $result = $this->hapusMember($idMember);

            if ($result) {
                pesan('success', 'Member Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Member: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=member");
            exit;
        }
    }
}
