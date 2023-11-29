<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
if (!empty($_SESSION['level'])) {
    require 'Config/koneksi.php';


    include 'App/Admin/header.php';
    if (!empty($_GET['page'])) {
        include 'App/Admin/' . $_GET['page'] . '/index.php';
    } else {
        include 'App/Admin/home.php';
    }
    include 'App/Admin/footer.php';
} else {
    header("Location: ./App/Katalog/index.php");
}
