<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title?></title>
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>assets/images/logos/topsis-icon.png" />
    <link rel="stylesheet" href="<?=base_url()?>assets/css/styles.min.css" />
    <script src="<?=base_url()?>assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Sweatalert  -->
    <link rel="stylesheet" href="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.css" />
    <script src="<?=base_url()?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <style>
    .mid {

        /* text-align: center; */
        vertical-align: middle;
    }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="<?=base_url('user')?>" class="text-nowrap logo-img">
                        <img src="<?=base_url()?>assets/images/logos/kpnga.png" width="120" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?=base_url('user')?>" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Main Menu</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?=base_url('anggota')?>" aria-expanded="false">
                                <span>
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="hide-menu">Anggota</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?=base_url('kriteria')?>" aria-expanded="false">
                                <span>
                                    <i class="ti ti-article"></i>
                                </span>
                                <span class="hide-menu">Kriteria</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?=base_url('alternatif')?>" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file-description"></i>
                                </span>
                                <span class="hide-menu">Nilai Alternatif</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?=base_url('topsis')?>" aria-expanded="false">
                                <span>
                                    <i class="ti ti-align-box-left-top"></i>
                                </span>
                                <span class="hide-menu">Analisa TOPSIS</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?=base_url('topsis/hasil')?>" aria-expanded="false">
                                <span>
                                    <i class="ti ti-star"></i>
                                </span>
                                <span class="hide-menu">Hasil</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon"></i>
                            <span class="hide-menu">AUTH</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?=base_url('user/akun')?>" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="hide-menu">Users</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="<?=base_url('user/logout')?>" aria-expanded="false">
                                <span>
                                    <i class="ti ti-login"></i>
                                </span>
                                <span class="hide-menu">Logout</span>
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <a class="btn btn-light"><?=UserLogin()->nama_user?></a>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="<?=base_url()?>assets/images/profile/user-1.jpg" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->

            <div class="container-fluid">
                <?= $this->renderSection('content') ?>

            </div>
        </div>
    </div>
    <script src="<?=base_url()?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url()?>assets/js/sidebarmenu.js"></script>
    <script src="<?=base_url()?>assets/js/app.min.js"></script>
    <script src="<?=base_url()?>assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>