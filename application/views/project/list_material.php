<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Project Hutang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Project Hutang</li>
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
                        <h3 class="card-title">Project Hutang</h3>
                        <!-- <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" onclick="reset_form()" data-target="#modal-material"><i class="fas fa-fw fa-plus"></i> Add Hutang</a> -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Proyek</th>
                                    <th>Material</th>
                                    <th>Qty</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Sub Total</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                                <?php foreach ($detail as $key => $value) { ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td><?= $value->nama_proyek ?></td>
                                        <td><?= $value->material ?></td>
                                        <td class="text-center"><?= $value->qty ?></td>
                                        <td class="text-right"><?= number_format($value->harga_beli, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->harga, 0) ?></td>
                                        <td class="text-right">Rp. <?= number_format($value->qty * $value->harga, 0) ?></td>
                                        <td><?= $value->ket_detail ?></td>
                                        <td class="text-right">
                                            <a href="<?= base_url('project/delete_material_project/') . $value->id_detail ?>" title="Hapus Hutang" onclick="return validation()" class="btn btn-xs btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                                            <a href="#" data-id="<?= $value->id_detail ?>" data-toggle="modal" data-target="#modal-material" class="btn btn-xs btn-success btn-edit" title="Edit Data"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-right text-bold">Total</td>
                                    <td class="text-right text-bold">Rp. <?= number_format($total, 0) ?></td>
                                    <td colspan="2"></td>
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
            <form action="<?= base_url('project/add_hutang') ?>" id="form-material" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <select name="nama" id="nama" class="form-control form-control-sm select2">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Quantity</label>
                        <input type="text" name="qty" id="qty" class="form-control form-control-sm text-right" placeholder="Quantity" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Harga Beli</label>
                        <input type="text" name="harga_beli" id="harga_beli" class="form-control form-control-sm text-right" placeholder="Harga Jual" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Harga Jual</label>
                        <input type="text" name="harga" id="harga" class="form-control form-control-sm" placeholder="Harga Jual" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Satuan</label>
                        <input type="text" name="satuan" id="satuan" class="form-control form-control-sm" placeholder="Harag jual">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" cols="3" placeholder="Keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function() {
        $('#example1').DataTable();
        $(":input").inputmask();
        get_item();
    });

    function get_item() {

        $.ajax({
            url: "<?= base_url('pos/get_item_list'); ?>",
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                $('#item-select').empty();
                $('.select2').select2('destroy');
                var item = '<option value=""></option>';

                $.each(data, function(i, val) {
                    item += `<option value="${val.id}">${val.nama}</option>`;
                });
                $('#nama').append(item);
                $('.select2').select2();
            }
        });
    }

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
            url: "<?= base_url() . 'project/get_material_edit/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#nama').select2('val', data.material_id);
                $('#satuan').val(data.satuan);
                $('#harga_beli').val(data.harga_beli);
                $('#harga').val(data.harga);
                $('#keterangan').val(data.ket_detail);
            }
        });
    });
</script>
<!-- /.content-wrapper -->