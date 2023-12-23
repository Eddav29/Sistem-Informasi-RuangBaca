<?php

class Book
{
    private $conn;



    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createBuku()
    {
        if (!empty($_SESSION['judul_buku'])) {
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

        $sql .= " LIMIT " . $perPage . " OFFSET " . $offset;

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }
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
                        VALUES (?,?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($insert_query);
        $stmt->bind_param("sssssssss", $judul, $deskripsi, $ketersediaan, $tanggal_pengadaan, $tahun_terbit, $penerbit, $rak ,$img ,$status_buku);

        if($stmt->execute()){
            $newBookID = $stmt->insert_id;

            $pilihKategori = $_POST['kategori'];
            foreach($pilihKategori as $categoryId){
                $insertKategori = "INSERT INTO detail_kategori_buku (ID_BUKU, ID_KATEGORI) VALUES (?,?)";
                $stmtKategori = $this->conn->prepare($insertKategori);
                $stmtKategori->bind_param("ii", $newBookID, $categoryId);
                $stmtKategori->execute();
                $stmtKategori->close();
        
            }
            $pilihPenulis = $_POST['penulis'];
            foreach($pilihPenulis as $penulisId){
                $insertPenulis = "INSERT INTO detail_penulis_buku (ID_BUKU, ID_PENULIS) VALUES (?,?)";
                $stmtPenulis = $this->conn->prepare($insertPenulis);
                $stmtPenulis->bind_param("ii", $newBookID, $penulisId);
                $stmtPenulis->execute();
                $stmtPenulis->close();
        
            }
            return true;
            
        }else{
            return false;
        }


        

        
    }

    public function addBookFromForm()
{
    $statusMsg = '';
    $dir = "Assets/img/";

    if (isset($_POST['submit'])) {
        if (!empty($_FILES["file"]["name"])) {
            $namaFile = ($_FILES["file"]["name"]);
            $filePath = $dir . $namaFile;
            $tipeFile = pathinfo($filePath, PATHINFO_EXTENSION);

            $allowedExtensions = array('jpg', 'png', 'jpeg');
            if (in_array($tipeFile, $allowedExtensions)) {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
                    $judul_buku = $_POST['judul_buku'];
                    $deskripsi = $_POST['deskripsi'];
                    $ketersediaan = $_POST['ketersediaan'];
                    $tanggal_pengadaan = $_POST['tanggal_pengadaan'];
                    $tahun_penerbit = $_POST['tahun_terbit'];
                    $penerbit = $_POST['penerbit'];
                    $rak = $_POST['rak'];
                    $img = $namaFile;
                    $status_buku = $_POST['status_buku'];

                    $result = $this->addBook($judul_buku, $deskripsi, $ketersediaan, $tanggal_pengadaan, $tahun_penerbit, $penerbit, $rak, $img, $status_buku);

                    if ($result) {
                        pesan('success', "Buku Baru Ditambahkan.");
                        header("Location: index.php?page=Buku");
                        exit(); 
                    } else {
                        pesan('danger', "Gagal Menambahkan Buku Karena: " . mysqli_error($this->conn));
                        // header("Location: index.php?page=Buku");
                    }
                } else {
                    pesan('danger', "Gagal Memindahkan File.");
                    header("Location: index.php?page=Buku");
                }
            } else {
                pesan('danger', "Tipe file tidak valid: " . implode(', ', $allowedExtensions));
            }
        } else {
            pesan('danger', "Isi Image.");
        }
    }
}

