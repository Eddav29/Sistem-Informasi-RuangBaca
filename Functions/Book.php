<?php

class Book
{
    private $conn;
    

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createBuku(){
        if(!empty($_SESSION['judul_buku'])){
            require '../Config/koneksi.php';

        }
    }

    public function getAuthors()
    {
        $authors_query = "SELECT * FROM PENULIS";
        $authors_result = mysqli_query($this->conn, $authors_query);

        return $authors_result;
    }

    public function getCategories()
    {
        $categories_query = "SELECT * FROM KATEGORI";
        $categories_result = mysqli_query($this->conn, $categories_query);

        return $categories_result;
    }

    public function getBooks($selectedAuthors, $selectedCategories)
    {
        $sql = "SELECT DISTINCT B.* FROM BUKU B
                LEFT JOIN DETAIL_PENULIS_BUKU DPB ON B.ID_BUKU = DPB.ID_BUKU
                LEFT JOIN DETAIL_KATEGORI_BUKU DKB ON B.ID_BUKU = DKB.ID_BUKU
                WHERE 1=1";

        if (!empty($selectedAuthors)) {
            $authorCondition = " AND DPB.ID_PENULIS IN (" . implode(",", $selectedAuthors) . ")";
            $sql .= $authorCondition;
        }

        if (!empty($selectedCategories)) {
            $categoryCondition = " AND DKB.ID_KATEGORI IN (" . implode(",", $selectedCategories) . ")";
            $sql .= $categoryCondition;
        }

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

    public function getBooksPerPage($selectedAuthors, $selectedCategories, $perPage = 6, $offset = 0)
    {
        $sql = "SELECT DISTINCT B.* FROM BUKU B
            LEFT JOIN DETAIL_PENULIS_BUKU DPB ON B.ID_BUKU = DPB.ID_BUKU
            LEFT JOIN DETAIL_KATEGORI_BUKU DKB ON B.ID_BUKU = DKB.ID_BUKU
            WHERE 1=1";

        if (!empty($selectedAuthors)) {
            $authorCondition = " AND DPB.ID_PENULIS IN (" . implode(",", $selectedAuthors) . ")";
            $sql .= $authorCondition;
        }

        if (!empty($selectedCategories)) {
            $categoryCondition = " AND DKB.ID_KATEGORI IN (" . implode(",", $selectedCategories) . ")";
            $sql .= $categoryCondition;
        }

        // Add pagination limit and offset
        $sql .= " LIMIT " . $perPage . " OFFSET " . $offset;

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }
    // search
    // Metode untuk melakukan pencarian buku berdasarkan judul
    public function searchBooks($query)
    {
        $query = '%' . mysqli_real_escape_string($this->conn, $query) . '%';

        $sql = "SELECT * FROM BUKU WHERE JUDUL_BUKU LIKE ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $query);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return $result;
    }

    public function addBook($judul, $deskripsi, $ketersediaan, $tanggal_pengadaan, $tahun_terbit, $penerbit, $rak, $img, $status_buku)
{
    $judul = mysqli_real_escape_string($this->conn, $judul);
    $deskripsi = mysqli_real_escape_string($this->conn, $deskripsi);
    $ketersediaan = mysqli_real_escape_string($this->conn, $ketersediaan);
    $tanggal_pengadaan = mysqli_real_escape_string($this->conn, $tanggal_pengadaan);
    $tahun_terbit = mysqli_real_escape_string($this->conn, $tahun_terbit);
    $penerbit = mysqli_real_escape_string($this->conn, $penerbit);
    $rak = mysqli_real_escape_string($this->conn, $rak);
    $img = mysqli_real_escape_string($this->conn, $img);
    $status_buku = mysqli_real_escape_string($this->conn, $status_buku);

    $insert_query = "INSERT INTO BUKU (JUDUL_BUKU, DESKRIPSI, KETERSEDIAAN, TANGGAL_PENGADAAN, TAHUN_TERBIT, PENERBIT, RAK, IMG, STATUS_BUKU) 
                     VALUES ('$judul', '$deskripsi', '$ketersediaan', '$tanggal_pengadaan', '$tahun_terbit', '$penerbit', '$rak', '$img', '$status_buku')";

    $result = mysqli_query($this->conn, $insert_query);

    return $result;
}

public function addBookFromForm()
{
    if (isset($_POST['submit'])) {
        $judul_buku = $_POST['judul_buku'];
        $deskripsi = $_POST['deskripsi'];
        $ketersediaan = $_POST['ketersediaan'];
        $tanggal_pengadaan = $_POST['tanggal_pengadaan'];
        $tahun_penerbit = $_POST['tahun_penerbit'];
        $penerbit = $_POST['penerbit'];
        $rak = $_POST['rak'];
        $img = $_POST['img'];
        $status_buku = $_POST['status_buku'];

        // Assuming $book is an instance of your Book class
        $result = $this->addBook($judul_buku, $deskripsi, $ketersediaan, $tanggal_pengadaan, $tahun_penerbit, $penerbit, $rak, $img, $status_buku);

        if ($result) {
            ob_start();
            // Book added successfully
            // You can redirect to a success page or perform any other actions
            // For example, you can use header("Location: success.php");
            pesan('success', "Jabatan Baru Ditambahkan.");
            header("Location: index.php?page=Buku");
        } else {
            pesan('danger', "Gagal Menambahkan Jabatan Karena: " . mysqli_error($this->conn));
        }
    }
}


public function edit($judul_buku, $deskripsi, $ketersediaan, $tanggal_pengadaan, $tahun_penerbit, $penerbit, $rak, $img, $status_buku, $id){
    $judul_buku = mysqli_real_escape_string($this->conn, $judul);
    $deskripsi = mysqli_real_escape_string($this->conn, $deskripsi);
    $ketersediaan = mysqli_real_escape_string($this->conn, $ketersediaan);
    $tanggal_pengadaan = mysqli_real_escape_string($this->conn, $tanggal_pengadaan);
    $tahun_terbit = mysqli_real_escape_string($this->conn, $tahun_terbit);
    $penerbit = mysqli_real_escape_string($this->conn, $penerbit);
    $rak = mysqli_real_escape_string($this->conn, $rak);
    $img = mysqli_real_escape_string($this->conn, $img);
    $status_buku = mysqli_real_escape_string($this->conn, $status_buku);
    $id = mysqli_real_escape_string($this->conn, $id);

    $queryEditBuku = "UPDATE buku SET 
    JUDUL_BUKU = '$judul_buku',
    DESKRIPSI = '$deskripsi',
    KETERSEDIAAN = '$ketersediaan',
    TANGGAL_PENGADAAN = '$tanggal_pengadaan',
    TAHUN_TERBIT = '$tahun_terbit',
    PENERBIT = '$penerbit',
    RAK = '$rak',
    IMG = '$img',
    STATUS_BUKU = '$status_buku'
    WHERE ID_BUKU = $id";

    $result = mysqli_query($this->conn, $queryEditBuku);

    return $result;
    
}

public function editBookFromForm()
{
    if (isset($_POST['save'])) {

        $id = $_POST['bookId'];  // Remove the # symbol
        $judul_buku = $_POST['judul_buku1'];
        $deskripsi = $_POST['deskripsi1'];
        $ketersediaan = $_POST['ketersediaan1'];
        $tanggal_pengadaan = $_POST['tanggal_pengadaan1'];
        $tahun_terbit = $_POST['tahun_terbit1'];
        $penerbit = $_POST['penerbit1'];
        $rak = $_POST['rak1'];
        $img = $_POST['img1'];
        $status_buku = $_POST['status_buku1'];

        

        // Assuming $book is an instance of your Book class
        $result = $this->edit($judul_buku, $deskripsi, $ketersediaan, $tanggal_pengadaan, $tahun_penerbit, $penerbit, $rak, $img, $status_buku, $id);

        if ($result) {
            ob_start();

            pesan('success', "Buku Telah Diupdate.");
            header("Location: index.php?page=Buku");
        } else {
            pesan('danger', "Gagal Edit Buku Karena: " . mysqli_error($this->conn));
        }
    } else {
        echo "err";
    }
}



public function hapusBuku($idBuku)
    {
        $idBuku = mysqli_real_escape_string($this->conn, $idBuku); // Escape ID


        $delete_query = "DELETE FROM buku WHERE ID_BUKU = '$idBuku'"; // 

        $result = mysqli_query($this->conn, $delete_query);

        return $result;
    }
    public function hapusBukuFromForm()
    {
        if (isset($_GET['idBuku'])) {
            $idBuku = $_GET['idBuku'];

            $result = $this->hapusBuku($idBuku);

            if ($result) {
                pesan('success', 'Buku Telah Dihapus.');
            } else {
                pesan('danger', 'Gagal Menghapus Buku: ' . mysqli_error($this->conn));
            }

            header("Location: index.php?page=buku");
            exit;
        }
    }

}
