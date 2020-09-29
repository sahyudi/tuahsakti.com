<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Saldo Hutang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Saldo Hutang</li>
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

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Saldo Hutang</h3>
                        <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" onclick="reset_form()" data-target="#modal-material"><i class="fas fa-fw fa-plus"></i> Add Hutang</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Vendor</th>
                                        <th>Saldo Hutang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    <?php foreach ($saldo_hutang as $key => $value) { ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $value->nama_vendor ?></td>
                                            <td class="text-right">Rp. <?= number_format(abs($value->saldo), 0) ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('accounting/delete_saldo_hutang/') . $value->vendor_id ?>" title="Hapus Hutang" onclick="return validation()" class="btn btn-xs btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                                                <a href="<?= base_url('accounting/pembayaran/') . $value->vendor_id ?>" class="btn btn-xs btn-success btn-edit" title="Lihat Detail"><i class="fas fa-fw fa-info"></i></a>
                                            </td>
                                        </tr>
                                        <?php $total += $value->saldo ?>
                                    <?php } ?>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-right text-bold">Total</td>
                                        <td class="text-right text-bold">Rp. <?= number_format(abs($total), 0) ?></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

<div class="modal fade" id="modal-material">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Hutang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('accounting/add_hutang') ?>" id="form-material" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Supplier</label>
                        <select name="vendor" id="vendor" class="form-control select2">
                            <?php foreach ($vendor as $key => $value) {
                                echo "<option value='" . $value->id . "'>" . $value->nama . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Kredit</label>
                        <input type="text" name="kredit" id="kredit" class="form-control" placeholder="kredit" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" cols="3" placeholder="Keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-fw fa-money"></i> Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function() {
        $("#example1").DataTable();
        $(":input").inputmask();
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