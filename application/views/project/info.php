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
                                    <label for="">Name</label>
                                    <p><?= $master->nama_proyek ?></p>
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
                            <!-- <div class="row"> -->
                            <table id="table-info" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th style="width: 25%;">Item / Satuan</th>
                                        <th>Quantity</th>
                                        <th>Harga</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sub_total = 0;
                                    ?>
                                    <?php foreach ($detail as $key => $value) { ?>
                                        <?php
                                        $sub_total = $value->qty * $value->harga_jual;
                                        ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $value->tanggal_detail ?></td>
                                            <td><?= $value->item ?></td>
                                            <td class="text-center"><?= $value->qty ?></td>
                                            <td class="text-right"><?= number_format($value->harga_jual, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->qty * $value->harga_jual, 0) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right">TOTAL</th>
                                        <th class="text-right">Rp. <?= number_format($sub_total, 0) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <h5 class="text-center">Pendanaan Lainnya</h5>
                            <hr>
                            <!-- <div class="row"> -->
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped nowrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>No Proyek</th>
                                            <th>Keterangan</th>
                                            <th>Total</th>
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
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-right">Total</th>
                                            <th class="text-right">Rp. <?= number_format($total, 0) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row">
                                <!-- <div class="col-6"></div> -->
                                <div class="col-12">
                                    <p class="lead">Total :</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped nowrap">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Pengeluaran</th>
                                                    <th>Nilai Proyek</th>
                                                    <th>Margin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total_pengeluaran = $sub_total + $total;
                                                $selisih = $master->anggaran - $total_pengeluaran;
                                                ?>
                                                <tr>
                                                    <td class=" text-right">Rp. <?= number_format($total_pengeluaran, 0) ?></td>
                                                    <td class="text-right">Rp. <?= number_format($master->anggaran, 0) ?></td>
                                                    <td class="text-right">Rp. <?= number_format($selisih, 0) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('project') ?>" class="btn btn-danger float-left">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- end main content -->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table-info').DataTable()
    });
</script>
<!-- /.content-wrapper -->