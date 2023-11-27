<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku</title>
    <link rel="stylesheet" href="../../Assets/Bootstraps/css/bootstrap.min.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" href="../../Assets/style.css">
    <link rel="icon" href="../../Assets/img/logo.jpg" type="image/x-icon">

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg m-0">
        <div class="container-fluid">

            <img src="../../Assets/img/logo.jpg" alt="Logo-ruangBaca" width="125px" class="d-inline-block align-text-top ">
            <a class="navbar-brand fw-bold text-white" href="#">Ruang Baca</a>

            <!-- Toggler for Sidebar -->
            <button class="custom-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </button>

            <!-- Sidebar -->
            <div class="sidebar">
                <a href="#" class="close-btn">&times;</a>
                <ul class="navbar-nav p-2 m-1">
                    <li class="nav-item">
                        <a class="nav-link active p-2 text-white" aria-current="page" href="katalog.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle p-2 text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Katalog
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item " href="#">Skripsi</a></li>
                            <li><a class="dropdown-item " href="#">Modul Ajar</a></li>
                            <li><a class="dropdown-item " href="#">Laporan PKL</a></li>
                            <li><a class="dropdown-item " href="#">Laporan Skripsi</a></li>
                            <li><a class="dropdown-item " href="#">Laporan Tugas Akhir</a></li>
                        </ul>
                    </li>
                    <?php
                    if (isset($showSearch) && $showSearch) {
                        echo '
                        <li class="nav-item">
                            <form class="d-flex form-group">
                                <input class="form-control me-3" type="search" placeholder="Search " aria-label="Search">
                                <button class="btn btn-outline-light" type="submit"> <i href="" class="fa fa-search"></i></button>
                            </form>
                        </li>';
                    }
                    ?>
                    <button class="btn btn-outline-light login-darkblue" type="submit" data-bs-toggle="modal" data-bs-target="#loginAwal" ">
                        <i class=" fa-solid fa-right-to-bracket"></i> Log in
                    </button>
                </ul>
            </div>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active p-2 text-white" aria-current="page" href="katalog.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle p-2 text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Katalog
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Skripsi</a></li>
                            <li><a class="dropdown-item" href="#">Modul Ajar</a></li>
                            <li><a class="dropdown-item" href="#">Laporan PKL</a></li>
                            <li><a class="dropdown-item" href="#">Laporan Skripsi</a></li>
                            <li><a class="dropdown-item" href="#">Laporan Tugas Akhir</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link p-2 text-white" aria-current="page" href="#">About</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center"> <!-- Container for search and login -->
                    <?php
                    if (isset($showSearch) && $showSearch) {
                        echo '
                        <form class="d-flex form-group align-items-center me-3">
                            <input class="form-control me-1" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-light" type="submit"><i href="" class="fa fa-search"></i></button>
                        </form>';
                    }
                    ?>

                    <button class="btn btn-outline-light login-darkblue" type="submit" data-bs-toggle="modal" data-bs-target="#loginModal" ">
                        <i class=" fa-solid fa-right-to-bracket"></i> Log in
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <?php
    include("../../Login/login.php");
    ?>

    <!-- JavaScript -->
    <script src=" ../../Assets/JQuery/jquery-3.7.1.min.js"></script>
    <script src="../../Assets/Bootstraps/js/bootstrap.min.js"></script>
    <script src="../../Assets/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script>
        //toggle sidebar
        document.querySelector(".custom-toggler").addEventListener("click", function() {
            toggleSidebar();
        });

        document.querySelector(".close-btn").addEventListener("click", function() {
            closeSidebar();
        });

        function toggleSidebar() {
            document.querySelector(".sidebar").classList.toggle("open");
        }

        function closeSidebar() {
            document.querySelector(".sidebar").classList.remove("open");
        }

        // Handle click event on the "Log in" button
        document
            .querySelector(".login-darkblue")
            .addEventListener("click", function(e) {
                e.preventDefault(); // Prevent the default behavior of the button

                // Update the URL without reloading the page
                history.pushState(null, null, "katalog.php");

                // Show the modal manually
                $("#loginModal").modal("show");
            });

        // Handle click event on the "Register" link
        document
            .querySelector("#registerModalLink")
            .addEventListener("click", function(e) {
                e.preventDefault(); // Prevent the default behavior of the link

                // Update the URL without reloading the page
                history.pushState(null, null, "../Login/Member/register.php");

                // Show the modal manually
                $("#registerModal").modal("show");
            });

        // Show password login
        document
            .getElementById("togglePassword")
            .addEventListener("click", function() {
                var passwordInput = document.getElementById("password");
                var type =
                    passwordInput.getAttribute("type") === "password" ? "text" : "password";
                passwordInput.setAttribute("type", type);
                this.innerHTML =
                    type === "password" ?
                    '<i class="fas fa-eye"></i>' :
                    '<i class="fas fa-eye-slash"></i>';
            });

        // Show password register
        document
            .getElementById("togglePasswordRegister")
            .addEventListener("click", function() {
                var passwordInput = document.getElementById("registerPassword");
                var type =
                    passwordInput.getAttribute("type") === "password" ? "text" : "password";
                passwordInput.setAttribute("type", type);
                this.innerHTML =
                    type === "password" ?
                    '<i class="fas fa-eye"></i>' :
                    '<i class="fas fa-eye-slash"></i>';
            });

        // Show confirm password
        document
            .getElementById("toggleConfirmPassword")
            .addEventListener("click", function() {
                var confirmPasswordInput = document.getElementById("confirmPassword");
                var type =
                    confirmPasswordInput.getAttribute("type") === "password" ?
                    "text" :
                    "password";
                confirmPasswordInput.setAttribute("type", type);
                this.innerHTML =
                    type === "password" ?
                    '<i class="fas fa-eye"></i>' :
                    '<i class="fas fa-eye-slash"></i>';
            });

        // Check password match on registration
        document
            .getElementById("registerForm")
            .addEventListener("submit", function(e) {
                var password = document.getElementById("registerPassword").value;
                var confirmPassword = document.getElementById("confirmPassword").value;

                if (password !== confirmPassword) {
                    e.preventDefault(); // Prevent form submission
                    document.getElementById("passwordMatchError").classList.remove("d-none");
                } else {
                    document.getElementById("passwordMatchError").classList.add("d-none");
                }
            });
    </script>

</body>

</html>