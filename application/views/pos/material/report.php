<section class="content">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Pencarian Data</h5>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <form action="<?= base_url('pos/report_master') ?>" method="post" enctype="multipart/form-data" id="fom-kartu-stock">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 float-right">
                                <label for="">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" style="background-color: white;">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" placeholder="Tujuan">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Material</label>
                                <select name="material" id="material" class="form-control select2">
                                    <option value="0">All</option>
                                    <?php foreach ($material as $key => $value) { ?>
                                        <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('material') ?>" class="btn btn-danger float-left btn-sm"> Back</a>
                        <button type="submit" class="btn btn-primary float-right btn-sm"><i class="fas fa-fw fa-search"></i> Search</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Repot Stock Material</h3>
                    <?php
                    $start_date = ($start_date) ? $start_date : 0;
                    $end_date = ($end_date) ? $end_date : 0;
                    $material_id = ($material_id) ? $material_id : 0;
                    ?>
                    <a href="<?= base_url('pos/print_report_master/') . $start_date . '/' . $end_date . '/' . $material_id ?>" class="btn btn-default btn-sm float-right"><i class="fas fa-fw fa-print"></i> Print</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Tanggal</label>
                            <p><?= date('d F Y', strtotime($start_date)) . " - " . date('d F Y', strtotime($end_date)) ?></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Material</label>
                            <p> <?= ($material_id) ? get_material_name($material_id) : 'Seleruh Material'  ?></p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th colspan="5"></th>
                                    <th colspan="3" class="text-center">IN</th>
                                    <th colspan="3" class="text-center">OUT</th>
                                    <th colspan="2" class="text-center">UPAH</th>
                                </tr>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Material (Satuan)</th>
                                    <th>Quantity</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                    <th>Quantity</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                    <th>Upah</th>
                                    <th>Sub Upah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sub_total_in = 0;
                                $sub_total_out = 0;
                                $sub_total = 0;
                                $total_upah = 0;
                                $total = 0;
                                ?>
                                <?php if ($kartu_stock) { ?>

                                    <?php foreach ($kartu_stock as $key => $value) { ?>
                                        <?php $sub_total = $value->quantity * $value->harga ?>
                                        <?php $total_upah += $value->quantity * $value->upah ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= date('d F Y', strtotime($value->tanggal)) ?></td>
                                            <td><?= $value->nama ?></td>
                                            <td><?= $value->ket ?></td>
                                            <td><?= $value->material . " (" . $value->satuan  ?>)</td>
                                            <?php if ($value->tipe == 'in') { ?>
                                                <?php $sub_total_in += $sub_total ?>
                                                <td class="text-center"><?= number_format($value->quantity, 0) ?></td>
                                                <!-- <td class="text-right"><?= number_format($value->harga, 0) ?></td> -->
                                                <td class="text-right"><?= 0 ?></td>
                                                <td class="text-right"><?= 0 ?></td>
                                                <td class="text-center"> - </td>
                                                <td class="text-center"> - </td>
                                                <td class="text-center"> - </td>
                                            <?php } else { ?>
                                                <?php $sub_total_out += $sub_total ?>
                                                <td class="text-center"> - </td>
                                                <td class="text-center"> - </td>
                                                <td class="text-center"> - </td>
                                                <td class="text-center"><?= number_format($value->quantity, 0) ?></td>
                                                <td class="text-right"><?= number_format($value->harga, 0) ?></td>
                                                <td class="text-right"><?= number_format($sub_total, 0) ?></td>
                                            <?php } ?>
                                            <td class="text-right"><?= number_format($value->upah, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->upah * $value->quantity, 0) ?></td>
                                        </tr>
                                    <?php } ?>

                                <?php  } ?>
                            </tbody>
                            <!-- <tfoot> -->
                            <tr>
                                <th colspan="6" class="text-right">Total</th>
                                <th class="text-right">Rp.&nbsp;<?= 0 ?> </th>
                                <th colspan="2"></th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_out, 0) ?> </th>
                                <th></th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($total_upah, 0) ?> </th>

                            </tr>
                            <tr>
                                <th class="text-right" colspan="10">Total Penjualan</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_out, 0) ?> </th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="10">Total Pengandaan</th>
                                <th class="text-right">Rp.&nbsp;<?= 0 ?></th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="10">Total Upah</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($total_upah, 0) ?> </th>
                            </tr>
                            <tr>
                                <th class="text-right" colspan="10">Margin</th>
                                <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_out - $sub_total_in - $total_upah, 0) ?> </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("#example1").DataTable();
        $('.select2').select2();
    });
</script>
<!-- /.content-wrapper -->