<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Project</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Project</li>
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
                        <h3 class="card-title">Data Project</h3>
                        <a href="<?= base_url('project/create_project') ?>" class="btn btn-primary btn-sm float-right"><i class="fas fa-fw fa-plus"></i> Add Project</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-penjualan" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Project No</th>
                                        <th>Nama</th>
                                        <th>Anggaran</th>
                                        <th>Pengeluaran</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sub_total = 0 ?>
                                    <?php foreach ($proyek as $key => $value) { ?>
                                        <?php $detail_pengeluaran = cek_pengeluaran_project($value->id); ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $value->proyek_no ?></td>
                                            <td><?= $value->nama_proyek ?></td>
                                            <td class="text-right"><?= number_format($value->anggaran, 0) ?></td>
                                            <td class="text-right"><?= number_format($detail_pengeluaran, 0) ?></td>
                                            <td class="text-center"><?= cek_status($value->status) ?></td>
                                            <td><?= $value->deskripsi ?></td>
                                            <td class="text-right">
                                                <a href="<?= base_url('project/delete/') . $value->id ?>" onclick="return validation()" class="btn btn-danger btn-xs"><i class="fas fa-fw fa-trash"></i></a>
                                                <a href="<?= base_url('project/info_detail/') . $value->id ?>" class="btn btn-info btn-xs btn-edit"><i class="fas fa-fw fa-info"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
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