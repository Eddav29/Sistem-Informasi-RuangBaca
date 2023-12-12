
<?php
class Petugas
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getpetugas()
    {
        $petugas_query = "SELECT * FROM MEMBER";
        $petugas_result = mysqli_query($this->conn, $petugas_query);

        return $petugas_result;
    }

    public function getLastPetugas()
    {
        $last_petugas_query = "SELECT * FROM MEMBER ORDER BY ID_MEMBER DESC LIMIT 1";
        $last_petugas_result = mysqli_query($this->conn, $last_petugas_query);

        return $last_petugas_result;
    }

    public function searchpetugas($query)
    {
        $query = '%' . mysqli_real_escape_string($this->conn, $query) . '%';

        $sql = "SELECT * FROM MEMBER WHERE NAMA_MEMBER LIKE ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $query);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }


    public function addpetugas($new_id, $username_petugas, $password_petugas, $nama_petugas, $jenis_identitas, $nomor_identitas, $alamat, $level)
    {
        // Escape string values to prevent SQL injection
        $username_petugas = mysqli_real_escape_string($this->conn, $username_petugas);
        $password_petugas = mysqli_real_escape_string($this->conn, $password_petugas);
        $nama_petugas = mysqli_real_escape_string($this->conn, $nama_petugas);
        $jenis_identitas = mysqli_real_escape_string($this->conn, $jenis_identitas);
        $nomor_identitas = mysqli_real_escape_string($this->conn, $nomor_identitas);
        $alamat = mysqli_real_escape_string($this->conn, $alamat);
        $level = mysqli_real_escape_string($this->conn, $level);

        $insert_query = "INSERT INTO MEMBER (ID_MEMBER, USERNAME_MEMBER, PASSWORD_MEMBER, NAMA_MEMBER, JENIS_IDENTITAS, NOMOR_IDENTITAS, ALAMAT, level) 
                    VALUES ('$new_id', '$username_petugas', '$password_petugas', '$nama_petugas', '$jenis_identitas', '$nomor_identitas', '$alamat', '$level')";

        $result = mysqli_query($this->conn, $insert_query);

        return $result;
    }

    // public function addPetugasFromForm()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    //         $username_petugas = $_POST['username_petugas'];
    //         echo "Username: " . $username_petugas;
    //         // Assuming $book is an instance of your Book class
    //         $result = $this->addPetugas($username_petugas);
    //         $password_petugas = $_POST['password_petugas'];
    //         echo "Password: " . $password_petugas;
    //         // Assuming $book is an instance of your Book class
    //         $result = $this->addPetugas($password_petugas);
    //         $nama_petugas = $_POST['nama_petugas'];
    //         echo "Nama : " . $nama_petugas;
    //         // Assuming $book is an instance of your Book class
    //         $result = $this->addPetugas($nama_petugas);
    //         $jenis_identitas = $_POST['jenis_identitas'];
    //         echo "Jenis Identitas: " . $jenis_identitas;
    //         // Assuming $book is an instance of your Book class
    //         $result = $this->addPetugas($jenis_identitas);
    //         $nomor_identitas = $_POST['nomor_identitas'];
    //         echo "Nomor Identitas: " . $nomor_identitas;
    //         // Assuming $book is an instance of your Book class
    //         $result = $this->addPetugas($nomor_identitas);
    //         $alamat = $_POST['alamat'];
    //         echo "Alamat: " . $alamat;
    //         // Assuming $book is an instance of your Book class
    //         $result = $this->addPetugas($alamat);
    //         $level = $_POST['level'];
    //         echo "Level: " . $level;
    //         // Assuming $book is an instance of your Book class
    //         $result = $this->addPetugas($level);

    //         if ($result) {
    //             ob_start();
    //             // Book added successfully
    //             // You can redirect to a success page or perform any other actions
    //             // For example, you can use header("Location: success.php");
    //             pesan('success', "Petugas Baru Ditambahkan.");
    //             header("Location: index.php?page=petugas");
    //         } else {
    //             pesan('danger', "Gagal Menambahkan petugas Karena: " . mysqli_error($this->conn));
    //         }
    //     }

    // }

    // Menambah
    //     public function addPetugasFromForm()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    //         $username_petugas = $_POST['username_petugas'];
    //         $password_petugas = $_POST['password_petugas'];
    //         $nama_petugas = $_POST['nama_petugas'];
    //         $jenis_identitas = $_POST['jenis_identitas'];
    //         $nomor_identitas = $_POST['nomor_identitas'];
    //         $alamat = $_POST['alamat'];
    //         $level = $_POST['level'];

    //         $result = $this->addpetugas($username_petugas, $password_petugas, $nama_petugas, $jenis_identitas, $nomor_identitas, $alamat, $level);

    //         if ($result) {
    //             ob_start();
    //             pesan('success', "Petugas Baru Ditambahkan.");
    //             header("Location: index.php?page=petugas");
    //         } else {
    //             pesan('danger', "Gagal Menambahkan petugas Karena: " . mysqli_error($this->conn));
    //         }
    //     }
    // }

    public function addPetugasFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Mendapatkan data terakhir
            $last_petugas_data = $this->getLastPetugas();
            $last_petugas = mysqli_fetch_assoc($last_petugas_data);
            $last_id = $last_petugas['ID_MEMBER'];

            // Menentukan ID baru untuk petugas yang akan ditambahkan
            $new_id = intval($last_id) + 1;

            // Data dari form
            $username_petugas = $_POST['username_petugas'];
            $password_petugas = $_POST['password_petugas'];
            $nama_petugas = $_POST['nama_petugas'];
            $jenis_identitas = $_POST['jenis_identitas'];
            $nomor_identitas = $_POST['nomor_identitas'];
            $alamat = $_POST['alamat'];
            $level = $_POST['level'];

            // Menambahkan petugas baru dengan ID baru yang ditentukan
            $result = $this->addpetugas($new_id, $username_petugas, $password_petugas, $nama_petugas, $jenis_identitas, $nomor_identitas, $alamat, $level);

            if ($result) {
                ob_start();
                pesan('success', "Petugas Baru Ditambahkan.");
                header("Location: index.php?page=petugas");
            } else {
                pesan('danger', "Gagal Menambahkan petugas Karena: " . mysqli_error($this->conn));
            }
        }
    }


    //     public function editpetugas($id_petugas, $username_petugas, $password_petugas, $nama_petugas, $jenis_identitas, $nomor_identitas, $alamat, $level)
    //     {
    //     $id_petugas = mysqli_real_escape_string($this->conn, $id_petugas); // Escape ID
    //     $username_petugas = mysqli_real_escape_string($this->conn, $username_petugas);
    //     $password_petugas = mysqli_real_escape_string($this->conn, $password_petugas);
    //     $nama_petugas = mysqli_real_escape_string($this->conn, $nama_petugas);
    //     $jenis_identitas = mysqli_real_escape_string($this->conn, $jenis_identitas);
    //     $nomor_identitas = mysqli_real_escape_string($this->conn, $nomor_identitas);
    //     $alamat = mysqli_real_escape_string($this->conn, $alamat);
    //     $level = mysqli_real_escape_string($this->conn, $level);

    //     $update_query = "UPDATE member SET 
    //                         USERNAME_MEMBER = '$username_petugas', 
    //                         PASSWORD_MEMBER = '$password_petugas', 
    //                         NAMA_MEMBER = '$nama_petugas', 
    //                         JENIS_IDENTITAS = '$jenis_identitas', 
    //                         NOMOR_IDENTITAS = '$nomor_identitas', 
    //                         ALAMAT = '$alamat', 
    //                         level = '$level'
    //                     WHERE ID_MEMBER = '$id_petugas' "; // Menggunakan klausa WHERE untuk memperbarui baris tertentu

    //     $result = mysqli_query($this->conn, $update_query);

    //     return $result;
    // }
    public function editpetugas($id_petugas, $username_petugas, $password_petugas, $nama_petugas, $jenis_identitas, $nomor_identitas, $alamat, $level)
    {
        $id_petugas = mysqli_real_escape_string($this->conn, $id_petugas);
        $username_petugas = mysqli_real_escape_string($this->conn, $username_petugas);
        $password_petugas = mysqli_real_escape_string($this->conn, $password_petugas);
        $nama_petugas = mysqli_real_escape_string($this->conn, $nama_petugas);
        $jenis_identitas = mysqli_real_escape_string($this->conn, $jenis_identitas);
        $nomor_identitas = mysqli_real_escape_string($this->conn, $nomor_identitas);
        $alamat = mysqli_real_escape_string($this->conn, $alamat);
        $level = mysqli_real_escape_string($this->conn, $level);

        $update_query = "UPDATE MEMBER SET 
                        USERNAME_MEMBER = '$username_petugas', 
                        PASSWORD_MEMBER = '$password_petugas', 
                        NAMA_MEMBER = '$nama_petugas', 
                        JENIS_IDENTITAS = '$jenis_identitas', 
                        NOMOR_IDENTITAS = '$nomor_identitas', 
                        ALAMAT = '$alamat', 
                        level = '$level'
                    WHERE ID_MEMBER = '$id_petugas'";

        $result = mysqli_query($this->conn, $update_query);

        return $result;
    }

    public function editPetugasFromForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if (!empty($_POST['ID_MEMBER'])) {
                $id_petugas = $_POST['ID_MEMBER'];
                $username_petugas = $_POST['USERNAME_MEMBER'];
                $password_petugas = $_POST['PASSWORD_MEMBER'];
                $nama_petugas = $_POST['NAMA_MEMBER'];
                $jenis_identitas = $_POST['JENIS_IDENTITAS'];
                $nomor_identitas = $_POST['NOMOR_IDENTITAS'];
                $alamat = $_POST['ALAMAT'];
                $level = $_POST['level'];

                $result = $this->editpetugas($id_petugas, $username_petugas, $password_petugas, $nama_petugas, $jenis_identitas, $nomor_identitas, $alamat, $level);

                if ($result) {
                    pesan('success', 'Petugas Telah Diubah.');
                    header('Location: http://localhost/Sistem-Informasi-RuangBaca/index.php?page=petugas');
                } else {
                    pesan('danger', 'Gagal Mengubah Petugas: ' . mysqli_error($this->conn));
                }
            }

            header("Location: index.php?page=petugas");
            exit;
        }
    }


    public function hapusPetugas($id_petugas)
    {
        $id_petugas = mysqli_real_escape_string($this->conn, $id_petugas);

        $delete_query = "DELETE FROM member WHERE ID_MEMBER = '$id_petugas'";

        $result = mysqli_query($this->conn, $delete_query);

        return $result;
    }

    public function deletePetugasFromForm()
    {
        if (isset($_GET['delete_id'])) {
            $id_petugas = $_GET['delete_id'];

            $result = $this->hapusPetugas($id_petugas);

            if ($result) {
                pesan('success', 'Petugas Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Petugas: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=petugas");
            exit;
        }
    }
}
