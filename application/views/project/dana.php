<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pendanaan Project</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Pengajuan Pendanaan</li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pendanaan Project</h3>
                        <a href="<?= base_url('project/form_pendanaan') ?>" class="btn btn-primary btn-sm float-right"><i class="fas fa-fw fa-plus"></i> Add Pendanaan</a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>No Proyek</th>
                                        <th>Keterangan</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0 ?>
                                    <?php foreach ($pendanaan as $key => $value) { ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $value->tanggal ?></td>
                                            <td><?= $value->proyek_no . " - " . $value->nama_proyek ?></td>
                                            <td><?= $value->keterangan ?></td>
                                            <td class="text-right">Rp. <?= number_format($total += $value->total, 0) ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('accounting/deleteItem/') . $value->id ?>" onclick="return validation()" class="btn btn-xs btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                                                <a href="<?= base_url('accounting/detail_pendanaan/') . $value->id ?>" data-id="<?= $value->id ?>" class="btn btn-xs btn-info btn-edit"><i class="fas fa-fw fa-info"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">Total</th>
                                        <th class="text-right">Rp. <?= number_format($total, 0) ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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