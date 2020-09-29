<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Penjualan Material</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Penjualan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <?= $this->session->flashdata('message'); ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Form Penjualan</h5>
                        <a href="#" onclick="get_stock()" data-toggle="modal" data-target="#modal-stock" class="btn btn-sm btn-info  float-right"><i class="fa fa-database"> Stock</i></a>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('pennjualan/save_payment') ?>" method="POST">
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
                                            <label for="">Status Penjualan</label> <br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="default" checked>
                                                <label class="form-check-label" for="inlineRadio1">Default</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="project">
                                                <label class="form-check-label" for="inlineRadio2">Project</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" id="div-project" style="display: none;">
                                            <label for="">Project</label>
                                            <select name="project" id="project" class="form-control form-control-sm select2">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Item List</label>
                                            <select name="item-select" id="item-select" onchange="addItem()" class="form-control form-control-sm select2" onchange="addItem()">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="text-center">Daftar Belanjaan</h5>
                                    <hr>
                                    <div class="table-responsive">
                                        <table id="table-belanja" class="table table-sm table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="width: 25%;">Item / Satuan</th>
                                                    <th>Stock</th>
                                                    <th>Quantity</th>
                                                    <th>Harga</th>
                                                    <th>Diskon</th>
                                                    <th>Sub Total</th>
                                                    <!-- <th>Upah / Satuan</th>
                                                    <th>Sub Upah</th> -->
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" id="jumlah-baris" value="1">
                                                <tr id="remove-null">
                                                    <td colspan="7" class="text-center">Item Belum dipilih</td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="col-md-12">
                                        <hr>
                                        <h3>Payment :</h3>
                                        <hr>
                                    </div>
                                    <div class="row col-md-6">
                                        <div class="form-group col-md-6">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status_pembayaran" id="inlineRadio3" value="cash" checked>
                                                <label class="form-check-label" for="inlineRadio3">Cash</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status_pembayaran" id="inlineRadio4" value="kredit">
                                                <label class="form-check-label" for="inlineRadio4">Kredit</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="form-group col-md-6" id="customer-kredit" style="display: none;">
                                        <label for="">Pelanggan &nbsp;&nbsp;&nbsp;
                                            <a href="#" data-toggle="modal" data-target="#modal-customer" class="btn btn-primary btn-xs"><i class="fas fa-fw fa-plus"></i></a>
                                        </label>
                                        <select name="customer_kredit" id="customer_kredit" class="form-control form-control-sm select2">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6" id="customer-cash" style="display: block;">
                                        <label for="">Pelanggan</label>
                                        <input type="text" name="customer_cash" id="customer_cash" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Total Belanja</label>
                                        <input type="text" name="total" id="total" class="form-control form-control-sm text-right" value="0" readonly data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Diskon Global</label>
                                        <input type="text" name="diskon_global" id="diskon_global" class="form-control form-control-sm text-right" onkeyup="global_diskon()" value="0" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Total</label>
                                        <input type="text" name="total_bersih" id="total_bersih" class="form-control form-control-sm text-right" value="0" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Bayar</label>
                                        <input type="text" name="tunai" id="tunai" class="form-control form-control-sm text-right" onkeyup="hitung_tunai()" value="0" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="" id="ket-lebih">Lebih Uang</label>
                                        <input type="text" name="lebih-uang" id="lebih-uang" class="form-control form-control-sm text-right" value="0" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" onclick="return cek_item_input()" class="btn btn-primary float-right btn-ms">Save <i class="fas fa-fw fa-file-invoice-dollar"></i> </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end main content -->
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
                    <table id="table-stock" class="table table-sm table-bordered table-striped" width="100%">
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
<div class="modal fade" id="modal-customer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-customer" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control form-control-sm" placeholder="Nama customer">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">No Telp</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control form-control-sm" placeholder="No Telepon">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control form-control-sm" cols="3" placeholder="Alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1">
                            <label class="form-check-label">Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" onclick="simpan_customer()" class="btn btn-primary btn-sm">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        get_item();
        get_project();
        $(":input").inputmask();
        setTimeout(function() {
            get_customer();
        }, 1000)
    });

    $('input[type="radio"][name="status"]').change(function() {
        const value = $(this).val();
        if (value == 'project') {
            $('#div-project').css('display', 'block');
        } else {
            $('#div-project').css('display', 'none');
        }
    });

    $('input[type="radio"][name="status_pembayaran"]').change(function() {
        const value = $(this).val();
        // alert(value);
        if (value == 'cash') {
            $('#customer-cash').css('display', 'block');
            $('#customer-kredit').css('display', 'none');
            $('#ket-lebih').html('Lebih Uang');
        } else {
            $('#customer-cash').css('display', 'none');
            $('#customer-kredit').css('display', 'block');
            $('#ket-lebih').html('Kredit');
        }
    });

    $('#project').change(function() {
        $('#customer_cash').val($('#project option:selected').html());
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

    function get_customer() {

        $.ajax({
            url: "<?= base_url('pos/get_customer'); ?>",
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                $('#customer_kredit').empty();
                $('.select2').select2('destroy');
                var item = '<option value=""></option>';

                $.each(data, function(i, val) {
                    item += `<option value="${val.id}">${val.nama}</option>`;
                });
                $('#customer_kredit').append(item);
                $('.select2').select2();
            }
        });
    }

    function get_project() {
        $.ajax({
            url: "<?= base_url('pos/get_project'); ?>",
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                $('#project').empty();
                $('.select2').select2('destroy');
                var item = '<option value=""></option>';
                // console.log(data);
                $.each(data, function(i, val) {
                    item += `<option value="${val.id}">${val.nama_proyek}</option>`;
                });
                $('#project').append(item);
                $('.select2').select2();
            }
        });
    }

    function simpan_customer() {
        $.ajax({
            url: "<?= base_url('pos/simpan_customer'); ?>",
            type: 'POST',
            data: $('#form-customer').serialize(),
            dataType: 'json',
            success: function(data) {
                get_customer();
                $('#modal-customer').modal('hide');
                $('#form-customer')[0].reset();
            }
        });
    }

    function hitung_sub_total(id) {
        var sub_total = 0;
        const stock = parseInt($('#stock-' + id).val().replace(/\,/g, ''));
        const qty_awal = parseInt($('#qty-' + id).val().replace(/\,/g, ''));
        const diskon = parseInt($('#diskon-' + id).val().replace(/\,/g, ''));
        const harga = parseInt($('#harga_jual-' + id).val().replace(/\,/g, ''));
        if (qty_awal < 1 || qty_awal == 'NaN') {
            var qty = 1;
        } else if (qty_awal > stock) {
            var qty = stock;
            $('#qty-' + id).val(qty);
        } else {
            var qty = qty_awal;
        }

        sub_total = (qty * harga) - diskon;
        if (sub_total > 0) {
            $('#sub_total-' + id).val(addCommas_general(sub_total));
        } else {
            $('#sub_total-' + id).val(0);
        }

        if (harga > 0) {
            return_harga = harga;
        } else {
            return_harga = 0;
        }

        // $('#qty-' + id).val(qty);
        $('#harga_jual-' + id).val(addCommas_general(return_harga));
        hitungtotal();
    }

    function hitung_tunai() {
        const total_bersih = $('#total_bersih').val().replace(/\,/g, '');
        const tunai = $('#tunai').val().replace(/\,/g, '');
        const selisih = parseInt(tunai) - parseInt(total_bersih);
        $('#lebih-uang').val(selisih);
        $('#tunai').val(tunai);
    }

    function global_diskon() {
        const total = $('#total').val().replace(/\,/g, '');
        const diskon_global = $('#diskon_global').val().replace(/\,/g, '');
        const selisih = parseInt(total) - parseInt(diskon_global);
        $('#total_bersih').val(selisih);
    }

    function hitungtotal() {
        let sumHarga = 0;
        // const item_select = [];
        $('[name="sub_total[]"]').each(function(i, value) {
            sumHarga = parseInt(sumHarga) + parseInt($(value).val().replace(/\,/g, ''));
        });
        $('#total').val(sumHarga);
        $('#total_bersih').val(sumHarga);
        // setTimeout(function() {
        hitung_tunai();
        // }, 1000);
    }

    function addItem() {
        var id = $('#item-select').val();
        const rangeId = $('#jumlah-baris').val();
        $.ajax({
            url: "<?= base_url('penjualan/get_item/') ?>" + id,
            type: "post",
            dataType: 'JSON',
            success: function(data) {
                console.log(data);
                $('#remove-null').remove();
                let item = `
                            <tr class="material" id="material-${rangeId}">
                                <td>
                                    <input type="hidden" class="form-control form-control-sm form-item" id="item-${rangeId}" name="item[]" value="${id}">
                                    ${data.nama} / ${data.satuan}
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-stock text-right" name="stock[]" id="stock-${rangeId}" value="${addCommas_general(data.stock)}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-qty text-right" name="qty[]" id="qty-${rangeId}" onchange="hitung_sub_total(${rangeId})" onkeyup="hitung_sub_total(${rangeId})" value="1" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-harga_jual text-right" name="harga_jual[]" id="harga_jual-${rangeId}" value="${addCommas_general(data.harga_jual)}" readonly>
                                </td>
                                <td>
                                    <input type="text" onchange="hitung_sub_total(${rangeId})" onkeyup="hitung_sub_total(${rangeId})" class="form-control form-control-sm form-diskon text-right" name="diskon[]" id="diskon-${rangeId}" value="0" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-sub_total text-right" name="sub_total[]" id="sub_total-${rangeId}" value="0" readonly>
                                </td>
                                
                                <td class="for-button text-center">
                                    <button href="#" onclick="hapus(${rangeId})" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>
                                </td>
                            </tr>
                            `;
                $('#table-belanja tbody').append(item);
                $('#item-select').val('');
                $('#jumlah-baris').val(parseInt(rangeId) + parseInt(1));
                get_item();
                setTimeout(function() {
                    hitung_tunai();
                }, 1000);
                hitung_sub_total(rangeId);
                $(":input").inputmask();
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
        hitungtotal();
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
        $('#table-stock').dataTable().fnDestroy();
        var oTable = $('#table-stock').dataTable({
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
                        return `<td class="text-right">Rp. ${addCommas_general(status)}</right>`;
                    }
                },
                {
                    "data": "harga_jual",
                    // "className": "text-right",
                    "render": function(data, type, oObj) {
                        var status = oObj['upah_darat'];
                        return `<td class="text-right">Rp. ${addCommas_general(status)}</right>`;
                    }
                },
                {
                    "data": "harga_jual",
                    // "className": "text-right",
                    "render": function(data, type, oObj) {
                        var status = oObj['upah_darat'];
                        return `<td class="text-right">Rp. ${addCommas_general(status)}</right>`;
                    }
                },

            ]
        })
    }
</script>