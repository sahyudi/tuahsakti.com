<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pengajuan Pendanaan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Pengajuan Pendanaan</li>
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
                        <h3 class="card-title">Daftar Pengajuan Pendanaan</h3>
                        <a href="<?= base_url('accounting/form_pengajuan') ?>" class="btn btn-primary btn-sm float-right"><i class="fas fa-fw fa-plus"></i> Add Pengajuan</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Surat Jalan</th>
                                    <th>Keterangan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0 ?>
                                <?php foreach ($pengajuan as $key => $value) { ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td><?= $value->tanggal ?></td>
                                        <td><?= $value->surat_jalan ?></td>
                                        <td><?= $value->keterangan ?></td>
                                        <td class="text-center"><?= ($value->status == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Non Active</span>' ?></td>
                                        <td class="text-right">Rp. <?= number_format($total += $value->total, 0) ?></td>
                                        <td class="text-right">
                                            <?php if ($value->status == 1) { ?>
                                                <a href="<?= base_url('accounting/non_aktif/') . $value->id ?>" class="btn btn-warning btn-xs" onclick="return confirm_" title="Non activekan"><i class="fas fa-fw fa-ban"></i></a>
                                            <?php } ?>
                                            <a href="<?= base_url('accounting/delete_penganjuan/') . $value->id ?>" onclick="return validation()" class="btn btn-xs btn-danger" title="Hapus data"><i class="fas fa-fw fa-trash"></i></a>
                                            <a href="<?= base_url('accounting/detail_pendanaan/') . $value->id ?>" data-id="<?= $value->id ?>" class="btn btn-xs btn-info btn-edit" title="Detail pendanaan"><i class="fas fa-fw fa-info"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right text-bold">Total</td>
                                    <td class="text-right">Rp. <?= number_format($total, 0) ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
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
    });

    function validation() {
        return confirm('Apakah anda yakin akan mengahapus materia ??');
    }

    function reset_form() {
        $('#form-item')[0].reset();
    }

    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        // alert(id);
        $.ajax({
            url: "<?= base_url() . 'accounting/get_item/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#nama').val(data.nama);
            }
        });
    });
</script>
<!-- /.content-wrapper -->