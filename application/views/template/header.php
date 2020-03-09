<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?= ($title) ? $title : 'Home' ?></title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->


    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url('assets/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/') ?>dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="<?= base_url('assets/') ?>dist/js/demo.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="<?= base_url('assets/') ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/raphael/raphael.min.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('assets/') ?>plugins/chart.js/Chart.min.js"></script>
    <!-- PAGE SCRIPTS -->
    <!-- <script src="<?= base_url('assets/') ?>dist/js/pages/dashboard2.js"></script> -->
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">