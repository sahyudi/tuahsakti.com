<!--  -->
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
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Form Pengadaan</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="<?= base_url('pengadaan/save') ?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Surat Jalan</label>
                                    <input type="text" name="surat_jalan" id="surat_jalan" class="form-control form-control-sms">
                                    <!-- <select class="form-control form-control-sm select2" style="width:100%;" name="surat_jalan" id="surat_jalan">
                                        <option value=""></option>
                                        <?php foreach ($momor_pengjuan as $key => $value) { ?>
                                            <option value="<?= $value->no_pendanaan ?>"><?= $value->no_pendanaan ?></option>
                                        <?php } ?>
                                    </select> -->
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm" placeholder="No nota" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Vendor</label>
                                    <select class="form-control form-control-sm select2" name="vendor" id="vendor">
                                        <option value=""></option>
                                        <?php foreach ($vendor as $key => $value) { ?>
                                            <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" rows="1"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Item List</label>
                                    <select name="item-select" id="item-select" onchange="addItem()" class="form-control form-control-sm select2" onchange="addItem()">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <h5>List Item</h5>
                            <div class="row">
                                <table class="table" id="table-material">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 35%;">Item / Satuan</th>
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
                            <a href="<?= base_url('pengadaan') ?>" class="btn btn-danger btn-sm float-left">Back</a>
                            <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- end main content -->
</div>

<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2({
            'placeholder': 'Select one',
            theme: 'boostrap4',
        });
        $(":input").inputmask();
        get_item()
    });

    function addItem() {
        var id = $('#item-select').val();
        const rangeId = $('#jumlah-baris').val();
        $.ajax({
            url: "<?= base_url('pos/get_item_pengadaan/') ?>" + id,
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
                                    <input type="text" class="form-control form-control-sm form-qty text-right" name="qty[]" id="qty-${rangeId}" onkeyup="hitung_sub_total(${rangeId})" value="1" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                </td>
                                <td>
                                    <input type=" text" class="form-control form-control-sm form-harga_beli text-right" name="harga_beli[]" id="harga_beli-${rangeId}" onkeyup="hitung_sub_total(${rangeId})" value="${data.harga_beli}" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-sub_total text-right" name="sub_total[]" id="sub_total-${rangeId}" readonly data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-upah text-right" name="upah[]" id="upah-${rangeId}" value="${data.upah_laut}" onkeyup="hitung_upah()" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm form-sub_upah text-right" name="sub_upah[]" id="sub_upah-${rangeId}" value="0" readonly data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits':0, 'digitsOptional': false, 'prefix':'', 'placeholder': ''">
                                </td>
                                <td class="for-button text-center">
                                    <button type="button" class="btn btn-danger btn-sm btn-add" onclick="hapus(${rangeId})"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            `;
                $('#table-material tbody').append(item);
                $('#item-select').val('');
                $('#jumlah-baris').val(parseInt(rangeId) + parseInt(1));
                get_item();
                $(":input").inputmask();
                setTimeout(function() {
                    hitung_sub_total(rangeId)

                }, 1000);
            }
        });


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


    function hapus(params) {
        var id = 'material-' + params;
        $('#' + id).remove('');
        hitungtotal()
    }


    function hitung_sub_total(id) {
        var sisaStock = 0;
        var upah_sub = 0;
        const qty = parseInt($('#qty-' + id).val().replace(/\,/g, ''));
        const harga = parseInt($('#harga_beli-' + id).val().replace(/\,/g, ''));

        const upah = parseInt($('#upah-' + id).val().replace(/\,/g, ''));

        sisaStock = qty * harga;
        upah_sub = qty * upah;
        if (sisaStock > 0) {
            $('#sub_total-' + id).val(addCommas_general(sisaStock));
        } else {
            $('#sub_total-' + id).val(0);
        }
        if (qty > 0) {
            return_qty = qty;
        } else {
            return_qty = 0;
        }
        if (harga > 0) {
            return_harga = harga;
        } else {
            return_harga = 0;
        }
        $('#qty-' + id).val(addCommas_general(return_qty));
        $('#sub_upah-' + id).val(upah_sub);
        $('#harga_beli-' + id).val(addCommas_general(return_harga));
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
        $('#total').html(addCommas_general(sumHarga));
        const kredit = sumHarga - $('#tunai').val().replace(/\,/g, '');
        $('#kredit').val(addCommas_general(kredit))
        // console.log(sumHarga);
    }

    function getItem(id, urutan) {
        //     $.ajax({
        //         url: "<?= base_url('pengadaan/get_satuan/') ?>" + id.value,
        //         type: "post",
        //         dataType: 'JSON',
        //         success: function(data) {
        //             $('#satuan-' + urutan).html(data.satuan);
        //         }
        //     });
    }

    function hitung_tunai() {
        const total = parseInt($('#total').html().replace(/\,/g, ''));
        const tunai = $('#tunai').val().replace(/\,/g, '');
        if (tunai > total) {
            var tunai_baru = total;
        } else {
            var tunai_baru = tunai;
        }
        $('#kredit').val(addCommas_general(total - parseInt(tunai_baru)));
        $('#tunai').val(addCommas_general(tunai_baru));
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