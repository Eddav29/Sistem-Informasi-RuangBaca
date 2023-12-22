<?php
// Sertakan file konfigurasi dan fungsi Book
include("../Config/koneksi.php");
include("Book.php");

// Inisialisasi objek database dan koneksi
$db = new Database();
$conn = $db->getConnection();

// Inisialisasi objek Book
$bookCatalog = new Book($conn);

// Ambil nilai query dari request POST
$query = isset($_POST['query']) ? $_POST['query'] : '';
// Lakukan pencarian buku berdasarkan query
$searchResults = $bookCatalog->searchBooks($query);

// Tampilkan hasil pencarian
// Tampilkan hasil pencarian
while ($book = mysqli_fetch_assoc($searchResults)) {
    echo "<div class='col'>";
    echo "<div class='card h-100'>";
    echo "<img src='../../Assets/img/" . $book['IMG'] . "' class='card-img-top' alt='" . $book['JUDUL_BUKU'] . "'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $book['JUDUL_BUKU'] . "</h5>";
    echo "<p class='card-text'>" . $book['DESKRIPSI'] . "</p>";

    // Fetch and display authors for the book
    $author_query = "SELECT P.NAMA_PENULIS FROM PENULIS P
                        JOIN DETAIL_PENULIS_BUKU DPB ON P.ID_PENULIS = DPB.ID_PENULIS
                        WHERE DPB.ID_BUKU = " . $book['ID_BUKU'];
    $author_result = mysqli_query($conn, $author_query);
    if ($author_result) {
        echo "<p class='card-text'><strong>Penulis:</strong> ";
        $authors = array();
        while ($author_row = mysqli_fetch_assoc($author_result)) {
            $authors[] = $author_row['NAMA_PENULIS'];
        }
        echo implode(", ", $authors);
        echo "</p>";
    }
    // Fetch and display categories for the book
    $category_query = "SELECT K.NAMA_KATEGORI FROM KATEGORI K
                        JOIN DETAIL_KATEGORI_BUKU DKB ON K.ID_KATEGORI = DKB.ID_KATEGORI
                        WHERE DKB.ID_BUKU = " . $book['ID_BUKU'];
    $category_result = mysqli_query($conn, $category_query);
    if ($category_result) {
        echo "<p class='card-text'><strong>Kategori:</strong> ";
        $categories = array();
        while ($category_row = mysqli_fetch_assoc($category_result)) {
            $categories[] = $category_row['NAMA_KATEGORI'];
        }
        echo implode(", ", $categories);
        echo "</p>";
    }

    echo "</div>";
    echo "</div>";
    echo "</div>";
}
