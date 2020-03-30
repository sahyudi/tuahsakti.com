<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pengadaan Material</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Pengadaan</li>
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
                        <h5 class="card-title">Form Pencarian Data</h5>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <form action="<?= base_url('penjualan/report') ?>" method="post" enctype="multipart/form-data" id="fom-kartu-stock">
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
                        <h3 class="card-title">Report Pengadaan Material</h3>
                        <?php
                        $start_date = ($start_date) ? $start_date : 0;
                        $end_date = ($end_date) ? $end_date : 0;
                        $material_id = ($material_id) ? $material_id : 0;
                        ?>
                        <a href="<?= base_url('pengadaan/print_report/') . $start_date . '/' . $end_date . '/' . $material_id ?>" class="btn btn-default float-right"><i class="fas fa-fw fa-print"></i> Print</a>
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
                                        <th>Keterangan</th>
                                        <th>User Input</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sub_total = 0;
                                    $sub_total_upah = 0;
                                    ?>
                                    <?php foreach ($pengadaan as $key => $value) { ?>
                                        <?php
                                        $sub_total += $value->harga_beli * $value->qty;
                                        $sub_total_upah += $value->upah * $value->qty;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= date('d F Y', strtotime($value->tanggal)) ?></td>
                                            <td><?= $value->surat_jalan ?></td>
                                            <td><?= $value->item . " (" . $value->satuan . ")" ?></td>
                                            <td class="text-center"><?= number_format($value->qty, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->harga_beli, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->upah, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->harga_beli * $value->qty, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->upah * $value->qty, 0) ?></td>
                                            <td><?= $value->keterangan ?></td>
                                            <td><?= get_user_name($value->created_user) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-right">Total</th>
                                        <th class="text-right">Rp.&nbsp;<?= number_format($sub_total, 0) ?></th>
                                        <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_upah, 0) ?></th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
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
        return confirm('Apakah anda yakin akan mengahapus material ??');
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
                $('#harga_beli').val(data.harga_beli);
                $('#keterangan').val(data.keterangan);
            }
        });
    });
</script>
<!-- /.content-wrapper -->