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

    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Google Font: Source Sans Pro -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->


    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap4 Duallistbox -->
    <script src="<?= base_url('assets/') ?>plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="<?= base_url('assets/') ?>plugins/moment/moment.min.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="<?= base_url('assets/') ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?= base_url('assets/') ?>plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url('assets/') ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="<?= base_url('assets/') ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

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

    <!-- select2 -->
    <link href="<?= base_url('assets/plugins/select2-3.5.3/select2.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/plugins/select2-3.5.3/select2-bootstrap.css') ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/plugins/select2-3.5.3/select2.min.js') ?>"></script>
</head>

<style>
    body {
        font-size: 12px !important;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">