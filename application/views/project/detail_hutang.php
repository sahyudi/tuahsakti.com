<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detail Hutang Project</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <?= $this->session->flashdata('message'); ?>
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Detail Pendanaan Project</h3>
                        <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modal-pembayaran"><i class="fas fa-fw fa-file-invoice-dollar"></i> Bayar</a>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Tanggal</label>
                                <p><?= $master->tanggal ?></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Nomor - Nama Proyek</label>
                                <p><?= $master->proyek_no . " - " . $master->nama_proyek ?></p>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Deskripsi</label>
                                <p><?= $master->keterangan ?></p>
                            </div>
                        </div>
                        <!-- <div class="table-responsive text-nowrap"> -->
                        <div class="table-responsive">
                            <table id="table-info-1" class="table table-striped table-bordered" style="width: 100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sub_total = 0;
                                    ?>
                                    <?php foreach ($detail as $key => $value) { ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= date('d F Y', strtotime($value->update_at)) ?></td>
                                            <td class="text-right"><?= number_format($value->debit, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->kredit, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->saldo_updated, 0) ?></td>
                                            <td><?= $value->ket_detail ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('project/hutang') ?>" class="btn btn-danger btn-sm float-left">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
            <form action="<?= base_url('project/pembayaran_hutang') ?>" id="form-material" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?= $master->id ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Saldo</label>
                        <input type="text" name="saldo" id="saldo" class="form-control" placeholder="Harga Jual" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''" value="<?= $master->saldo ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Debit</label>
                        <input type="text" name="debit" id="debit" class="form-control" onkeyup="get_total_saldo()" placeholder="Debit" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-info').DataTable();
        $(":input").inputmask();
    });

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
</script>
<!-- /.content-wrapper -->