<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="Assets/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Eddo,fathur,yayun,yunila">
  <meta name="generator" content="Hugo 0.118.2">
  <title>Ruang Baca JTI</title>

  <!-- Add these links to include DataTables CSS and JS files -->
  <link rel="stylesheet" href="Assets/DataTables/datatables.min.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- <link rel="stylesheet" href="../../Assets2/font-awesome/css/font-awesome.css" rel="stylesheet"> -->
  <link href="Assets/Bootstraps/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Assets/DataTables/datatables.min.css">

  <style>

    @media screen {
      
    }
    .custom-modal-body {
      border: 15px solid white;
      padding: 20px;
      /* Adjust the padding as needed */
      background-color: #f2f2f2;
      /* Set the desired background color */
      border-radius: 30px;
    }

    .btn-close-style {
      background-color: black;
      /* Warna latar belakang hitam */
      color: white;
      /* Warna teks putih */
      border: none;
      /* Hilangkan border */
      padding: 0.375rem 0.75rem;
      /* Sesuaikan padding sesuai kebutuhan */
      font-size: 1.25rem;
      /* Sesuaikan ukuran font sesuai kebutuhan */
      line-height: 1.5;
      /* Sesuaikan line height sesuai kebutuhan */
      border-radius: 0.25rem;
      /* Sesuaikan border radius sesuai kebutuhan */
    }

    .btn-close-style:hover {
      background-color: #333;
      /* Warna latar belakang hitam saat hover */
    }

    body {
      position: relative;
      overflow-x: hidden;
      background-color: #ffffff;
    }

    body,
    html {
      height: 100%;
    }

    .nav .open>a,
    .nav .open>a:hover,
    .nav .open>a:focus {
      background-color: transparent;
    }

    /* Additional CSS */
    .navbar-nav {
      width: 100%;
      /* Ensure all items take up full width */
    }

    .navbar-nav .nav-item.dropdown {
      margin: 0;
      /* Remove any unnecessary margin */
    }

    .navbar-nav .nav-item.dropdown .dropdown-menu {
      left: unset;
      /* Reset positioning */
      right: 100%;
      /* Align dropdown menu to the right */
    }

    .dropdown-item :hover {
      background-color: rgb(55, 55, 157);
    }

    /*-------------------------------*/
    /*           Wrappers            */
    /*-------------------------------*/

    #wrapper {
      padding-left: 0;
      -webkit-transition: all 0.5s ease;
      -moz-transition: all 0.5s ease;
      -o-transition: all 0.5s ease;
      transition: all 0.5s ease;
    }

    #wrapper.toggled {
      padding-left: 220px;
    }

    #sidebar-wrapper {
      z-index: 1000;
      left: 220px;
      width: 0;
      height: 100%;
      margin-left: -220px;
      overflow-y: auto;
      overflow-x: hidden;
      background: darkblue;
      -webkit-transition: all 0.5s ease;
      -moz-transition: all 0.5s ease;
      -o-transition: all 0.5s ease;
      transition: all 0.5s ease;
    }

    #sidebar-wrapper::-webkit-scrollbar {
      display: none;
    }

    #wrapper.toggled #sidebar-wrapper {
      width: 220px;
    }

    #page-content-wrapper {
      width: 100%;
      padding-top: 70px;
    }

    #wrapper.toggled #page-content-wrapper {
      position: absolute;
      margin-right: -220px;
    }

    /*-------------------------------*/
    /*     Sidebar nav styles        */
    /*-------------------------------*/
    .navbar {
      padding: 0;
    }

    .sidebar-nav {
      position: absolute;
      top: 0;
      width: 220px;
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .sidebar-nav li {
      position: relative;
      line-height: 20px;
      display: inline-block;
      width: 100%;
    }

    .sidebar-nav li:hover {
      background: blue !important;
      border-radius: 10px;
      margin-left: 10px;
      margin-right: 10px;
    }

    .sidebar-nav li:hover:before,
    .sidebar-nav li.open:hover:before {
      width: 100%;
      -webkit-transition: width 0.2s ease-in;
      -moz-transition: width 0.2s ease-in;
      -ms-transition: width 0.2s ease-in;
      transition: width 0.2s ease-in;
    }

    .sidebar-nav li a {
      display: block;
      color: #ddd;
      text-decoration: none;
      padding: 10px 15px 10px 30px;
    }

    .sidebar-nav li a:hover,
    .sidebar-nav li a:active,
    .sidebar-nav li a:focus,
    .sidebar-nav li.open a:hover,
    .sidebar-nav li.open a:active,
    .sidebar-nav li.open a:focus {
      color: #fff;
      text-decoration: none;
      background-color: transparent;
    }

    .sidebar-header {
      text-align: center;
      font-size: 20px;
      position: relative;
      width: 100%;
      display: inline-block;
    }

    .sidebar-brand {
      height: 65px;
      position: relative;
      background: darkblue;
      padding-top: 1em;
    }

    .sidebar-brand a {
      color: #ddd;
    }

    .sidebar-brand a:hover {
      color: #fff;
      text-decoration: none;
    }

    .dropdown-header {
      text-align: center;
      font-size: 1em;
      color: #ddd;
      background: darkblue;
    }

    .sidebar-nav .dropdown-menu {
      position: relative;
      width: 100%;
      padding: 0;
      margin: 0;
      border-radius: 0;
      border: none;
      background-color: darkblue;
      box-shadow: none;
    }

    .dropdown-menu.show {
      top: 0;
    }

    /*-------------------------------*/
    /*       Hamburger-Cross         */
    /*-------------------------------*/

    .hamburger {
      position: fixed;
      top: 20px;
      z-index: 1001;
      display: block;
      width: 32px;
      height: 32px;
      margin-left: 15px;
      background: transparent;
      border: none;
    }

    .hamburger:hover,
    .hamburger:focus,
    .hamburger:active {
      outline: none;
    }

    .hamburger.is-closed:before {
      content: "";
      display: block;
      width: 100px;
      font-size: 14px;
      color: #fff;
      line-height: 32px;
      text-align: center;
      opacity: 0;
      -webkit-transform: translate3d(0, 0, 0);
      -webkit-transition: all 0.35s ease-in-out;
    }

    .hamburger.is-closed:hover:before {
      opacity: 1;
      display: block;
      -webkit-transform: translate3d(-100px, 0, 0);
      -webkit-transition: all 0.35s ease-in-out;
    }

    .hamburger.is-closed .hamb-top,
    .hamburger.is-closed .hamb-middle,
    .hamburger.is-closed .hamb-bottom,
    .hamburger.is-open .hamb-top,
    .hamburger.is-open .hamb-middle,
    .hamburger.is-open .hamb-bottom {
      position: absolute;
      left: 0;
      height: 4px;
      width: 100%;
    }

    .hamburger.is-closed .hamb-top,
    .hamburger.is-closed .hamb-middle,
    .hamburger.is-closed .hamb-bottom {
      background-color: #1a1a1a;
    }

    .hamburger.is-closed .hamb-top {
      top: 5px;
      -webkit-transition: all 0.35s ease-in-out;
    }

    .hamburger.is-closed .hamb-middle {
      top: 50%;
      margin-top: -2px;
    }

    .hamburger.is-closed .hamb-bottom {
      bottom: 5px;
      -webkit-transition: all 0.35s ease-in-out;
    }

    .hamburger.is-closed:hover .hamb-top {
      top: 0;
      -webkit-transition: all 0.35s ease-in-out;
    }

    .hamburger.is-closed:hover .hamb-bottom {
      bottom: 0;
      -webkit-transition: all 0.35s ease-in-out;
    }

    .hamburger.is-open .hamb-top,
    .hamburger.is-open .hamb-middle,
    .hamburger.is-open .hamb-bottom {
      background-color: #1a1a1a;
    }

    .hamburger.is-open .hamb-top,
    .hamburger.is-open .hamb-bottom {
      top: 50%;
      margin-top: -2px;
    }

    .hamburger.is-open .hamb-top {
      -webkit-transform: rotate(45deg);
      -webkit-transition: -webkit-transform 0.2s cubic-bezier(0.73, 1, 0.28, 0.08);
    }

    .hamburger.is-open .hamb-middle {
      display: none;
    }

    .hamburger.is-open .hamb-bottom {
      -webkit-transform: rotate(-45deg);
      -webkit-transition: -webkit-transform 0.2s cubic-bezier(0.73, 1, 0.28, 0.08);
    }

    .hamburger.is-open:before {
      content: "";
      display: block;
      width: 100px;
      font-size: 14px;
      color: #fff;
      line-height: 32px;
      text-align: center;
      opacity: 0;
      -webkit-transform: translate3d(0, 0, 0);
      -webkit-transition: all 0.35s ease-in-out;
    }

    .hamburger.is-open:hover:before {
      opacity: 1;
      display: block;
      -webkit-transform: translate3d(-100px, 0, 0);
      -webkit-transition: all 0.35s ease-in-out;
    }

    /*-------------------------------*/
    /*            Overlay            */
    /*-------------------------------*/
  </style>



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
  <link rel="stylesheet" href="Assets/styleSidebar.css">
  <script src="https://kit.fontawesome.com/b450899c31.js" crossorigin="anonymous"></script>
  <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .id-ididid {
    background-color: #808080;
    color: white;
    padding: 20px;
    text-align: right;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000; /* Set a higher z-index value */
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.id-ididid a {
    color: black;
    text-decoration: none;
    margin: 0 10px;
    display: inline;
}

.profile-info {
    display: flex;
    align-items: center;
    margin-right: 10px;
}

.profile-info i {
    font-size: 2em; /* Adjust the font size as needed */
    margin-right: 5px; /* Adjust the margin as needed */
}



    </style>
</head>
<body>

<div class="id-ididid">
    <div class="profile-info" style="color: black; margin-left: 10px;">
        <?php
          echo $_SESSION["user"];
        ?>
        Who Am I?  
    </div>
    <i class="fa fa-circle-user fa-2x" style="color: black;"></i>
</div>


  <div id="wrapper">
    <div class="overlay"></div>
    <!-- Sidebar -->
    <nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
      <ul class="nav sidebar-nav">
        <div class="sidebar-header">
          <div class="sidebar-brand">
            <a href="#"> <img src="Assets/img/logo.jpg" alt="logo" width="100px"></a>
          </div>
        </div>
        <li class="nav-item"><a href="index.php"><i class="fa-solid fa-house"></i> Home</a></li>
        <li class="nav-item"><a href="index.php?page=Buku"><i class="fa-solid fa-book"></i> Buku</a></li>
        <li class="nav-item"><a href="index.php?page=Kategori"><i class="fa-solid fa-list"></i> Kategori</a></li>
        <li class="nav-item"><a href="index.php?page=Penulis"><i class="fa-solid fa-user-pen"></i> Penulis</a></li>
        <li class="nav-item"><a href="index.php?page=Petugas"><i class="fa-solid fa-user-tie"></i> Petugas</a></li>
        <li class="nav-item"><a href="index.php?page=Member"><i class="fa-solid fa-users"></i> Member</a></li>
        <li class="nav-item mb-10"><a href="index.php?page=Peminjaman"> <i class="fa-solid fa-truck-ramp-box"></i> Peminjaman</a></li>
        <li class="nav-item mt-10"><a href="Login/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
      </ul>

    </nav>

    <!-- Page Content -->
    <div class="page-header navbar navbar-fixed-top"></div>
    <div id="page-content-wrapper">

      <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
        <span class="hamb-top"></span>
        <span class="hamb-middle"></span>
        <span class="hamb-bottom"></span>
      </button>
      <div class="container ms-5">
        <div class="row">


</html>