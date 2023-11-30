<link rel="stylesheet" href="Assets2/custom/dashboard.css">
<div class="sidebar border-right col-md-3 col-lg-2 p-0" style="background-color: #082E3E;">
    <div class="offcanvas-md offcanvas-end" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel" style="background-color: #082E3E;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-white" id="sidebarMenuLabel">Ruang Baca JTI</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active text-white" aria-current="page" href="index.php">
                        <svg class="bi">
                            <use xlink:href="#house-fill"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active text-white" href="index.php?page=Member">
                        <svg class="bi">
                            <use xlink:href="#people" />
                        </svg>
                        Member
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active text-white" href="index.php?page=Buku">
                        <i class="fa fa-book"></i>
                        Buku
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active text-white" href="index.php?page=Petugas">
                        <i class="fa fa-user"></i>
                        Petugas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active text-white" href="index.php?page=Peminjaman">
                    <svg class="bi" xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M559.7 392.2c17.8-13.1 21.6-38.1 8.5-55.9s-38.1-21.6-55.9-8.5L392.6 416H272c-8.8 0-16-7.2-16-16s7.2-16 16-16h16 64c17.7 0 32-14.3 32-32s-14.3-32-32-32H288 272 193.7c-29.1 0-57.3 9.9-80 28L68.8 384H32c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32H192 352.5c29 0 57.3-9.3 80.7-26.5l126.6-93.3zm-366.1-8.3a.5 .5 0 1 1 -.9 .2 .5 .5 0 1 1 .9-.2z"/></svg>
                        Peminjaman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active text-white" href="index.php?page=Kategori">
                        <i class="fa fa-list"></i>
                        Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active text-white" href="index.php?page=Penulis">
                    <i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #fffff"></i>
                        Penulis
                    </a>
                </li>

                <hr class="my-3">

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active text-white" href="Login/logout.php">
                        <svg class="bi">
                            <use xlink:href="#door-closed" />
                        </svg>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
