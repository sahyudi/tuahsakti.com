<section class="content">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Penjualan Material</h3>
                    <a href="<?= base_url('pos') ?>" class="btn btn-primary btn-sm float-right"><i class="fas fa-fw fa-plus"></i> Add Penjualan</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-penjualan" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Transaksi ID</th>
                                    <th>Material / Satuan</th>
                                    <th>Quantity</th>
                                    <th>Harga Jual</th>
                                    <th>Upah</th>
                                    <th>Sub Total</th>
                                    <th>Sub Upah</th>
                                    <!-- <th>Keterangan</th> -->
                                    <th>Keterangan</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sub_total = 0;
                                $sub_upah = 0;
                                ?>
                                <?php foreach ($penjualan as $key => $value) { ?>
                                    <?php $sub_total += $value->harga_jual * $value->qty ?>
                                    <?php $sub_upah += $value->upah * $value->qty ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td><?= date('d F Y', strtotime($value->tanggal)) ?></td>
                                        <td><?= $value->transaksi_id ?></td>
                                        <td><?= $value->item . " (" . $value->satuan . ")" ?></td>
                                        <td class="text-center"><?= number_format($value->qty, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->harga_jual, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->upah, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->harga_jual * $value->qty, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->upah * $value->qty) ?></td>
                                        <td><?= $value->keterangan ?></td>
                                        <!-- <td class="text-right">
                                            <a href="<?= base_url('pengadaan/delete/') . $value->id ?>" onclick="return validation()"><i class="fas fa-fw fa-trash"></i></a>
                                            <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-material" class="btn-edit"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                        </!-->
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-bold text-right">Total</td>
                                    <td class="text-bold text-right">Rp.&nbsp;<?= number_format($sub_total, 0) ?></td>
                                    <td class="text-bold text-right">Rp.&nbsp;<?= number_format($sub_upah, 0) ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-penjualan').dataTable();
    });
</script>