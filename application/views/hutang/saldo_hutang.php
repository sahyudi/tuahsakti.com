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
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>No Nota</th>
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
                                        <td><?= $value->no_nota ?></td>
                                        <td><?= $value->nama_vendor ?></td>
                                        <td class="text-right">Rp. <?= number_format($value->saldo, 0) ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('accounting/delete_saldo_hutang/') . $value->id ?>" title="Hapus Hutang" onclick="return validation()" class="btn btn-xs btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                                            <a href="<?= base_url('accounting/pembayaran/') . $value->id ?>" class="btn btn-xs btn-success btn-edit" title="Lihat Detail"><i class="fas fa-fw fa-arrows-alt"></i></a>
                                        </td>
                                    </tr>
                                    <?php $total += $value->saldo ?>
                                <?php } ?>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-right text-bold">Total</td>
                                    <td class="text-right text-bold">Rp. <?= number_format($total, 0) ?></td>
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

<div class="modal fade" id="modal-material">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Material Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('material/add') ?>" id="form-material" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama material">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Satuan</label>
                        <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Harag jual">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control" placeholder="Harga Jual">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" cols="3" placeholder="Keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
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
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
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