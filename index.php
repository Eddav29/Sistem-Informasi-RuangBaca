<!-- 
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
} -->

<?php
// if (session_status() === PHP_SESSION_NONE)
//     session_start();
//     include "Config/koneksi.php";
// if (empty($_SESSION['level'])) {
    
//     include 'App/Admin/indexAdmin.php';

//     // include 'App/Admin/header.php';
//     // include 'App/Admin/home.php';
//     // include 'App/Admin/footer.php';
//     // if (!empty($_GET['page'])) {
//     //     include 'App/Admin/' . $_GET['page'] . '/index.php';
//     // } else {
//     //     include 'App/Admin/home.php';
//     // }
//     // include 'App/Admin/footer.php';
// } else {
//     header("Location: ./App/Katalog/index.php");
// }

// if (session_status() === PHP_SESSION_NONE){
//     session_start();
// }
//     include "Config/koneksi.php";
// if(!isset($_SESSION["username"]) || $_SESSION["level"] == 'Admin'){
//     include 'App/Admin/indexAdmin.php';
// 


if (session_status() === PHP_SESSION_NONE){
    session_start();
}
    include "Config/koneksi.php";
if(isset($_SESSION["username"]) && $_SESSION["userLevel"] == "Admin"){
    if(!empty($_GET['page'])){
        include 'App/Admin/header.php';
        include 'App/Admin/' . $_GET['page'] . '/index.php';
        include 'App/Admin/footer.php';
    }else{
        include 'App/Admin/indexAdmin.php';
    }
}


// <?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// include "Config/koneksi.php";

// if (isset($_SESSION["username"]) && isset($_SESSION["userLevel"])) {
//     // Check if the user level is 'Admin'
//     if ($_SESSION["userLevel"] == 'Admin') {
//         if (!empty($_GET['page'])) {
//             include 'App/Admin/header.php';
//             include 'App/Admin/' . $_GET['page'] . '/index.php';
//             include 'App/Admin/footer.php';
//         } else {
//             include 'App/Admin/indexAdmin.php';
//         }
//     } else {
//         // Handle other user levels (if needed)
//         header("Location: non_admin_page.php");
//         exit();
//     }
// } else {
//     // Redirect to login page if not logged in
//     header("Location: login.php");
//     exit();
// }
// ?>
