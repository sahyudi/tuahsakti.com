<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Penjualan Material</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Penjualan</li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Penjualan Material</h3>
                        <a href="<?= base_url('penjualan/form') ?>" class="btn btn-primary float-right"><i class="fas fa-fw fa-plus"></i> Add Penjualan</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-penjualan" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Transaksi ID</th>
                                        <th>Material / Satuan</th>
                                        <th>Quantity</th>
                                        <th>Harga Jual</th>
                                        <th>Sub Total</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sub_total = 0 ?>
                                    <?php foreach ($penjualan as $key => $value) { ?>
                                        <?php $sub_total += $value->harga_jual * $value->qty ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $value->tanggal ?></td>
                                            <td><?= $value->transaksi_id ?></td>
                                            <td><?= $value->item . " (" . $value->satuan . ")" ?></td>
                                            <td class="text-center"><?= number_format($value->qty, 0) ?></td>
                                            <td class="text-right">Rp. <?= number_format($value->harga_jual, 0) ?></td>
                                            <td class="text-right">Rp. <?= number_format($value->harga_jual * $value->qty, 0) ?></td>
                                            <td><?= $value->ket_detail ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('pengadaan/delete/') . $value->id ?>" onclick="return validation()"><i class="fas fa-fw fa-trash"></i></a>
                                                <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-material" class="btn-edit"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-bold text-right">Total</td>
                                        <td class="text-bold text-right">Rp. <?= number_format($sub_total, 0) ?></td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end main content -->
</div>


<script>
    $(document).ready(function() {
        $("#table-penjualan").DataTable();
    });

    function validation() {
        return confirm('Apakah anda yakin akan mengahapus materia ??');
        // confirm
        // alert('test');
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