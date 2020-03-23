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
<?php
$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Transaksi dengan nomor ' . $detail[0]->transaksi_id . ' berhasil !</div>');
?>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fas fa-globe"></i> Ranting Tuah Sakti, CV.
                        <small class="float-right">Date: <?= date('d/m/Y') ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>Admin, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (804) 123-5432<br>
                        Email: info@almasaeedstudio.com
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>John Doe</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (555) 539-1037<br>
                        Email: john.doe@example.com
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Invoice <?= $detail[0]->transaksi_id ?></b><br>
                    <br>
                    <b>Order ID:</b> 4F3S8J<br>
                    <b>Payment Due:</b> 2/22/2014<br>
                    <b>Account:</b> 968-34567
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Item</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sub_total = 0; ?>
                            <?php foreach ($detail as $key => $value) { ?>
                                <?php $sub_total += $value->qty * $value->harga_jual; ?>
                                <tr>
                                    <td><?= number_format($value->qty, 0) ?></td>
                                    <td><?= $value->satuan ?></td>
                                    <td><?= $value->item ?></td>
                                    <td class="text-right"><?= number_format($value->harga_jual, 0) ?></td>
                                    <td class="text-right"><?= number_format($value->qty * $value->harga_jual, 0) ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <td><?= $sub_total ?></td>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                    <!-- <p class="lead">Payment Methods:</p>
                    <img src="<?= base_url('assets') ?>/dist/img/credit/visa.png" alt="Visa">
                    <img src="<?= base_url('assets') ?>/dist/img/credit/mastercard.png" alt="Mastercard">
                    <img src="<?= base_url('assets') ?>/dist/img/credit/american-express.png" alt="American Express">
                    <img src="<?= base_url('assets') ?>/dist/img/credit/paypal2.png" alt="Paypal">

                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
                        jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                    </p> -->
                </div>
                <!-- /.col -->
                <div class="col-6">
                    <!-- <p class="lead">Amount Due 2/22/2014</p> -->
                    <p class="lead">Payment :</p>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Total:</th>
                                <td class="text-right">Rp. </span> <?= number_format($sub_total, 0) ?></td>
                            </tr>
                            <tr>
                                <th>Tunai</th>
                                <td class="text-right">Rp. <?= ($tunai) ? $tunai : 0 ?></td>
                            </tr>
                            <tr>
                                <th>Kembali</th>
                                <td class="text-right">Rp. <?= ($kembali) ? $kembali : 0 ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->

    <script type="text/javascript">
        window.addEventListener("load", window.print());
        // window.close("<?= base_url('pos') ?>");
        window.onafterprint = function(e) {
            closePrintView();
        };

        // function myFunction() {
        //     window.print();
        // }

        function closePrintView() {
            window.location.href = '<?= base_url('pos') ?>';
        }
    </script>
</body>

</html>