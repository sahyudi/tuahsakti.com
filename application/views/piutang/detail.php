<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detail Piutang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Piutang</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <!-- /.card -->
                <?= $this->session->flashdata('message'); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Piutang</h3>
                        <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" onclick="reset_form()" data-target="#modal-pembayaran"><i class="fas fa-fw fa-plus"></i> Add Pembayaran</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="">Nama</label>
                                <p><?= $master->nama ?></p>
                            </div>
                            <div class="form-group col-6">
                                <label for="">No Nota</label>
                                <p><?= $master->no_nota ?></p>
                            </div>
                        </div>
                        <table id="example1" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <!-- <th>Customer</th> -->
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Saldo</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $sub_total = 0;
                                $debit_total = 0;
                                $kredit_total = 0;

                                foreach ($detail as $key => $value) {
                                    $sub_total = $total - ($value->kredit - $value->debit);
                                    $total += $sub_total;
                                    $debit_total += $value->debit;
                                    $kredit_total += $value->kredit;
                                ?>

                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td><?= $value->updated_at ?></td>
                                        <!-- <td><?= $value->nama ?></td> -->
                                        <td class="text-right">Rp. <?= number_format($value->debit, 0) ?></td>
                                        <td class="text-right">Rp. <?= number_format($value->kredit, 0) ?></td>
                                        <td class="text-right">Rp. <?= number_format(abs($sub_total)) ?></td>
                                        <td><?= $value->keterangan ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-right text-bold">Total</td>
                                    <td class="text-right">Rp. <?= number_format($debit_total) ?></td>
                                    <td class="text-right">Rp. <?= number_format($kredit_total) ?></td>
                                    <td class="text-right text-bold">Rp. <?= number_format(abs($kredit_total - $debit_total), 0) ?></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-pembayaran">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Pembayaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('accounting/bayar_piutang') ?>" id="form-material" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?= $master->id ?>">
                <input type="text" id="customer_id" name="customer_id" value="<?= $master->customer_id ?>" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Piutang</label>
                        <input type="text" name="saldo" id="saldo" class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''" value="<?= $master->saldo ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Debit</label>
                        <input type="text" name="debit" id="debit" class="form-control" onkeyup="get_total_saldo()" placeholder="debit" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Sisa</label>
                        <input type="text" name="sisa" id="sisa" class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" cols="3" placeholder="Keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-file-invoice-dollar"></i> Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#example1").DataTable();
        $(":input").inputmask();
    });

    function validation() {
        return confirm('Apakah anda yakin akan mengahapus materia ??');

    }

    function get_total_saldo() {
        var saldo = $('#saldo').val().replace(/\,/g, '');
        var debit = $('#debit').val().replace(/\,/g, '');

        var sisa = saldo - debit;
        if (sisa < 0) {
            $('#debit').val(saldo);
            $('#sisa').val(0);
        } else {
            $('#sisa').val(sisa)
        }
    }

    function reset_form() {
        $('#form-material')[0].reset();
    }

    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        // alert(id);
        $.ajax({
            url: "<?= base_url() . 'material/get_data/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#satuan').val(data.satuan);
                $('#harga_jual').val(data.harga_jual);
                $('#keterangan').val(data.keterangan);
            }
        });
    });
</script>
<!-- /.content-wrapper -->