    public function hapusBuku($idBuku)
    {
        $idBuku = mysqli_real_escape_string($this->conn, $idBuku); 


        $delete_query = "DELETE FROM buku WHERE ID_BUKU = '$idBuku'"; 

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



    
public function edit($judul_buku, $deskripsi, $ketersediaan, $tanggal_pengadaan, $tahun_terbit, $penerbit, $rak, $img, $status_buku, $id, $selectedCategories, $selectedAuthors)
{
    $judul_buku = mysqli_real_escape_string($this->conn, $judul_buku);
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
        JUDUL_BUKU = ?,
        DESKRIPSI = ?,
        KETERSEDIAAN = ?,
        TANGGAL_PENGADAAN = ?,
        TAHUN_TERBIT = ?,
        PENERBIT = ?,
        RAK = ?,
        IMG = ?,
        STATUS_BUKU = ?
        WHERE ID_BUKU = ?";

    $stmt = $this->conn->prepare($queryEditBuku);
    $stmt->bind_param("sssssssssi", $judul_buku, $deskripsi, $ketersediaan, $tanggal_pengadaan, $tahun_terbit, $penerbit, $rak, $img, $status_buku, $id);
    $result = $stmt->execute();
    $stmt->close();

    
    $this->updateCategoriesForBook($id, $selectedCategories);

    
    $this->updateAuthorsForBook($id, $selectedAuthors);

    return $result;
}



public function updateCategoriesForBook($bookId, $selectedCategories)
{
    $deleteQuery = "DELETE FROM detail_kategori_buku WHERE ID_BUKU = ?";
    $deleteStmt = $this->conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $bookId);
    $deleteStmt->execute();
    $deleteStmt->close();

    
    $insertQuery = "INSERT INTO detail_kategori_buku (ID_BUKU, ID_KATEGORI) VALUES (?, ?)";
    $insertStmt = $this->conn->prepare($insertQuery);

    foreach ($selectedCategories as $categoryId) {
        $insertStmt->bind_param("ii", $bookId, $categoryId);
        $insertStmt->execute();
    }
    

    $insertStmt->close();
}

public function updateAuthorsForBook($bookId, $selectedAuthors)
{
    
    if (!is_array($selectedAuthors)) {
        $selectedAuthors = [];
    }

    
    $deleteQuery = "DELETE FROM detail_penulis_buku WHERE ID_BUKU = ?";
    $deleteStmt = $this->conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $bookId);
    $deleteStmt->execute();
    $deleteStmt->close();

    
    foreach ($selectedAuthors as $penulisId) {
        $insertQuery = "INSERT INTO detail_penulis_buku (ID_BUKU, ID_PENULIS) VALUES (?, ?)";
        $insertStmt = $this->conn->prepare($insertQuery);
        $insertStmt->bind_param("ii", $bookId, $penulisId);
        $insertStmt->execute();
        $insertStmt->close();
    }
}


public function editBookFromForm()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $id = $_POST['bookId'];
        $judul_buku = $_POST['judul_buku1'];
        $deskripsi = $_POST['deskripsi1'];
        $ketersediaan = $_POST['ketersediaan1'];
        $tanggal_pengadaan = $_POST['tanggal_pengadaan1'];
        $tahun_terbit = $_POST['tahun_terbit1'];
        $penerbit = $_POST['penerbit1'];
        $rak = $_POST['rak1'];
        
        $status_buku = $_POST['status_buku1'];

        if (!empty($_FILES["newFile"]["name"])) {
            $dir = "Assets/img/";
            $namaFile = ($_FILES["newFile"]["name"]);
            $filePath = $dir . $namaFile;
            $tipeFile = pathinfo($filePath, PATHINFO_EXTENSION);
    
            $allowedExtensions = array('jpg', 'png', 'jpeg');
            if (in_array($tipeFile, $allowedExtensions)) {
                if (move_uploaded_file($_FILES["newFile"]["tmp_name"], $filePath)) {
                    $img = $namaFile;
                } else {
                    pesan('danger', "Gagal Memindahkan File.");
                    header("Location: index.php?page=Buku");
                    exit();
                }
            } else {
                pesan('danger', "Tipe file tidak valid: " . implode(', ', $allowedExtensions));
                header("Location: index.php?page=Buku");
                exit();
            }
        }else{
            $img = $_POST['img1'];
        }
        
        $selectedCategories = $_POST['kategori1']; 
        $selectedAuthors = $_POST['penulis1']; 

        $result = $this->edit($judul_buku, $deskripsi, $ketersediaan, $tanggal_pengadaan, $tahun_terbit, $penerbit, $rak, $img, $status_buku, $id, $selectedCategories, $selectedAuthors);

        if ($result) {
            pesan('success', "Buku Telah Diupdate.");
            header("Location: index.php?page=Buku");
            exit();
        } else {
            pesan('danger', "Gagal Edit Buku Karena: " . mysqli_error($this->conn));
            header("Location: index.php?page=Buku");
            exit();
        }
    }
}

    
}
