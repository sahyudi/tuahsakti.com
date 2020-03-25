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
                    <form action="<?= base_url('project/save_project') ?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm" placeholder="No nota" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Name</label>
                                    <input type="text" name="nama" id="nama" class="form-control form-control-sm" placeholder="Nama Proyek">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Anggaran (Rp.)</label>
                                    <input type="text" class="form-control form-control-sm text-right" id="anggaran" name="anggaran" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'prefix': '', 'placeholder': 'Rp. '">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Deskripsi</label>
                                    <textarea name="deksripsi" id="deksripsi" class="form-control form-control-sm" rows="2"></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Item List</label>
                                    <select name="item-select" id="item-select" onchange="addItem()" class="form-control form-control-sm select2" onchange="addItem()">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <h5>List Item</h5>
                            <div class="row">
                                <table id="table-belanja" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 25%;">Item / Satuan</th>
                                            <th>Quantity</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" id="jumlah-baris" value="1">
                                        <tr id="remove-null">
                                            <td colspan="5" class="text-center">Item Belum dipilih</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right">TOTAL</td>
                                            <td class="text-right">Rp. <span id="total"></span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= base_url('project') ?>" class="btn btn-danger float-left">Back</a>
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
    $(document).ready(function() {
        get_item();
        $(":input").inputmask();
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
        const qty_awal = parseInt($('#qty-' + id).val().replace(/\,/g, ''));
        const harga = parseInt($('#harga-' + id).val().replace(/\,/g, ''));
        if (qty_awal < 1 || qty_awal == 'NaN') {
            var qty = 1;
        }else{
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

        $('#qty-' + id).val(addCommas(qty));
        $('#harga-' + id).val(addCommas(return_harga));
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
                                        ${data.nama}
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm form-qty text-right" name="qty[]" id="qty-${rangeId}" onchange="hitung_sub_total(${rangeId})" onkeyup="hitung_sub_total(${rangeId})" value="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm form-harga text-right" name="harga[]" id="harga-${rangeId}" onchange="hitung_sub_total(${rangeId})" onkeyup="hitung_sub_total(${rangeId})" value="0">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm form-sub_total text-right" name="sub_total[]" id="sub_total-${rangeId}" value="0" readonly>
                                    </td>
                                    <td class="for-button">
                                        <button href="#" onclick="hapus(${rangeId})" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>
                                    </td>
                                </tr>
                            `;
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

    function hanya_angka(val) {
        var nilai = $('#anggaran').val().replace(/\,/g, '');
        console.log(nilai);
        $('#anggaran').val(addCommas(nilai));
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