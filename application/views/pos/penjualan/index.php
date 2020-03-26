<div class="content">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?= $this->session->flashdata('message'); ?>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title m-0">Form Penjualan</h5>
                    <a href="#" onclick="get_stock()" data-toggle="modal" data-target="#modal-stock" class="btn btn-sm btn-info  float-right"><i class="fa fa-database"> Stock</i></a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('pos/save_payment') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="">Kasir</label>
                                        <p><?= $this->session->userdata('email'); ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Tanggal</label>
                                        <p><?= date('D, d F Y') ?></p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" rows="1"></textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Status </label>
                                        <div class="form-group">
                                            <input type="radio" name="keterangan" id="keterangan1" value="1" checked> Toko
                                            <input type="radio" name="keterangan" id="keterangan2" value="2"> Project
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Item List</label>
                                        <select name="item-select" id="item-select" onchange="addItem()" class="form-control form-control-sm select2" onchange="addItem()">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <h5 class="text-center">Daftar Belanjaan</h5>
                                <div class="table-responsive">
                                    <table id="table-belanja" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th style="width: 25%;">Item / Satuan</th>
                                                <th>Stock</th>
                                                <th>Quantity</th>
                                                <th>Harga</th>
                                                <th>Sub Total</th>
                                                <!-- <th>Upah / Satuan</th>
                                                    <th>Sub Upah</th> -->
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="hidden" id="jumlah-baris" value="1">
                                            <tr id="remove-null">
                                                <td colspan="6" class="text-center">Item Belum dipilih</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-right">TOTAL</td>
                                                <td class="text-right">Rp. <span id="total"></span></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Bayar</label>
                                    <input type="text" name="tunai" id="tunai" class="form-control form-control-sm text-right" onkeyup="hitung_tunai()" value="0">
                                </div>
                                <div class="form-group">
                                    <label for="">Kredit</label>
                                    <input type="text" name="lebih-uang" id="lebih-uang" class="form-control form-control-sm text-right" value="0" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" onclick="return cek_item_input()" class="btn btn-primary float-right btn-ms">Payment <i class="fas fa-fw fa-file-invoice-dollar"></i> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>


