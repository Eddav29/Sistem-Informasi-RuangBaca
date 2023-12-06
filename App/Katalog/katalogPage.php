<?php
$showSearch = true;
include("../../Config/koneksi.php");
include("../../Functions/Book.php");
include("./katalog.php");
$db = new Database();
// Get the database connection
$conn = $db->getConnection();

<<<<<<< Updated upstream
$bookCatalog = new Book($conn);

// Handle form submission
if (
    $_SERVER["REQUEST_METHOD"] == "GET"
) {
    // Get selected authors and categories
    $selectedAuthors = isset($_GET['authors']) ? $_GET['authors'] : array();
    $selectedCategories = isset($_GET['categories']) ? $_GET['categories'] : array();

    // Get authors and categories from the database
    $authorsResult = $bookCatalog->getAuthors();
    $categoriesResult = $bookCatalog->getCategories();

    // Get books based on selected authors and categories
    $booksResult = $bookCatalog->getBooks($selectedAuthors, $selectedCategories);
    $totalBooks = mysqli_num_rows($booksResult);

    // Pagination
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $booksPerPage = 6;
    $offset = ($currentPage - 1) * $booksPerPage;

    $booksResult = $bookCatalog->getBooksPerPage($selectedAuthors, $selectedCategories, $booksPerPage, $offset);
}
$totalPages = ceil($totalBooks / $booksPerPage);
?>
<br>
<br>
<br>
<br>
<!-- HTML Rendering -->
<div class="container ms-5">
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-md-3">
            <form action="" method="GET">
                <div class="card shadow mb-4">
                    <div class="card-header bg-darkblue text-white">
                        <h5 class="mb-0">Filter</h5>
                    </div>
                    <div class="card-body">
                        <h6>Penulis</h6>
                        <div class="form-group">
                            <?php
                            while ($author = mysqli_fetch_assoc($authorsResult)) {
                                echo "<div class='form-check'>";
                                echo "<input class='form-check-input' type='checkbox' name='authors[]' value='" . $author['ID_PENULIS'] . "' " . (in_array($author['ID_PENULIS'], $selectedAuthors) ? "checked" : "") . " />";
                                echo "<label class='form-check-label'>" . $author['NAMA_PENULIS'] . "</label>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                        <hr>
                        <h6>Kategori</h6>
                        <div class="form-group">
                            <?php
                            while ($category = mysqli_fetch_assoc($categoriesResult)) {
                                echo "<div class='form-check'>";
                                echo "<input class='form-check-input' type='checkbox' name='categories[]' value='" . $category['ID_KATEGORI'] . "' " . (in_array($category['ID_KATEGORI'], $selectedCategories) ? "checked" : "") . " />";
                                echo "<label class='form-check-label'>" . $category['NAMA_KATEGORI'] . "</label>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Book Items - Products -->
        <div class="col-md-9 ">
            <div class="card">
                <div class="card-header bg-darkblue text-white">
                    <h5 class="mb-0">katalog</h5>
                </div>
                <div class="card-body row" id="katalogContent">
                    <?php while ($book = mysqli_fetch_assoc($booksResult)) : ?>
                        <div class='col-lg-4 col-md-6 mb-4'>
                            <div class='card h-100'>
                                <img src='<?php echo $book['IMG']; ?>' class='card-img-top' alt='<?php echo $book['JUDUL_BUKU']; ?>'>
                                <div class='card-body'>
                                    <h5 class='card-title'><?php echo $book['JUDUL_BUKU']; ?></h5>
                                    <p class='card-text'><?php echo $book['DESKRIPSI']; ?></p>

                                    <!-- Display authors -->
                                    <?php
                                    $author_query = "SELECT P.NAMA_PENULIS FROM PENULIS P
                                    JOIN DETAIL_PENULIS_BUKU DPB ON P.ID_PENULIS = DPB.ID_PENULIS
                                    WHERE DPB.ID_BUKU = " . $book['ID_BUKU'];
                                    $author_result = mysqli_query($conn, $author_query);
                                    if ($author_result) : ?>
                                        <p class='card-text'><strong>Penulis:</strong>
                                            <?php
                                            $authors = array();
                                            while ($author_row = mysqli_fetch_assoc($author_result)) {
                                                $authors[] = $author_row['NAMA_PENULIS'];
                                            }
                                            echo implode(", ", $authors);
                                            ?>
                                        </p>
                                    <?php endif; ?>

                                    <!-- Display categories -->
                                    <?php
                                    $category_query = "SELECT K.NAMA_KATEGORI FROM KATEGORI K
                                    JOIN DETAIL_KATEGORI_BUKU DKB ON K.ID_KATEGORI = DKB.ID_KATEGORI
                                    WHERE DKB.ID_BUKU = " . $book['ID_BUKU'];
                                    $category_result = mysqli_query($conn, $category_query);
                                    if ($category_result) : ?>
                                        <p class='card-text'><strong>Kategori:</strong>
                                            <?php
                                            $categories = array();
                                            while ($category_row = mysqli_fetch_assoc($category_result)) {
                                                $categories[] = $category_row['NAMA_KATEGORI'];
                                            }
                                            echo implode(", ", $categories);
                                            ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <!-- Pagination -->
                    <div class="container mt-5">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php if ($currentPage > 1) : ?>
                                    <li class='page-item'>
                                        <a class='page-link' href='?page=<?php echo ($currentPage - 1); ?>'>&laquo; Previous</a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                    <li class='page-item <?php echo ($currentPage == $i ? 'active' : ''); ?>'>
                                        <a class='page-link' href='?page=<?php echo $i; ?>'><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($currentPage < $totalPages) : ?>
                                    <li class='page-item'>
                                        <a class='page-link' href='?page=<?php echo ($currentPage + 1); ?>'>Next &raquo;</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
=======
include("katalog.php");

?>

<section id="katalog" class="container">

</section>
>>>>>>> Stashed changes
