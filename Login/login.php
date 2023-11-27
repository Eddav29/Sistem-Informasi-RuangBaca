    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg "> <!-- Ubah modal ke ukuran besar (modal-lg) -->
            <div class="modal-content bg-darkblue text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Log in</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Struktur HTML untuk logo dan form -->
                    <div class="d-flex flex-column-reverse flex-lg-row align-items-lg-center">
                        <form class="flex-grow-1" id="loginForm" action="cek_login.php" method="post">
                            <!-- ... (form fields) -->
                            <div class="mb-3 mt-3 text-dark">
                                <h5>Login</h5>
                                <p>If you are not a member, <a href="#" id="registerModalLink" class="text-darkblue" data-bs-toggle="modal" data-bs-target="#registerModal" style="text-decoration: none;">register here</a>!</p>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="username">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password">
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
                            <img src="../../Assets/img/logo.jpg" alt="Logo" class="img-fluid img-logo" width="200px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Modal-->
    <?php
    include("../../Login/register.php");
    ?>

    <script src="../../Assets/app.js"></script>
    <script src=" ../../Assets/JQuery/jquery-3.7.1.min.js"></script>
    <script src="../../Assets/Bootstraps/js/bootstrap.min.js"></script>