<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Stock Material</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Material</li>
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
                        <h3 class="card-title">Data Stock Material</h3>
                        <a href="#" class="btn btn-primary float-right" data-toggle="modal" onclick="reset_form()" data-target="#modal-material"><i class="fas fa-fw fa-plus"></i> Add Material</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Material / Satuan</th>
                                    <th>Quantity</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sub_total = 0;
                                $total = 0;
                                ?>

                                <?php foreach ($kartu_stock as $key => $value) { ?>
                                    <?php $sub_total = $value->quantity * $value->harga ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td><?= $value->tanggal ?></td>
                                        <td><?= $value->ket ?></td>
                                        <td><?= $value->material . " / " . $value->satuan  ?></td>
                                        <td class="text-center"><?= number_format($value->quantity, 0) ?></td>
                                        <td class="text-right">Rp. <?= number_format($value->harga, 0) ?></td>
                                        <td class="text-right">Rp. <?= number_format($sub_total, 0) ?></td>
                                        <!-- <td class="text-right">
                                            <a href="<?= base_url('material/delete/') . $value->id ?>" onclick="return validation()" class="btn btn-sm btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                                            <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-material" class="btn btn-sm btn-success btn-edit"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                        </td> -->
                                    </tr>
                                <?php } ?>
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