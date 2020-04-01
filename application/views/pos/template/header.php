<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>POS | Tuah Sakti</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/adminlte.min.css">


    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- InputMask -->
    <script src="<?= base_url('assets/') ?>plugins/moment/moment.min.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/') ?>dist/js/adminlte.js"></script>


    <!-- select2 -->
    <link href="<?= base_url('assets/plugins/select2-3.5.3/select2.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/plugins/select2-3.5.3/select2-bootstrap.css') ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/plugins/select2-3.5.3/select2.min.js') ?>"></script>
</head>
<style>
    body {
        font-size: 14px !important;
    }
</style>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="<?= base_url('pos') ?>" class="navbar-brand">
                    <img src="<?= base_url('assets/') ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Ranting Tuah Sakti</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <?php if (check_permision_menu($this->session->userdata('group_id'), 'home')) { ?>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="<?= base_url('home') ?>" class="nav-link">Home</a>
                            </li>
                        </ul>
                    <?php } ?>
                    <?php
                    $menu[] = [
                        'title' => 'Pos',
                        'link' => 'pos'
                    ];

                    $menu[] = [
                        'title' => 'Item Master',
                        'link' => 'pos/item_master'
                    ];

                    $menu[] = [
                        'title' => 'Pengadaan',
                        'link' => 'pos/report_pengadaan'
                    ];
                    $menu[] = [
                        'title' => 'Penjualan',
                        'link' => 'pos/report_penjualan'
                    ];

                    $menu[] = [
                        'title' => 'Report',
                        'link' => 'pos/report_master'
                    ];

                    ?>
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <?php foreach ($menu as $value) { ?>
                            <li class="nav-item <?= ($active == $value['title']) ? 'active' : '' ?>">
                                <a href="<?= base_url($value['link']) ?>" class="nav-link"><?= $value['title'] ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>


                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="mr-3 fas fa-fw fa-user-cog"> </i> <?= $this->session->userdata('name') ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-fw fa-user-cog mr-2"></i> Setting Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('auth/logout') ?>" class="dropdown-item">
                                <i class="fas fa-fw fa-sign-out-alt mr-2"></i> Sign Out
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"> POS <small>Versi 1.0</small></h1>
                        </div>
                        <!-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Pos</a></li>
                                <li class="breadcrumb-item active">Home</li>
                            </ol>
                        </div> -->
                    </div>
                </div>
            </div>