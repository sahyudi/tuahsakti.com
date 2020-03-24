<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?= $this->session->flashdata('message'); ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Pengadaan Material</h3>
                    <a href="<?= base_url('pos/tambah_pengadaan') ?>" class="btn btn-primary float-right btn-sm"><i class="fas fa-fw fa-plus"></i> Tambah Pengadaan</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabel-pengadaan" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tannggal</th>
                                    <th>Surat Jalan</th>
                                    <th>Material / Satuan</th>
                                    <th>Quantity</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sub_total = 0 ?>
                                <?php foreach ($pengadaan as $key => $value) { ?>
                                    <?php $sub_total += $value->harga_beli * $value->qty ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td><?= date('d F Y', strtotime($value->tanggal)) ?></td>
                                        <td><?= $value->surat_jalan ?></td>
                                        <td><?= $value->nama . " (" . $value->satuan . ")" ?></td>
                                        <td class="text-center"><?= number_format($value->qty, 0) ?></td>
                                        <td class="text-left"><?= $value->keterangan ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>
<!-- end main content -->
</div>

<script>
    $(document).ready(function() {
        $("#tabel-pengadaan").DataTable();
    });
</script>
<!-- /.content-wrapper -->