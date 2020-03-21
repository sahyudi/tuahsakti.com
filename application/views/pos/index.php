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
                <a href="../../index3.html" class="navbar-brand">
                    <img src="<?= base_url('assets/') ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Point Of Sale</span>
                </a>


                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="index3.html" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contact</a>
                        </li>
                    </ul>

                </div>

                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#"><?= $this->session->userdata('email'); ?>
                            <i class="fas fa-fw fa-user-cog"></i>
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
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Pos</a></li>
                                <li class="breadcrumb-item active">Home</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title m-0">Stock Item</h5>
                                    <a href="#" data-toggle="modal" data-target="#modal-stock" class="btn btn-sm btn-info  float-right"><i class="fa fa-database"> Stock</i></a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Tanggal</label>
                                                    <p><?= date('d F Y') ?></p>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">No Nota</label>
                                                    <p><?= 'FE' . time() ?></p>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Item List</label>
                                                    <select name="item-select" id="item-select" class="form-control form-control-sm select2" onchange="addItem()">
                                                        <option value=""></option>
                                                        <!-- <?php foreach ($material as $key => $value) { ?>
                                                            <option value="<?= $value->id ?>"><?= $value->nama . " / " . $value->satuan ?></option>
                                                        <?php } ?> -->
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="card-tite">List Item</div>
                                            <table id="table-belanja" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th style="width: 25%;">Item / Satuan</th>
                                                        <th>Stock</th>
                                                        <th>Quantity</th>
                                                        <th>Harga</th>
                                                        <th>Sub Total</th>
                                                        <th>Upah / Satuan</th>
                                                        <th>Sub Upah</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <input type="hidden" id="jumlah-baris" value="1">


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="https://tuahsakti.com">Tuah Sakti</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- page script -->
    <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            // $('.select2').select2({
            //     'placeholder': 'Select One'
            // });
        });

        $(document).ready(function() {
            list_need_approve();
            get_item();
        })

        function addItem() {
            $('.select2').select2('destroy');
            var id = $(this).val()
            const rangeId = $('#jumlah-baris').val()
            // const item = $('#material-0').first().clone();
            let item = `
                <tr class="material" id="material-${rangeId}">
                    <td>
                        <input type="text"class="form-control form-control-sm form-item " id="item-${rangeId}" name="item[]" value"${id}">
                    </td>
                    <td><input type="text" class="form-control form-control-sm form-stock text-right" name="stock[]" id="stock-${rangeId}" readonly></td>
                    <td><input type="number" class="form-control form-control-sm form-qty text-right" name="qty[]" id="qty-${rangeId}" onchange="hitung_sub_total(0)" onkeyup="hitung_sub_total(0)"></td>
                    <td><input type="text" class="form-control form-control-sm form-harga_jual text-right" name="harga_jual[]" id="harga_jual-${rangeId}" readonly></td>
                    <td><input type="text" class="form-control form-control-sm form-sub_total text-right" name="sub_total[]" id="sub_total-${rangeId}" value="0" readonly></td>
                    <td><input type="text" class="form-control form-control-sm form-upah text-right" name="upah[]" id="upah-${rangeId}" value="0" readonly></td>
                    <td><input type="text" class="form-control form-control-sm form-sub_upah text-right" name="sub_upah[]" id="sub_upah-${rangeId}" value="0" readonly></td>
                    <td class="for-button">
                        <button href="#" onclick="hapus(${rangeId})" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>
                    </td>
                </tr>
            `;
            $('#table-belanja tbody').append(item);

            // var btn = '';
            // $('#' + id + ' .for-button').append(btn);
            // $('#jumlah-baris').val(parseInt(parseInt(rangeId) + 1));

            $('#item-select').val('');
            $(".select2").select2();
        }

        function hapus(params) {
            var id = 'material-' + params;
            $('#' + id).remove('');
        }

        function handleAjaxError(xhr, textStatus, error) {
            if (textStatus === 'timeout') {
                alert('The server took too long to send the data.');
            } else {
                alert('An error occurred on the server. Please try again in a minute.');
            }
        }

        function get_item(no = '') {
            // $("#qty_" + no).attr('readonly', true);
            // if ($("#plu_" + no).val() == null) {
            //     $("#plu_" + no).empty();
            // }
            var id_gudang = $('#idgudang').val();
            var selectednumbers = [];
            $('[name="item[]"] :selected').each(function(i, selected) {
                selectednumbers[i] = $(selected).val();
            });
            $('#item-select').select2({
                placeholder: 'Pilih Item',
                ajax: {
                    url: "<?php echo base_url(); ?>pos/get_item_list",
                    type: "POST",
                    dataType: 'json',
                    delay: 250,
                    // data: dataString,
                    data: function(params) {
                        return {
                            cari: params.term, // search term
                            id_gudang: id_gudang,
                            sel: JSON.stringify(selectednumbers),
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
            // $("#qty_" + no).removeAttr('class');
            // $("#qty_" + no).addClass('form-control text-center plu_' + $("#plu_" + no).val());
            // if ($("#plu_" + no).val() !== null) {
            //     $("#qty_" + no).attr('readonly', false);
            // }
            // $("input[type='number']").on("keypress keyup blur", function(event) {
            //     if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
            //         return false;
            //     }
            // });
        }


        function list_need_approve() {
            if (oTable) {
                oTable.fnDestroy();
            }
            $('#example1').dataTable().fnDestroy();
            var oTable = $('#example1').dataTable({
                // "ordering": false,
                "bProcessing": true,
                "bServerSide": true,
                'searching': true,
                'sAjaxSource': "<?= base_url('pos/get_data_stock') ?>",
                'fnServerData': function(sSource, aoData, fnCallback) {
                    aoData.push({
                        "name": "status",
                        "value": "1"
                    });
                    $.ajax({
                        'dataType': 'json',
                        'type': 'POST',
                        'url': sSource,
                        'data': aoData,
                        'success': fnCallback,
                        "error": handleAjaxError
                    });

                },
                'fnDrawCallback': function(oSettings) {
                    $('#modal-loading').modal('hide');
                },
                "columns": [{
                        "data": "nama"
                    },
                    {
                        "data": "satuan"
                    },
                    {
                        "className": "text-center",
                        "data": "stock"
                    },
                    {
                        "data": "harga_jual",
                        // "className": "text-right",
                        "render": function(data, type, oObj) {
                            var status = oObj['harga_jual'];
                            return `<td class="text-right">Rp. ${addCommas(status)}</right>`;
                        }
                    },

                ]
            })
        }

        function addCommas(nStr) {
            nStr += '';
            x = nStr.split(',');
            x1 = x[0];
            x2 = x.length > 1 ? ',' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    </script>
</body>

<div class="modal fade" id="modal-stock">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Material Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th>Material</th>
                                <th>Satuan</th>
                                <th>Quantity</th>
                                <th>Harga Jual</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

</html>