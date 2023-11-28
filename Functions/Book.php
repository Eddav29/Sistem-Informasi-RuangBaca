<?php

class Book
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
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
    public function getLiveSearchResults($searchTerm)
    {
        $searchTerm = mysqli_real_escape_string($this->conn, $searchTerm);

        $query = "SELECT JUDUL_BUKU FROM BUKU WHERE JUDUL_BUKU LIKE '%$searchTerm%'";
        $result = mysqli_query($this->conn, $query);

        $results = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
        }

        return $results;
    }
}
