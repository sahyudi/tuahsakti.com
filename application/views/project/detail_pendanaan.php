<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detail Pendanaan Project</h1>
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
                        <h3 class="card-title">Detail Pendanaan Project</h3>

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
                                <table id="table-info-1" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama Item</th>
                                            <th>Total</th>
                                            <th>Keterangan</th>
                                            <th>User Input</th>
                                            <th>Aciton</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sub_total = 0;
                                        ?>
                                        <?php foreach ($detail as $key => $value) { ?>
                                            <?php
                                            $sub_total += $value->total;
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= $key + 1 ?></td>
                                                <td><?= date('d F Y', strtotime($value->tanggal)) ?></td>
                                                <td><?= $value->nama_item ?></td>
                                                <td class="text-right"><?= number_format($value->total, 0) ?></td>
                                                <td><?= $value->keterangan ?></td>
                                                <td><?= get_user_name($value->created_user) ?></td>
                                                <td>
                                                    <a href="<?= base_url('project/delete_detail_dana/') . $value->detail_id ?>" class="btn btn-danger btn-xs" onclick="return confirm_delete()"><i class="fas fa-fw fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-right" colspan="3">Total</th>
                                            <th class="text-right">Rp. <?= number_format($sub_total, 0) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('project/pendanaan') ?>" class="btn btn-danger btn-sm float-left">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table-info').DataTable()
    });
</script>
<!-- /.content-wrapper -->