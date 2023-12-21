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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin-top: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Adjust card image size */
        .card-img-top {
            height: 300px;
            object-fit: cover;
        }

        /* Update pagination styling */
        .pagination {
            justify-content: center;
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg m-0 fixed-top">
        <div class="container-fluid">

            <img src="../../Assets/img/logo.jpg" alt="Logo-ruangBaca" width="125px"
                class="d-inline-block align-text-top ">
            <a class="navbar-brand fw-bold text-white" href="#">Ruang Baca</a>

            <!-- Toggler for Sidebar -->
            <button class="custom-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </button>

            <!-- Sidebar -->
            <div class="sidebar">
                <a href="#" class="close-btn">&times;</a>
                <ul class="navbar-nav p-2 m-1">
                    <li class="nav-item">
                        <a class="nav-link active p-2 text-white" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 text-white" aria-current="page" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 text-white" aria-current="page" href="#team">our teams</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 text-white" aria-current="page" href="#contact">Contact</a>
                    </li>
                    <?php
                    if (isset($showSearch) && $showSearch) {
                        echo '
                        <li class="nav-item">
                              <form class="d-flex form-group align-items-center me-3">
                            <input id="searchInput" class="form-control me-1" type="search" placeholder="Search" aria-label="Search">
                            <div id="searchResults" class="autocomplete-results"></div>
                            <button class="btn btn-outline-light" type="submit"><i href="" class="fa fa-search"></i></button>
                        </form>
                        </li>';
                    }
                    ?>
                    <button class="btn btn-outline-light login-darkblue" type="submit" data-bs-toggle="modal"
                        data-bs-target="#loginAwal" ">
                        <i class=" fa-solid fa-right-to-bracket"></i> Log in
                    </button>
                </ul>
            </div>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active p-2 text-white" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 text-white" aria-current="page" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 text-white" aria-current="page" href="#team">our teams</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-2 text-white" aria-current="page" href="#contact">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center"> <!-- Container for search and login -->
                    <?php
                    if (isset($showSearch) && $showSearch) {
                        echo '
                         <form id="searchForm" class="d-flex form-group align-items-center me-3" method="POST" action="../../Functions/searchHandler.php">
                            <input id="searchInput" class="form-control me-1" type="search" name="query" placeholder="Search" aria-label="Search">
                            <div id="searchResults" class="autocomplete-results"></div>
                            <button class="btn btn-outline-light" type="submit"><i class="fa fa-search"></i></button>
                            </form>

                            ';
                    }
                    ?>

                    <button class="btn btn-outline-light login-darkblue" type="submit" data-bs-toggle="modal"
                        data-bs-target="#loginModal" ">
                        <i class=" fa-solid fa-right-to-bracket"></i> Log in
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg "> <!-- Ubah modal ke ukuran besar (modal-lg) -->
            <div class="modal-content bg-darkblue text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Log in</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Struktur HTML untuk logo dan form -->
                    <div class="d-flex flex-column-reverse flex-lg-row align-items-lg-center">
                        <form class="flex-grow-1" id="loginForm" action="../../Login/cek_login.php" method="post"
                            onsubmit="return handleLoginForm()">
                            <!-- ... (form fields) -->
                            <div class="mb-3 mt-3 text-dark">
                                <h5>Login</h5>
                                <p>If you are not a member, <a href="#" id="registerModalLink" class="text-darkblue"
                                        data-bs-toggle="modal" data-bs-target="#registerModal"
                                        style="text-decoration: none;">register here</a>!</p>
                            </div>

                            <div class="mb-3">
                                <label for="loginUsername" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="loginUsername" name="loginUsername">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="loginPassword" name="loginPassword">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Log in</button>
                            </div>
                        </form>
                        <!-- Reverse column order untuk mobile -->
                        <div class="flex-shrink-0 ms-lg-3 mb-3 mb-lg-0"> <!-- Tambahkan margin-bottom untuk mobile -->
                            <img src="../../Assets/img/logo.jpg" alt="Logo" class="img-fluid img-logo" width="400px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Modal-->


    <!-- Registration Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-darkblue text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Registration form -->
                    <form id="registerForm" method="post" action="../../Login/register.php">
                        <div class="mb-3">
                            <label for="ID_MEMBER" class="form-label">ID MEMBER</label>
                            <input type="text" class="form-control" id="ID_MEMBER" name="ID_MEMBER">
                        </div>
                        <div class="mb-3">
                            <label for="USERNAME_MEMBER" class="form-label">Username</label>
                            <input type="text" class="form-control" id="USERNAME_MEMBER" name="USERNAME_MEMBER">
                        </div>
                        <div class="mb-3">
                            <label for="PASSWORD_MEMBER" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="PASSWORD_MEMBER" name="PASSWORD_MEMBER">
                                <button type="button" class="btn btn-outline-secondary" id="togglePasswordRegister">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label name="confirmPassword" for="confirmPassword" class="form-label">Confirm
                                Password</label>
                            <span id="passwordMatchError" class="text-danger d-none">Passwords do not match.</span>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="confirmPassword">
                                <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>

                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="NAMA_MEMBER" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="NAMA_MEMBER" name="NAMA_MEMBER">
                        </div>
                        <div class="mb-3">
                            <label for="JENIS_IDENTITAS" class="form-label">Identity Type
                                (Mahasiswa/Dosen)</label>
                            <input type="text" class="form-control" id="JENIS_IDENTITAS" name="JENIS_IDENTITAS">
                        </div>
                        <div class="mb-3">
                            <label for="NOMOR_IDENTITAS" class="form-label">Identity
                                Number</label>
                            <input type="text" class="form-control" id="NOMOR_IDENTITAS" name="NOMOR_IDENTITAS">
                        </div>
                        <div class="mb-3">
                            <label for="ALAMAT" class="form-label">Address</label>
                            <input type="text" class="form-control" id="ALAMAT" name="ALAMAT">
                        </div>
                        <div class="mb-3">
                            <label for="LEVEL" class="form-label">Level</label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="LEVEL" id="LEVEL" value="Member">
                                <label class="form-label" for="LEVEL">Member</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--End Modal-->

    <!-- JavaScript -->
    <script src=" ../../Assets/JQuery/jquery-3.7.1.min.js"></script>
    <script src="../../Assets/Bootstraps/js/bootstrap.min.js"></script>
    <script src="../../Assets/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script>
        //toggle sidebar
        document.querySelector(".custom-toggler").addEventListener("click", function () {
            event.preventDefault();
            toggleSidebar();
        });

        document.querySelector(".close-btn").addEventListener("click", function () {
            event.preventDefault();
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
            .addEventListener("click", function (e) {
                e.preventDefault(); // Prevent the default behavior of the button

                // Update the URL without reloading the page
                history.pushState(null, null, "katalog.php");

                // Show the modal manually
                $("#loginModal").modal("show");
            });

        // Handle click event on the "Register" link
        document
            .querySelector("#registerModalLink")
            .addEventListener("click", function (e) {
                e.preventDefault(); // Prevent the default behavior of the link

                // Update the URL without reloading the page
                history.pushState(null, null, "../Login/Member/register.php");

                // Show the modal manually
                $("#registerModal").modal("show");
            });

        // Check password match on registration
        document
            .getElementById("registerForm")
            .addEventListener("submit", function (e) {
                var password = document.getElementById("registerPassword").value;
                var confirmPassword = document.getElementById("confirmPassword").value;

                if (password !== confirmPassword) {
                    e.preventDefault(); // Prevent form submission
                    document.getElementById("passwordMatchError").classList.remove("d-none");
                } else {
                    document.getElementById("passwordMatchError").classList.add("d-none");
                }
            });
        //search
        $(document).ready(function () {
            $(' #searchForm').submit(function (e) {
                e.preventDefault(); var formData = $(this).serialize(); $.ajax({
                    type: 'POST', url: '../../Functions/searchHandler.php', data: formData, success:
                        function (response) { // Update bagian katalog dengan hasil pencarian
                            $('#katalogContent').html(response);
                        }, error: function (xhr, status, error) {
                            console.error(error);
                        }
                });
            });
        }); var
            passwordInput = document.getElementById("password"); var
                passwordInput = document.getElementById("loginPassword"); // Show password login document
                                .getElementById("togglePassword").addEventListener("click", function () {
                    var
                        passwordInput = document.getElementById("loginPassword"); var
                            type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                    passwordInput.setAttribute("type", type); this.innerHTML = type === "password"
                        ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
                }); // Show
                                password register document.getElementById("togglePasswordRegister")
            .addEventListener("click", function () {
                var
                    passwordInput = document.getElementById("registerPassword"); var
                        type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                passwordInput.setAttribute("type", type); this.innerHTML = type === "password"
                    ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            }); </script>

</body>

</html>