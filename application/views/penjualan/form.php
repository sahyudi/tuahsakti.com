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
    <section class="content">
        <div class="row">
            <div class="col-12">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Form Penjualan</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="<?= base_url('penjualan/save') ?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <!-- <div class="col-md-6"> -->
                                <!-- <div class="form-group col-md-6">
                                    <label for="">Transaksi ID</label>
                                    <input type="text" name="no_nota" id="no_nota" class="form-control" value="TR<?= time() ?>" placeholder="No nota" readonly style="background-color: white;">
                                </div> -->
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm" placeholder="No nota" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Costumer</label>
                                    <input type="text" name="customer" id="customer" class="form-control form-control-sm" placeholder="Costumer" style="background-color: white;">
                                </div>
                            </div>

                            <hr>
                            <h5>List Item</h5>
                            <div class="row">
                                <table class="table" id="table-material">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 35%;">Item / Satuan</th>
                                            <th>Stock</th>
                                            <th>Quantity</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                            <th>Upah / Satuan</th>
                                            <th>Sub Upah</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" id="jumlah-baris" value="1">
                                        <tr class="material" id="material-0">
                                            <td>
                                                <select onchange="getItem(this,0)" class="form-control form-control-sm form-item select2" id="item-0" name="item[]">
                                                    <option value="0">SELECT ITEM</option>
                                                    <?php foreach ($material as $key => $value) { ?>
                                                        <option value="<?= $value->id ?>"><?= $value->nama . " / " . $value->satuan ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control form-control-sm form-stock text-right" name="stock[]" id="stock-0" readonly></td>
                                            <td><input type="number" class="form-control form-control-sm form-qty text-right" name="qty[]" id="qty-0" onchange="hitung_sub_total(0)" onkeyup="hitung_sub_total(0)"></td>
                                            <td><input type="text" class="form-control form-control-sm form-harga_jual text-right" name="harga_jual[]" id="harga_jual-0" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm form-sub_total text-right" name="sub_total[]" id="sub_total-0" value="0" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm form-upah text-right" name="upah[]" id="upah-0" value="0" readonly></td>
                                            <td><input type="text" class="form-control form-control-sm form-sub_upah text-right" name="sub_upah[]" id="sub_upah-0" value="0" readonly></td>
                                            <td class="for-button">
                                                <button type="button" class="btn btn-info btn-sm btn-add" onclick="addItem()"><i class="fa fa-plus"></i></button>
                                            </td>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tunai</label>
                                        <input type="text" name="tunai" id="tunai" class="form-control form-control-sm text-right" onkeyup="hitung_tunai()" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Kredit</label>
                                        <input type="text" name="kredit" id="kredit" class="form-control form-control-sm text-right" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('pengadaan') ?>" class="btn btn-danger float-left">Back</a>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- end main content -->
</div>

<script type="text/javascript">
    // $(function() {
    //     //Initialize Select2 Elements
    //     $('.select2').select2();
    // });

    function addItem() {
        $('.select2').select2('destroy');
        const rangeId = $('#jumlah-baris').val()
        const item = $('#material-0').first().clone();
        $('#table-material tbody').append(item);
        const id = 'material-' + rangeId;
        item.attr('id', id);
        $('#' + id + ' .form-item').attr({
            'id': 'item-' + rangeId,
            'onchange': "getItem(this," + rangeId + ")"
        });
        $('#' + id + ' .form-stock').attr({
            'id': 'stock-' + rangeId
        }).val(0);
        $('#' + id + ' .form-upah').attr({
            'id': 'upah-' + rangeId
        }).val(0);
        $('#' + id + ' .form-sub_upah').attr({
            'id': 'sub_upah-' + rangeId
        }).val(0);
        $('#' + id + ' .form-qty').attr({
            'id': 'qty-' + rangeId,
            'onkeyup': 'hitung_sub_total(' + rangeId + ')',
            'onchange': 'hitung_sub_total(' + rangeId + ')'
        }).val(0);
        $('#' + id + ' .form-harga_jual').attr({
            'id': 'harga_jual-' + rangeId,
        }).val(0);
        $('#' + id + ' .form-sub_total').attr({
            'id': 'sub_total-' + rangeId
        }).val(0);
        $('#' + id + ' button').remove();

        var btn = '<button href="#" onclick="hapus(' + rangeId + ')" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>';
        $('#' + id + ' .for-button').append(btn);
        $('#jumlah-baris').val(parseInt(parseInt(rangeId) + 1));
        $(".select2").select2();
    }

    function hapus(params) {
        var id = 'material-' + params;
        $('#' + id).remove('');
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
        // if (qty > 0) {
        //     return_qty = qty;
        // } else {
        //     return_qty = 0;
        // }
        if (harga > 0) {
            return_harga = harga;
        } else {
            return_harga = 0;
        }

        $('#qty-' + id).val(addCommas(qty));
        $('#harga_jual-' + id).val(addCommas(return_harga));
        hitungtotal();
    }

    function hitungtotal() {
        const rangeId = $('#jumlah-baris').val();
        var sumHarga = 0;

        for (let index = 0; index < parseInt(rangeId); index++) {
            if ($('#sub_total-' + index).length != 0) {
                var SubTotal = $('#sub_total-' + index).val();
                if (SubTotal == null || SubTotal == '') {
                    SubTotal = 0;
                }
                sumHarga += parseInt(SubTotal.replace(/\,/g, ''));
            }
        }
        $('#total').html(addCommas(sumHarga));
        const kredit = sumHarga - $('#tunai').val().replace(/\,/g, '');
        $('#kredit').val(addCommas(kredit));
    }

    function getItem(id, urutan) {
        $.ajax({
            url: "<?= base_url('penjualan/get_item/') ?>" + id.value,
            type: "post",
            dataType: 'JSON',
            success: function(data) {
                $('#stock-' + urutan).val(addCommas(data.stock));
                $('#qty-' + urutan).val(1);
                $('#harga_jual-' + urutan).val(addCommas(data.harga_jual));
            }
        });
        // console.log(urutan)
        setTimeout(function() {
            hitung_sub_total(urutan);
        }, 200);
    }

    function hitung_tunai() {
        const total = parseInt($('#total').html().replace(/\,/g, ''));
        const tunai = $('#tunai').val().replace(/\,/g, '');
        if (tunai > total) {
            var tunai_baru = total;
        } else {
            var tunai_baru = tunai;
        }
        $('#kredit').val(addCommas(total - parseInt(tunai_baru)));
        $('#tunai').val(addCommas(tunai_baru));
    }

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    $('input[type="checkbox"]:checked').click(function() {
        var val = $(this).val();
        if (val == 'darat') {
            $('#laut').removeAttr('checked')
        } else {
            $('#darat').removeAttr('checked')
        }
    })
</script>
<!-- /.content-wrapper -->