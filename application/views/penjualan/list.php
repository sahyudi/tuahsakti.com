<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Penjualan Material</h1>
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
                        <h3 class="card-title">Data Penjualan Material</h3>
                        <a href="<?= base_url('penjualan/form') ?>" class="btn btn-sm btn-primary float-right"><i class="fas fa-fw fa-plus"></i> Add Penjualan</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table-penjualan" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Transaksi ID</th>
                                        <th>Material / Satuan</th>
                                        <th>Quantity</th>
                                        <th>Harga Jual</th>
                                        <th>Upah</th>
                                        <th>Sub Total</th>
                                        <th>Sub Upah</th>
                                        <th>Keterangan</th>
                                        <th>User Input</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sub_total = 0;
                                    $sub_total_upah = 0;
                                    ?>
                                    <?php foreach ($penjualan as $key => $value) { ?>
                                        <?php
                                        $sub_total += $value->harga_jual * $value->qty;
                                        $sub_total_upah += $value->upah * $value->qty;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= date('d F Y', strtotime($value->tanggal)) ?></td>
                                            <td><?= $value->nama ?></td>
                                            <td><?= $value->transaksi_id ?></td>
                                            <td><?= $value->item . " (" . $value->satuan . ")" ?></td>
                                            <td class="text-center"><?= number_format($value->qty, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->harga_jual, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->upah, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->harga_jual * $value->qty, 0) ?></td>
                                            <td class="text-right"><?= number_format($value->upah * $value->qty, 0) ?></td>
                                            <td><?= $value->keterangan ?></td>
                                            <td><?= get_user_name($value->created_user) ?></td>
                                            <td class="text-center">
                                                <button type="button" onclick="validation(<?= $value->detail_id ?>)" class="btn btn-danger btn-xs"><i class="fas fa-fw fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="8" class="text-right">Total</th>
                                        <th class="text-right">Rp.&nbsp;<?= number_format($sub_total, 0) ?></th>
                                        <th class="text-right">Rp.&nbsp;<?= number_format($sub_total_upah, 0) ?></th>
                                        <th colspan="3"></th>
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

    function validation(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = `<?= base_url('penjualan/delete_detail/') ?>${id}`
            }
        })
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