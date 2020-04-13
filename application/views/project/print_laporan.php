<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Invoice</title>
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
                    <h2 class="text-center">Laporan Material</h2><br>
                </div>
                <div class="col-md-6 invoice-col">
                    Tanggal
                    <address>
                        <?= $master->tanggal ?>
                    </address>
                </div>
                <div class="col-md-6 invoice-col">
                    Nomor
                    <address>
                        <?= $master->proyek_no  ?>
                    </address>
                </div>
                <div class="col-md-6 invoice-col">
                    Nama
                    <address>
                        <?= $master->nama_proyek ?>
                    </address>
                </div>
                <div class="col-md-6 invoice-col">
                    Deskripsi
                    <address>
                        <?= $master->deskripsi ?>
                    </address>
                </div>
            </div>

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <!-- <th>Tanggal</th> -->
                                <th>Nama Item</th>
                                <th>Satuan</th>
                                <th>Quantity</th>
                                <th>Harga Beli</th>
                                <th>Harga</th>
                                <th>Sub Beli</th>
                                <th>Sub Total</th>
                                <th>Margin Harga</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sub_total = 0;
                            $sub_total_beli = 0;
                            ?>
                            <?php foreach ($detail as $key => $value) { ?>
                                <?php
                                $sub_total += $value->qty * $value->harga;
                                $sub_total_beli += $value->qty * $value->harga_beli;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <!-- <td><?= date('d F Y', strtotime($value->tanggal_detail)) ?></td> -->
                                    <td><?= $value->nama_item ?></td>
                                    <td><?= $value->satuan ?></td>
                                    <td class="text-center"><?= $value->qty ?></td>
                                    <td class="text-right"><?= number_format($value->harga_beli, 0) ?></td>
                                    <td class="text-right"><?= number_format($value->harga, 0) ?></td>
                                    <td class="text-right"><?= number_format($total_beli = $value->qty * $value->harga_beli, 0) ?></td>
                                    <td class="text-right"><?= number_format($total = $value->qty * $value->harga, 0) ?></td>
                                    <td class="text-right"><?= number_format($total - $total_beli, 0) ?></td>
                                    <td><?= $value->ket_detail ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
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
                                <th colspan="8" class="text-right">Total</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($sub_total, 0) ?></th>
                            </tr>
                            <tr>
                                <th colspan="8" class="text-right">Nilai Proyek</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($master->anggaran, 0) ?></th>
                            </tr>
                            <tr>
                                <th colspan="8" class="text-right">Margin Proyek</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($master->anggaran - $sub_total, 0) ?></th>
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
            window.location.href = '<?= base_url('project') ?>';
        }
    </script>
</body>

</html>