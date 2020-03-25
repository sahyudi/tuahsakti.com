<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Stock Material</h3>
                    <a href="<?= base_url('pos/form_item') ?>" class="btn btn-primary float-right btn-sm"><i class="fas fa-fw fa-plus"></i> Add Material</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Material</th>
                                    <th>Satuan</th>
                                    <th>Quantity</th>
                                    <th>Harga Jual</th>
                                    <th>Upah Darat</th>
                                    <th>Upah Laut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($material as $key => $value) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value->nama ?></td>
                                        <td><?= $value->satuan ?></td>
                                        <td class="text-center"><?= number_format($value->stock, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->harga_jual, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->upah_darat, 0) ?></td>
                                        <td class="text-right"><?= number_format($value->upah_laut, 0) ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('pos/form_item/') . $value->id ?>" class="btn btn-success btn-edit btn-xs"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("#example1").DataTable();
        // get_stock();


    });

    function validation() {
        return confirm('Apakah anda yakin akan mengahapus materia ??');
    }

    function reset_form() {
        $('#form-material')[0].reset();
    }

    function get_edit_item(id) {
        $('#modal-material').modal('show');
        $.ajax({
            url: "<?= base_url() . 'pos/get_item_master/'; ?>" + id,
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
                $('#upah_laut').val(data.upah_laut);
                $('#upah_darat').val(data.upah_darat);
            }
        });
    }

    function handleAjaxError(xhr, textStatus, error) {
        if (textStatus === 'timeout') {
            alert('The server took too long to send the data.');
        } else {
            alert('An error occurred on the server. Please try again in a minute.');
        }
    }

    function get_stock() {
        if (oTable) {
            oTable.fnDestroy();
        }
        $('#example1').dataTable().fnDestroy();
        var oTable = $('#example1').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            'searching': true,
            'sAjaxSource': "<?= base_url('pos/get_data_stock') ?>",
            'fnServerData': function(sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "status",
                    "value": "1"
                });
                $.ajax({
                    'dataType': 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback,
                    "error": handleAjaxError
                });

            },
            'fnDrawCallback': function(oSettings) {
                $('#modal-loading').modal('hide');
            },
            "columns": [{
                    "data": "nama"
                },
                {
                    "data": "satuan"
                },
                {
                    "className": "text-center",
                    "data": "stock",
                    "render": function(data, type, oObj) {
                        var stock = oObj['stock'];
                        return `<td class="text-right">${addCommas(stock)}</td>`;
                    }
                },
                {
                    "data": "harga_jual",
                    // "className": "text-right",
                    "render": function(data, type, oObj) {
                        var harga_jual = oObj['harga_jual'];
                        return `<td class="text-right">${addCommas(harga_jual)}</td>`;
                    }
                },
                {
                    "data": "harga_jual",
                    // "className": "text-right",
                    "render": function(data, type, oObj) {
                        var upah_laut = oObj['upah_laut'];
                        return `<td class="text-right">${addCommas(upah_laut)}</td>`;
                    }
                },
                {
                    "data": "harga_jual",
                    // "className": "text-right",
                    "render": function(data, type, oObj) {
                        var upah_darat = oObj['upah_darat'];
                        return `<td class="text-right">${addCommas(upah_darat)}</right>`;
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, value) {
                        var id = value['id'];
                        return `<td class="text-center"><a href="<?= base_url('pos/form_item/') ?>${id}" class="btn btn-success btn-edit btn-xs"><i class="fas fa-fw fa-pencil-alt"></i></a></td>`;

                    }
                }

            ]
        })
    }
</script>