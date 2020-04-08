<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Stock Material</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Material</li>
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
                <!-- /.card -->
                <?= $this->session->flashdata('message'); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Stock Material</h3>
                        <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" onclick="reset_form()" data-target="#modal-material"><i class="fas fa-fw fa-plus"></i> Add Material</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Material</th>
                                        <th>Satuan</th>
                                        <th>Quantity</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Upah Darat</th>
                                        <th>Upah Laut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($material as $key => $value) { ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $value->nama  ?></td>
                                            <td><?= mb_strtoupper($value->satuan) ?></td>
                                            <td class="text-center"><?= number_format($value->stock, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->harga_beli, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->harga_jual, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->upah_darat, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->upah_laut, 0) ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('material/delete/') . $value->id ?>" onclick="return validation()" class="btn btn-danger btn-xs"><i class="fas fa-fw fa-trash"></i></a>
                                                <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-material" class="btn btn-success btn-edit btn-xs"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
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
    <div class="modal-dialog modal-lg">
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
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-sm" placeholder="Nama material">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Satuan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control form-control-sm" placeholder="Satuan">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" cols="3" placeholder="Keterangan"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Harga Beli</label>
                            <input type="text" name="harga_beli" id="harga_beli" class="form-control form-control-sm text-right" placeholder="Harga Jual" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Harga Jual</label>
                            <input type="text" name="harga_jual" id="harga_jual" class="form-control form-control-sm text-right" placeholder="Harga Jual" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Upah Laut</label>
                            <input type="text" name="upah_laut" id="upah_laut" class="form-control form-control-sm text-right" placeholder="Upah Laut" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Upah Darat</label>
                            <input type="text" name="upah_darat" id="upah_darat" class="form-control form-control-sm text-right" placeholder="Upah Darat" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                        </div>

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
        $('#form-material').validate({
            rules: {
                nama: {
                    required: true
                },
                satuan: {
                    required: true
                },
                harga_beli: {
                    required: true
                },
                harga_jual: {
                    required: true
                },
                upah_laut: {
                    required: true
                },
                upah_darat: {
                    required: true
                },
            },
            messages: {
                nama: {
                    required: "Please enter a nama.."
                },
                satuan: {
                    required: "Please enter a satuan.."
                },
                harga_beli: {
                    required: "Please enter a harga jual"
                },
                harga_beli: {
                    required: "Please enter a harga beli"
                },
                upah_laut: {
                    required: "Please enter a upah laut"
                },
                upah_darat: {
                    required: "Please enter a upah darat"
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
    $(document).ready(function() {
        $("#example1").DataTable({});
        $(":input").inputmask();
    });

    function validation() {
        return confirm('Apakah anda yakin akan mengahapus materia ??');
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
                $('#harga_beli').val(data.harga_beli);
                $('#harga_jual').val(data.harga_jual);
                $('#keterangan').val(data.keterangan);
                $('#upah_laut').val(data.upah_laut);
                $('#upah_darat').val(data.upah_darat);
            }
        });
    });
</script>
<!-- /.content-wrapper -->