<div class="modal fade" id="modal-stock">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Material Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th>Material</th>
                                <th>Satuan</th>
                                <th>Quantity</th>
                                <th>Harga Jual</th>
                                <th>Upah Darat</th>
                                <th>Upah Laut</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // $('#table-belanja').dataTable();
        get_item();
        // get_stock()
    });

    function cek_item_input() {
        const item_select = [];

        $('[name="item[]"]').each(function(i, value) {
            item_select[i] = $(value).val();
            // console.log(value);
        });
        if (item_select.length < 1) {
            alert('Silakan pilih item terlebih dahulu');
            return false;
        } else {
            return confirm('Apakah anda yakin akan menyimpan data ?');
        }
    }

    function get_item() {
        const item_select = [];
        $('[name="item[]"]').each(function(i, value) {
            item_select[i] = $(value).val();
        });

        $.ajax({
            url: "<?= base_url('pos/get_item_list'); ?>",
            type: 'POST',
            data: {
                id: item_select
            },
            dataType: 'json',
            success: function(data) {
                $('#item-select').empty();
                $('.select2').select2('destroy');
                var item = '<option value=""></option>';

                $.each(data, function(i, val) {
                    item += `<option value="${val.id}">${val.nama}</option>`;
                });
                $('#item-select').append(item);
                $('.select2').select2();
            }
        });
    }

    function hitung_sub_total(id) {
        var sub_total = 0;
        const stock = parseInt($('#stock-' + id).val().replace(/\,/g, ''));
        const qty_awal = parseInt($('#qty-' + id).val().replace(/\,/g, ''));
        const harga = parseInt($('#harga_jual-' + id).val().replace(/\,/g, ''));
        if (qty_awal < 1 || qty_awal == 'NaN') {
            var qty = 1;
        } else if (qty_awal > stock) {
            var qty = stock;
        } else {
            var qty = qty_awal;
        }

        sub_total = qty * harga;
        if (sub_total > 0) {
            $('#sub_total-' + id).val(addCommas(sub_total));
        } else {
            $('#sub_total-' + id).val(0);
        }

        if (harga > 0) {
            return_harga = harga;
        } else {
            return_harga = 0;
        }

        // $('#qty-' + id).val(qty);
        $('#harga_jual-' + id).val(addCommas(return_harga));
        hitungtotal();
    }

    function hitung_tunai() {
        const total = parseInt($('#total').html().replace(/\,/g, ''));
        const tunai = $('#tunai').val().replace(/\,/g, '');

        $('#lebih-uang').val(addCommas(parseInt(tunai) - total));
        $('#tunai').val(addCommas(tunai));
    }

    function hitungtotal() {
        const rangeId = $('#jumlah-baris').val();
        var sumHarga = 0;

        for (let index = 1; index < parseInt(rangeId); index++) {
            if ($('#sub_total-' + index).length != 0) {
                var SubTotal = $('#sub_total-' + index).val();
                // var SubUpah = $('#sub_upah-' + index).val();
                if (SubTotal == null || SubTotal == '') {
                    SubTotal = 0;
                }
                sumHarga += parseInt(SubTotal.replace(/\,/g, ''));
            }
        }
        $('#total').html(addCommas(sumHarga));
    }

    function addItem() {
        var id = $('#item-select').val();
        const rangeId = $('#jumlah-baris').val();
        $.ajax({
            url: "<?= base_url('penjualan/get_item/') ?>" + id,
            type: "post",
            dataType: 'JSON',
            success: function(data) {
                $('#remove-null').remove();
                let item = `
                            <tr class="material" id="material-${rangeId}">
                                <td>
                                    <input type="hidden" class="form-control form-control-sm form-item" id="item-${rangeId}" name="item[]" value="${id}">
                                    ${data.nama} / ${data.satuan}
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-stock text-right" name="stock[]" id="stock-${rangeId}" value="${addCommas(data.stock)}" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm form-qty text-right" name="qty[]" id="qty-${rangeId}" onchange="hitung_sub_total(${rangeId})" onkeyup="hitung_sub_total(${rangeId})" value="1">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-harga_jual text-right" name="harga_jual[]" id="harga_jual-${rangeId}" value="${addCommas(data.harga_jual)}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-sub_total text-right" name="sub_total[]" id="sub_total-${rangeId}" value="0" readonly>
                                </td>
                                
                                <td class="for-button">
                                    <button href="#" onclick="hapus(${rangeId})" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>
                                </td>
                            </tr>
                            `;
                // <td>
                //    <input type="text" name="upah[]" id="upah-${rangeId}" class="form-control form-control-sm text-right" value="${addCommas(data.upah_darat)}" readonly>
                // </td>
                // <td>
                //    <input type="text" class="form-control form-control-sm form-sub_upah text-right" name="sub_upah[]" id="sub_upah-${rangeId}" value="0" readonly>
                // </td>
                $('#table-belanja tbody').append(item);
                $('#item-select').val('');
                $('#jumlah-baris').val(parseInt(rangeId) + parseInt(1));
                get_item();
                hitung_sub_total(rangeId);
            }
        });


    }

    function hapus(params) {
        var id = 'material-' + params;
        $('#' + id).remove('');
        if ($('.material').length < 1) {
            $('#remove-null').remove();
            const nul = `<tr id="remove-null"><td colspan="8" class="text-center">Item Belum dipilih</td></tr>`;
            $('#table-belanja tbody').append(nul);
        }
        get_item();
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
                    "data": "stock"
                },
                {
                    "data": "harga_jual",
                    // "className": "text-right",
                    "render": function(data, type, oObj) {
                        var status = oObj['harga_jual'];
                        return `<td class="text-right">Rp. ${addCommas(status)}</right>`;
                    }
                },
                {
                    "data": "harga_jual",
                    // "className": "text-right",
                    "render": function(data, type, oObj) {
                        var status = oObj['upah_darat'];
                        return `<td class="text-right">Rp. ${addCommas(status)}</right>`;
                    }
                },
                {
                    "data": "harga_jual",
                    // "className": "text-right",
                    "render": function(data, type, oObj) {
                        var status = oObj['upah_darat'];
                        return `<td class="text-right">Rp. ${addCommas(status)}</right>`;
                    }
                },

            ]
        })
    }
</script>