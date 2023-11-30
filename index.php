<?php
if (session_status() === PHP_SESSION_NONE){
    session_start();
    if (isset($_SESSION["userID"]) && isset($_SESSION["userLevel"])) {
        include "Config/koneksi.php";
        $userLevel = $_SESSION["userLevel"];

        if($userLevel == "Admin"){
            if (!empty($_GET['page'])) {
                ob_start();
                include 'App/Admin/header.php';
                include 'App/Admin/' . $_GET['page'] . '/index.php';
                include 'App/Admin/footer.php';
                ob_end_flush();
            } else {
                include 'App/Admin/indexAdmin.php';
            }
        }
        
    } else {
        header("Location: App/Katalog/index.php");
    }
}

