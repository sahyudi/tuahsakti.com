<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detail Project</h1>
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
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Detail Project</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="<?= base_url('project/save_project') ?>" method="POST" enctype="multipart/form-data">
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
                                    <label for="">Anggaran (Rp.)</label>
                                    <p>Rp. <?= number_format($master->anggaran, 0) ?></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Deskripsi</label>
                                    <p><?= $master->deskripsi ?></p>
                                </div>
                            </div>

                            <hr>
                            <h5 class="text-center">List Item</h5>
                            <hr>

                            <!-- <div class="table-responsive text-nowrap"> -->
                            <div class="table-responsive">
                                <table id="table-info-1" class="table table-striped" style="width: 100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <!-- <th>Tanggal</th> -->
                                            <th>Nama Item</th>
                                            <th>Satuan</th>
                                            <th>Quantity</th>
                                            <th>Harga Beli</th>
                                            <th>Harga</th>
                                            <th>Sub Beli</th>
                                            <th>Sub Total</th>
                                            <th>Keterangan</th>
                                            <th>Actions</th>
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
                                                <td><?= $value->material ?></td>
                                                <td><?= $value->satuan ?></td>
                                                <td class="text-center"><?= number_format($value->qty, 0) ?></td>
                                                <td class="text-right"><?= number_format($value->harga_beli, 0) ?></td>
                                                <td class="text-right"><?= number_format($value->harga, 0) ?></td>
                                                <td class="text-right"><?= number_format($total_beli = $value->qty * $value->harga_beli, 0) ?></td>
                                                <td class="text-right"><?= number_format($total = $value->qty * $value->harga, 0) ?></td>
                                                <td><?= $value->ket_detail ?></td>
                                                <td>
                                                    <a href="#" data-id="<?= $value->id_detail ?>" data-toggle="modal" data-target="#modal-material" class="btn btn-xs btn-success btn-edit"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                                    <a href="<?= base_url('project/delete_material/') . $value->id_detail . "/" . $master->id ?>" class="btn btn-xs btn-danger"><i class="fas fa-fw fa-trash-alt"></i></a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('project') ?>" class="btn btn-danger btn-sm float-left">Back</a>
                            <a href="<?= base_url('project/print_project/') . $master->id ?>" class="btn btn-default btn-sm float-right"><i class="fas fa-fw fa-print"></i> Print</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
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
            <form action="<?= base_url('project/update_material') ?>" id="form-material" method="post" enctype="multipart/form-data">
                <input type="hidden" id="project_id" name="project_id" value="<?= $master->id ?>">
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-info').DataTable()
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
                $('#qty').val(data.qty);
                $('#harga').val(data.harga);
                $('#keterangan').val(data.ket_detail);
            }
        });
    });
</script>
<!-- /.content-wrapper -->