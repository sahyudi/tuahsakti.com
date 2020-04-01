<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tuah Sakti | Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/adminlte.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>


<body>
    <div class="wrapper">
        <section class="invoice">
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fas fa-globe"></i> Ranting Tuah Sakti, CV.
                        <small class="float-right">Date: <?= date('d/m/Y') ?></small>
                    </h2>
                </div>
            </div>
            <br><br><br>
            <div class="row invoice-info">
                <div class="col-md-12">
                    <h2 class="text-center">Laporan Stock Material</h2><br>
                </div>
                <div class="col-md-6 invoice-col">
                    Tanggal
                    <address>

                        <?php if ($start_date) {
                            echo $start_date . " - " . $end_date;
                        } else {
                            echo 'All';
                        }
                        ?>
                    </address>
                </div>
                <div class="col-md-6 invoice-col">
                    Material
                    <address>
                        <?= ($material_id) ? get_material_name($material_id) : 'Seleruh Material'  ?>
                    </address>
                </div>
            </div>

            <div class="row">
                <div class="col-12 table-reponsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="4"></th>
                                <th colspan="3" class="text-center">IN</th>
                                <th colspan="3" class="text-center">OUT</th>
                                <th colspan="2" class="text-center">OUT</th>
                            </tr>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Material (Satuan)</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>Quantity</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                                <th>Quantity</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                                <th>Upah</th>
                                <th>Sub Upah</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sub_total_in = 0;
                            $sub_total_out = 0;
                            $sub_total = 0;
                            $total_upah = 0;
                            $total = 0;
                            ?>
                            <?php foreach ($kartu_stock as $key => $value) { ?>
                                <?php $sub_total = $value->quantity * $value->harga ?>
                                <?php $total_upah += $value->quantity * $value->upah ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td><?= date('d F Y', strtotime($value->tanggal)) ?></td>
                                    <td><?= $value->ket ?></td>
                                    <td><?= $value->material . " (" . $value->satuan  ?>)</td>
                                    <?php if ($value->tipe == 'in') { ?>
                                        <?php $sub_total_in += $sub_total ?>
                                        <td class="text-center"><?= number_format($value->quantity, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->harga, 0) ?></td>
                                        <td class="text-right"><?= number_format($sub_total, 0) ?></td>
                                        <td class="text-center"> - </td>
                                        <td class="text-center"> - </td>
                                        <td class="text-center"> - </td>
                                    <?php } else { ?>
                                        <?php $sub_total_out += $sub_total ?>
                                        <td class="text-center"> - </td>
                                        <td class="text-center"> - </td>
                                        <td class="text-center"> - </td>
                                        <td class="text-center"><?= number_format($value->quantity, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->harga, 0) ?></td>
                                        <td class="text-right"><?= number_format($sub_total, 0) ?></td>
                                    <?php } ?>
                                    <td class="text-right"><?= number_format($value->upah, 0) ?></td>
                                    <td class="text-right"><?= number_format($value->upah * $value->quantity, 0) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <!-- <tfoot> -->
                        <tr>
                            <th colspan="6" class="text-right">Total</th>
                            <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_in, 0) ?> </th>
                            <th colspan="2"></th>
                            <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_out, 0) ?> </th>
                            <th></th>
                            <th class="text-right">Rp.&nbsp;<?= number_format($total_upah, 0) ?> </th>
                        </tr>
                        <!-- </tfoot> -->
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-6"></div>
                <div class="col-6">
                    <p class="lead">Total :</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th colspan="6" class="text-right">Total Penjualan</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_out, 0) ?></th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right">Total Pengadaan</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_in, 0) ?></th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right">Total Upah</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($total_upah, 0) ?></th>
                            </tr>
                            <tr>
                                <th colspan="6" class="text-right">Margin</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_out - $sub_total_in - $total_upah, 0) ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        window.addEventListener("load", window.print());
        window.onafterprint = function(e) {
            closePrintView();
        };

        function closePrintView() {
            window.location.href = '<?= base_url('pos/report_master') ?>';
        }
    </script>
</body>

</html>